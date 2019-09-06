<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\CreateUser;
use App\Models\TempRegist;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class TempRegistModelTest extends TestCase
{
    use DatabaseMigrations;
    use CreateUser;

    /**
     * testMakeUniqToken
     *
     * @return void
     */
    public function testMakeUniqToken()
    {
        $temp_users = factory(TempRegist::class, 1000)->create()->toArray();

        $token = TempRegist::makeUniqToken();
        $cnt = TempRegist::whereToken($token)->count();
        $this->assertEquals(0, $cnt);
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
        $rules = TempRegist::validate();
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
     * temp_registsに登録されたemailはvalidtionエラーになること
     *
     * @return void
     */
    public function testValidationTempRegistsUniqueEmail()
    {
        $temp_user = factory(TempRegist::class)->create()->toArray();

        $data_list = ['email' => $temp_user['email']];
        $rules = TempRegist::validate();
        $target_rule = ['email' => $rules['email']];

        $validator = Validator::make($data_list, $target_rule);
        $result = $validator->passes();
        $this->assertFalse($result);
    }

    /**
     * usersに登録されたemailはvalidtionエラーになること
     *
     * @return void
     */
    public function testValidationUsersUniqueEmail()
    {
        $temp_user = factory(TempRegist::class)->create()->toArray();

        $data_list = ['email' => $temp_user['email']];
        $rules = TempRegist::validate();
        $target_rule = ['email' => $rules['email']];

        $validator = Validator::make($data_list, $target_rule);
        $result = $validator->passes();
        $this->assertFalse($result);
    }

    public function dataprovider4Validation()
    {
        $faker = \Faker\Factory::create('ja_JP');
        return [
            //email
            'email success' => ['email', $faker->safeEmail, true],
            'email fail require' => ['email', null, false],
        ];
    }
}
