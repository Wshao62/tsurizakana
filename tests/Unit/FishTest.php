<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\CreateUser;
use Illuminate\Http\UploadedFile;
use \App\Models\User;
use \App\Models\Order;
use \App\Models\Fish;
use \App\Models\Fish\Category;
use \App\Models\Fish\Photo;
use Illuminate\Support\Facades\Validator;

class FishTest extends TestCase
{
    use DatabaseMigrations;
    use CreateUser;

    /**
     * 新規登録が正常に登録される
     *
     */
    public function testRegisterSuccess()
    {
        $attributes = $this->prepareAddParameters();
        $user = $this->createUser();

        $this->actingAs($user, 'user');
        $fish = Fish::register($attributes);

        $this->assertInstanceOf(Fish::class, $fish);

        $fish_cnt = Fish::find($fish['id'])->count();
        $this->assertEquals(1, $fish_cnt);

        $category_cnt = Category::find($fish['fish_category_id'])->count();
        $this->assertEquals(1, $category_cnt);

        $photo_cnt = Photo::whereFishId($fish['id'])->count();
        $this->assertEquals(1, $photo_cnt);

        // TODO: 画像が保存されたかのチェック
    }

    /**
     * 新規登録時に同じcategoryは挿入されないこと
     *
     */
    public function testRegisterNotInsertSameCategory()
    {
        $category = factory(Category::class)->create()->toArray();
        $attributes = $this->prepareAddParameters();
        $attributes['fish_category_name'] = $category['name'];
        $user = $this->createUser();

        $before_category_cnt = Category::whereName($attributes['fish_category_name'])->count();

        $this->actingAs($user, 'user');
        $fish = Fish::register($attributes);

        $this->assertInstanceOf(Fish::class, $fish);

        $current_category_cnt = Category::whereName($fish['fish_category_name'])->count();
        $this->assertEquals($before_category_cnt, $current_category_cnt);
    }

    /**
     * 新規登録厨に異常が起き他場合はDBがrollbackし、falseが返却されること
     */
    public function testRegisterFailSafe()
    {
        $user = $this->createUser();

        $this->actingAs($user, 'user');
        $rtn = Fish::register([]);

        $this->assertFalse($rtn);

        $fish_cnt = Fish::count();
        $this->assertEquals(0, $fish_cnt);
        $category_cnt = Category::count();
        $this->assertEquals(0, $category_cnt);
        $photo_cnt = Photo::count();
        $this->assertEquals(0, $photo_cnt);

        // TODO: 画像が保存されていないことのチェック
    }

    // TODO: 写真を複数枚アップロードできること

    /**
     * prepareAddParameters
     *
     * @return void
     */
    private function prepareAddParameters()
    {
        //TODO: 画像のデータを用意
        $img = UploadedFile::fake()->image('img3.gif', 300, 400)->size(4999);

        $fish = factory(Fish::class)->make()->toArray();
        return [
            'fish_category_name' => $fish['fish_category_name'],
            'location' => $fish['location'],
            'price' => $fish['price'],
            'description' => $fish['description'],
            'photo' => [
                    [
                        'tmp_path' => $img->path(),
                        'mime' => $img->getClientMimeType(),
                    ],
                ],
        ];
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
    public function testValidation($item, $data, $expect, $type = null)
    {
        if (strpos($item, '.*') === false) {
            $data_list = [$item => $data];
        } else {
            list($key, $dummy) = preg_split('/\.\*\.?/', $item);
            $data_list = [$key => $data];
        }
        $rules = Fish::validate($type);
        $target_rule = [$item => $rules[$item]];

        $validator = Validator::make($data_list, $target_rule);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    public function dataprovider4Validation()
    {
        $faker = \Faker\Factory::create('ja_JP');

        return [
            //fish_category_name
            'fish_category_name success' => ['fish_category_name', mb_substr($faker->realText, 0, rand(1, 30)), true],
            'fish_category_name fail require' => ['fish_category_name', null, false],
            'fish_category_name fail max:30 with 31' => ['fish_category_name', mb_substr($faker->realText, 0, 31), false],
            'fish_category_name success max:30 with 30 ' => ['fish_category_name', mb_substr($faker->realText, 0, 30), true],
            'fish_category_name success max:30 with 29' => ['fish_category_name', mb_substr($faker->realText, 0, 29), true],

            //location
            'location success' => ['location', $faker->address, true],
            'location fail require' => ['location', null, false],
            'location fail max:100 with 101' => ['location', str_repeat('場', 101), false],
            'location success max:100 with 100 ' => ['location', str_repeat('場', 100), true],
            'location success max:100 with 99' => ['location', str_repeat('場', 99), true],

            //price
            'price success' => ['price', rand(100, 1000), true],
            'price fail require' => ['price', null, false],
            'price fail integer' => ['price', $faker->word, false],
            'price fail min:100 with 99 ' => ['price', 99, false],
            'price success min:100 with 100 ' => ['price', 100, true],
            'price success min:100 with 101' => ['price', 101, true],

            //description
            'description success' => ['description', $faker->realText, true],
            'description fail require' => ['description', null, false],
            'description fail max:1000 with 1001' => ['description', str_repeat('詳', 1001), false],
            'description success max:1000 with 1000 ' => ['description', str_repeat('詳', 1000), true],
            'description success max:1000 with 999' => ['description', str_repeat('詳', 999), true],

            //photo
            'photo success' => ['photo', ['a', 'b', 'c'], true],
            'photo fail required' => ['photo', null, false],
            'photo success required on edit' => ['photo', null, true, 'edit'],
            'photo fail between:1,3 with 4' => ['photo', ['a', 'b', 'c', 'd'], false],
            'photo success between:1,3 with 3' => ['photo', ['a', 'b', 'c'], true],
            'photo success between:1,3 with 2' => ['photo', ['a', 'b'], true],

            //photo.*
            'photo.* success' => ['photo.*', [UploadedFile::fake()->image('img1.jpg', 300, 400)->size(1000)], true],
            'photo.* fail image with pdf' => ['photo.*', [UploadedFile::fake()->create('test.pdf', 1000)], false],
            'photo.* fail max:5000 with 5001' => ['photo.*', [UploadedFile::fake()->image('img1.jpg', 300, 400)->size(5001)], false],
            'photo.* success max:5000 with 5000' => ['photo.*', [UploadedFile::fake()->image('img2.png', 300, 400)->size(5000)], true],
            'photo.* success max:5000 with 4999' => ['photo.*', [UploadedFile::fake()->image('img3.gif', 300, 400)->size(4999)], true],

            //photo.*.tmp_path
            'photo.*.tmp_path success' => ['photo.*.tmp_path', [['tmp_path' => $faker->word]], true, 'store'],
            'photo.*.tmp_path fail null' => ['photo.*.tmp_path', [['tmp_path' => null ]], false, 'store'],

            //photo.*.mime
            'photo.*.mime success' => ['photo.*.mime', [['mime' => 'image/jpeg']], true, 'store'],
            'photo.*.mime fail null' => ['photo.*.mime', [['mime' => null ]], false, 'store'],
            'photo.*.mime success mime image' => ['photo.*.mime', [
                            ['mime' => 'image/jpeg'],
                            ['mime' => 'image/png'],
                            ['mime' => 'image/gif'],
                            ['mime' => 'image/bmp']],
                        true, 'store'],
            'photo.*.mime fail mime image with text/plains' => ['photo.*.mime', [['mime' => 'text/plain' ]], false, 'store'],

        ];
    }


    /**
     * canOrder
     */
    public function testCanOrder()
    {
        $can_buy_fish = factory(Fish::class)->create(['status' => Fish::STATUS_PUBLISH]);
        $can_not_buy_fish = factory(Fish::class)->create(['status' => Fish::STATUS_PRIVATE]);

        $this->assertTrue($can_buy_fish->canOrder());
        $this->assertFalse($can_not_buy_fish->canOrder());
    }

    /**
     * getStatus
     * @dataProvider dataprovider4GetStatus
     */
    public function testGetStatus($status, $expect)
    {
        $fish = factory(Fish::class)->create(['status' => $status]);
        $this->assertEquals($expect, $fish->getStatus());
    }

    public function dataprovider4GetStatus()
    {
        $rtn = [];
        foreach (Fish::STATUS_NAMES as $status => $name) {
            $rtn['data:'.$status.' -> expected '.$name] = [$status, $name];
        }
        return $rtn;
    }

    /**
     * testgetPublicStatus
     * @dataProvider dataprovider4GetStatus
     */
    public function testgetPublicStatus($status, $expect)
    {
        foreach (Fish::STATUS_NAMES as $status => $name) {
            $fish = factory(Fish::class)->create(['status' => $status]);
            $this->assertEquals($name, $fish->getStatus());
        }
    }

    public function dataprovider4GetPublicStatus()
    {
        $rtn = [];
        foreach (Fish::STATUS_NAMES as $status => $name) {
            if ($status > Fish::STATUS_PUBLISH
            &&  $status < Fish::STATUS_REJECT) {
                $name = '売却済み';
            }
            $rtn['data:'.$status.' -> expected '.$name] = [$status, $name];
        }
        return $rtn;
    }

    /**
     * fishに対するOrderが正しく取得できること。存在しない場合は作成する
     */
    public function testGetOrderOrCreateSuccess()
    {
        $buyer = factory(User::class)->create();
        $seller = factory(User::class)->create();
        $fish = factory(Fish::class)->create();

        \Auth::shouldReceive('user')
        ->andReturn($buyer);

        $new_order = $fish->getOrderOrCreate(1);

        $this->assertInstanceOf(Order::class, $new_order);
        $this->assertEquals(1, Order::count());

        //２度目の実行も挿入されずにすでにある値が取得されること
        $same_order = $fish->getOrderOrCreate(1);

        $this->assertArraySubset($new_order->toArray(), $same_order->toArray());
        $this->assertEquals(1, Order::count());
    }
}
