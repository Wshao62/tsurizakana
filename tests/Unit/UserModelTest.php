<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\CreateUser;
use App\Models\TempRegist;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserModelTest extends TestCase
{
    use DatabaseMigrations;
    use CreateUser;

    /**
     * regist実行時、紐づくtemp_regists削除され、usersテーブルに値が入ること
     *
     * @return void
     */
    public function testRegistWithTempUser()
    {
        $temp_user = factory(TempRegist::class)->create()->toArray();

        $registering_data = factory(User::class)->make()->toArray();
        $registering_data['email'] = $temp_user['email'];
        $registering_data['password'] = '$2y$10$Fn8PAyd60P1hY3aeTvmzBeKYQ1N0PsIZVg4QofQ0JMAo/Kjg3tAWy'; //password123

        $user = User::register($registering_data);
        $this->assertInstanceOf(User::class, $user);

        $db_data = User::find($user['id']);
        $this->assertInstanceOf(User::class, $db_data);

        $db_temp_data = TempRegist::find($user['email']);
        $this->assertEmpty($db_temp_data);
    }

    /**
     * regist実行時、usersテーブルに値が入ること(紐づくtemp_registsはいない)
     *
     * @return void
     */
    public function testRegistWithoutTempUser()
    {
        $temp_user_cnt = 10;
        $temp_users = factory(TempRegist::class, $temp_user_cnt)->create()->toArray();

        $registering_data = factory(User::class)->make()->toArray();
        $registering_data['password'] = '$2y$10$Fn8PAyd60P1hY3aeTvmzBeKYQ1N0PsIZVg4QofQ0JMAo/Kjg3tAWy'; //password123

        $user = User::register($registering_data);
        $this->assertInstanceOf(User::class, $user);

        $db_data = User::find($user['id']);
        $this->assertInstanceOf(User::class, $db_data);

        $this->assertEquals($temp_user_cnt, TempRegist::count());
    }

    /**
     * regist時にエラーがあるとfalseが返却され、トランザクションが実行されていないこと
     * (null許容していない値を空で登録してみるパターンでテスト)
     * @return void
     */
    public function testRegistSameEmail()
    {
        $temp_user = factory(TempRegist::class)->create()->toArray();

        //nameがnull
        $registering_data = factory(User::class)->make()->toArray();
        $registering_data['email'] = $temp_user['email'];
        unset($registering_data['name']);

        $rtn = User::register($registering_data);
        $this->assertFalse($rtn);

        $this->assertEquals(0, User::count());

        $db_temp_rtn = TempRegist::find($registering_data['email']);
        $this->assertInstanceOf(TempRegist::class, $db_temp_rtn);
    }

    /**
     * testValidation
     *
     * @param  string $item 項目名
     * @param  string $data 入力値
     * @param  boolean $expect 期待値 (true:validtionOK/false:validationZNG)
     *
     * @return void
     * @dataProvider dataprovider4Validation
     */
    public function testValidation($item, $data, $expect, $confirmed_data = null)
    {
        $data_list = [$item => $data];
        $rules = User::validate();
        $target_rule = [$item => $rules[$item]];

        if (!empty($confirmed_data)) {
            // confirmedが設定されているものに関しては確認項目をデータリストに追加する
            $data_list[$item.'_confirmation'] = $confirmed_data;
        }

        $validator = Validator::make($data_list, $target_rule);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    /**
     * 同じemailがvalidtionエラーになること
     *
     * @return void
     */
    public function testValidationUniqueUsers()
    {
        $user = $this->createUser();
        $data_list = ['email' => $user['email']];
        $rules = User::validate();
        $target_rule = ['email' => $rules['email']];

        $validator = Validator::make($data_list, $target_rule);
        $result = $validator->passes();
        $this->assertFalse($result);
    }

    public function dataprovider4Validation()
    {
        $faker = \Faker\Factory::create('ja_JP');

        $password_success = $faker->bothify('******');
        $password_fail_min = $faker->bothify('*****');
        return [
            //email
            'email success' => ['email', $faker->safeEmail, true],
            'email fail require' => ['email', null, false],

            // name
            'name success' => ['name', $faker->name, true],
            'name fail require' => ['name', null, false],
            'name fail max:50' => ['name', str_repeat('名', '51'), false],
            'name success max:50' => ['name', str_repeat('名', '50'), true],

            // password
            'password success' => ['password', $password_success, true, $password_success],
            'password fail require' => ['password', null, false, null],
            'password fail min:6' => ['password', $password_fail_min, false, $password_fail_min],
            'password fail confirmed' => ['password', $faker->unique()->bothify('******'), false, $faker->unique()->bothify('******')],

            // furigana
            'furigana success' => ['furigana', $faker->kanaName, true],
            'furigana fail require' => ['furigana', null, false],
            'furigana fail furigana' => ['furigana', $faker->bothify('************'), false],

            // zipcode
            'zipcode success' => ['zipcode', $faker->postcode, true],
            'zipcode success with hyphen' => ['zipcode', $faker->bothify('###-####'), true],
            'zipcode fail required' => ['zipcode', null, false],
            'zipcode fail zip' => ['zipcode', $faker->bothify('????????'), false],
            'zipcode fail zip' => ['zipcode', $faker->bothify('########'), false], //8文字

            // prefecture
            'prefecture success' => ['prefecture', $faker->prefecture, true],
            'prefecture fail required' => ['prefecture', null, false],
            'prefecture fail not in prefectures' => ['prefecture', $faker->word, false],

            // address
            'public_address success' => ['public_address', $faker->city. $faker->address, true],
            'public_address fail required' => ['public_address', null, false],
            'public_address fail max:100' => ['public_address', str_repeat('名', '101'), false],
            'public_address success max:100' => ['public_address', str_repeat('名', '100'), true],

            // private_address
            'private_address success' => ['private_address', $faker->city. $faker->address, true],
            'private_address fail required' => ['private_address', null, false],
            'private_address fail max:100' => ['private_address', str_repeat('名', '101'), false],
            'private_address success max:100' => ['private_address', str_repeat('名', '100'), true],

            // mobile_tel
            'mobile_tel success' => ['mobile_tel', $faker->phoneNumber, true],
            'mobile_tel fail required' => ['mobile_tel', null, false],
            'mobile_tel fail phone' => ['mobile_tel', $faker->word, false],

            // tel
            'tel success' => ['tel', $faker->phoneNumber, true],
            'tel success with null' => ['tel', null, true],
            'tel fail phone' => ['tel', $faker->word, false],
        ];
    }
}
