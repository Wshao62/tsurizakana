<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Fish;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class OrderTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * fishリレーションのテスト
     */
    public function testRelationFish()
    {
        $fish_array = factory(Fish::class, 20)->create();
        $target_fish = $fish_array[rand(0, 19)];
        $order = factory(Order::class)->create(['item_id' => $target_fish['id']]);

        $this->assertEquals($target_fish->toArray(), $order->fish->toArray());
    }

    /**
     * execOrderをテスト
     */
    public function testExecOrder()
    {
        $order = factory(Order::class)->create();
        $data = $order->toArray();

        $mock = \Mockery::mock(EpsilonHelper::class);
        $mock->shouldReceive('setParams')
                    ->with($data)
                    ->andReturnNull();
        $mock->shouldReceive('execRequest')
                    ->andReturn(true);

        $this->callMethod($order, 'initialEpsilonHelper', [null, $mock]);
        $rtn = $order->execOrder();
        $this->assertTrue($rtn);
    }

     /**
     * completeをテスト
     */
    public function testCompleteOK()
    {
        Notification::fake();

        $helper_rtn = [
            'result' => true,
            'payment_code' => 2,
            'item_code' => 1,
            'order_number' => 1,
        ];
        list($seller, $buyer, $fish, $order, $same_order, $helper_mock) = $this->prepare2testComplete($helper_rtn);
        $this->callMethod($order, 'initialEpsilonHelper', [null, $helper_mock]);

        $data = [
            'trans_code' => 1111111,
        ];
        $rtn = $order->complete($data);

        //結果がtrueであること
        $this->assertTrue($rtn['result']);

        //orderにtranscodeとcompleted_atが挿入されたこと
        $order['trans_code'] = 1111111;
        unset($order['updated_at']);
        unset($order['completed_at']);
        $this->assertArraySubset($order->toArray(), $rtn['order']->toArray());
        $this->assertNotNull($rtn['order']['completed_at']);

        //Orderが複数あった時にもう一つは削除されてること
        $this->assertNull(Order::find($same_order->id));

        //fishのステータスが変わっていること
        $fish['status'] = Fish::STATUS_DELIVERY;
        unset($order['buyer_id']);
        $this->assertArraySubset($fish->toArray(), $rtn['fish']->toArray());

        //メールが送信されること
        Notification::assertSentTo(
            [$seller],
            \App\Notifications\Fish\PayCompleteNotification::class
        );
        Notification::assertSentTo(
            [$seller],
            \App\Notifications\Fish\PayCompleteNotification::class
        );
    }

    /**
     * completeでepsilonhelperがresult=falseを返すテスト
     */
    public function testCompleteNgAsResultFalse()
    {
        $helper_rtn = [
            'result' => false,
            'message' => 'エラーです。', //このエラーがヘルパーの中で起こった想定
        ];
        list($seller, $buyer, $fish, $order, $same_order, $helper_mock) = $this->prepare2testComplete($helper_rtn);
        $this->callMethod($order, 'initialEpsilonHelper', [null, $helper_mock]);

        $data = [
            'trans_code' => 1111111,
        ];
        $rtn = $order->complete($data);

        $this->assertFalse($rtn['result']);
        $this->assertEquals($helper_rtn['message'], $rtn['message']);

        //エラーとなったのでDBに変更がないこと
        $this->assertArraySubset($order->toArray(), Order::find($order->id)->toArray());
        $this->assertArraySubset($fish->toArray(), Fish::find($fish->id)->toArray());
    }

    /**
     * ompleteでepsilonhelperのpayment_codeがconfigの値以外だったとき
     */
    public function testCompleteNgAsPaymentCodeNotAuthorized()
    {
        $helper_rtn = [
            'result' => true,
            'payment_code' => 3, // 1,2 がイプシロンのクレジットカード
        ];
        list($seller, $buyer, $fish, $order, $same_order, $helper_mock) = $this->prepare2testComplete($helper_rtn);
        $this->callMethod($order, 'initialEpsilonHelper', [null, $helper_mock]);

        $data = [
            'trans_code' => 1111111,
        ];
        $rtn = $order->complete($data);

        $this->assertFalse($rtn['result']);
        $this->assertEquals('不正な支払いコードです', $rtn['message']);
    }

    /**
     * ompleteでorderが見つからない時のテスト
     */
    public function testCompleteNgAsOrderNotFound()
    {
        $helper_rtn = [
            'result' => true,
            'payment_code' => 1,
            'order_number' => 99, //存在しないオーダー番号
        ];
        list($seller, $buyer, $fish, $order, $same_order, $helper_mock) = $this->prepare2testComplete($helper_rtn);
        $this->callMethod($order, 'initialEpsilonHelper', [null, $helper_mock]);

        $data = [
            'trans_code' => 1111111,
        ];
        $rtn = $order->complete($data);

        $this->assertFalse($rtn['result']);
        $this->assertEquals('オーダーが見つかりません。', $rtn['message']);
    }

    /**
     * completeでDBエラー時にデータがロールバックされてること

     */
    public function testCompleteDbErrorRollbackWell()
    {
        $helper_rtn = [
            'result' => true,
            'payment_code' => 2,
            'item_code' => 1,
            'order_number' => 1,
        ];
        $override_order = ['item_id' => 3]; //存在しないfishでfatal errorを発生させてみる
        list($seller, $buyer, $fish, $order, $same_order, $helper_mock) = $this->prepare2testComplete($helper_rtn, $override_order);
        $this->callMethod($order, 'initialEpsilonHelper', [null, $helper_mock]);

        $data = [
            'trans_code' => 1111111,
        ];
        $rtn = $order->complete($data);

        $this->assertFalse($rtn['result']);
        $this->assertEquals('Call to a member function updater() on null', $rtn['message']);

        // //エラーとなったのでDBに変更がないこと
        $this->assertArraySubset($order->toArray(), Order::find($order->id)->toArray());
        $this->assertNotNull(Order::find($same_order->id));
        $this->assertArraySubset($fish->toArray(), Fish::find($fish->id)->toArray());
    }

    /**
     * prepare2testComplete
     *
     * @return [$seller, $buyer, $fish, $order, $same_order, $helper_mock]
     */
    private function prepare2testComplete($rtn_exec_req = null, $order = [])
    {
        $buyer = factory(User::class)->create();
        $seller = factory(User::class)->create();
        $fish = factory(Fish::class)->create(['seller_id' => $seller['id']]);
        $order = factory(Order::class)->create($order);
        $same_order = factory(Order::class)->create([
            'item_id' => 1,
            'price' => $order['price'],
            'process_code' => 2,
            ]);

        \Auth::shouldReceive('user')
        ->andReturn($buyer);


        $helper_mock = \Mockery::mock(EpsilonHelper::class);
        $helper_mock->shouldReceive('setParams')
                    ->andReturnNull();
        $helper_mock->shouldReceive('execRequest')
                    ->andReturn($rtn_exec_req);


        return [$seller, $buyer, $fish, $order, $same_order, $helper_mock];
    }

    /**
     * testValidation
     *
     * @param  string $item 項目名
     * @param  string $data 入力値
     * @param  boolean $expect 期待値 (true:validtionOK/false:validationZNG)
     *
     * @dataProvider dataprovider4Validation
     */
    public function testValidation($item, $data, $expect, $validate_method = 'validate')
    {
        $user = factory(User::class)->create();
        $fish = factory(Fish::class)->create(['seller_id' => $user['id']]);
        $order = factory(Order::class)->create([
            'item_id' => $fish['id'],
            'item_name' => $fish['fish_category_name'],
            'price' => $fish['price'],
            ]);
        \Auth::shouldReceive('user')
            ->andReturn($user);

        $data_list = [$item => $data];

        $rules = Order::$validate_method();
        $target_rule = [$item => $rules[$item]];

        $validator = Validator::make($data_list, $target_rule);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    public function dataprovider4Validation()
    {
        $faker = \Faker\Factory::create('ja_JP');

        return [
            //fish_id
            'fish_id OK' => ['fish_id', 1, true],
            'fish_id NG required' => ['fish_id', null, false],
            'fish_id NG integer' => ['fish_id', $faker->text, false],
            'fish_id NG exists' => ['fish_id', 2, false],

            //process_code
            'process_code OK with 1' => ['process_code', 1, true],
            'process_code OK with 2' => ['process_code', 2, true],
            'process_code NG required' => ['process_code', null, false],
            'process_code NG integer' => ['process_code', $faker->text, false],
            'process_code NG with 3' => ['process_code', 3, false],

            //order_number
            'order_number OK' => ['order_number', 1, true, 'orderCompleteValidate'],
            'order_number NG required' => ['order_number', null, false, 'orderCompleteValidate'],
            'order_number NG required' => ['order_number', $faker->text, false, 'orderCompleteValidate'],
            'order_number NG min:1' => ['order_number', 0, false, 'orderCompleteValidate'],
            'order_number NG exists' => ['order_number', 2, false, 'orderCompleteValidate'],

            //order_number orderBackValidate
            'order_number4back OK' => ['order_number', 1, true, 'orderBackValidate'],
            'order_number4back NG required' => ['order_number', null, false, 'orderBackValidate'],
            'order_number4back NG required' => ['order_number', $faker->text, false, 'orderBackValidate'],
            'order_number4back NG min:1' => ['order_number', 0, false, 'orderBackValidate'],
            'order_number4back NG exists' => ['order_number', 2, false, 'orderBackValidate'],

            //trans_code
            'trans_code OK' => ['trans_code', 1, true, 'orderCompleteValidate'],
            'trans_code NG required' => ['trans_code', null, false, 'orderCompleteValidate'],
            'trans_code NG integer' => ['trans_code', $faker->text, false, 'orderCompleteValidate'],
            'trans_code NG min:1' => ['trans_code', 0, false, 'orderCompleteValidate'],

            //result
            'result OK' => ['result', 1, true, 'orderCompleteValidate'],
            'result NG required' => ['result', null, false, 'orderCompleteValidate'],
            'result NG boolean' => ['result', 'abcded', false, 'orderCompleteValidate'],

            //user_id
            'user_id OK' => ['user_id', 1, true, 'orderCompleteValidate'],
            'user_id NG required' => ['user_id', null, false, 'orderCompleteValidate'],
            'user_id NG integer' => ['user_id', $faker->text, false, 'orderCompleteValidate'],
            'user_id NG min:1' => ['user_id', 0, false, 'orderCompleteValidate'],
            'user_id NG same as auth::user()' => ['user_id', 2, false, 'orderCompleteValidate'],
        ];
    }
}
