<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use \App\Models\Notification\ContactNotification;
use \App\Http\Requests\ContactPost;
use \App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Validator;

class ServiceContactsTest extends TestCase
{
    /**
    *  お問い合わせ欄正常系
    *
    * @dataProvider servicedataproviderURLs
    */
    public function testServiceContact($data)
    {
        $this->post('contact', $data)
        ->assertSessionHasNoErrors(['name'])
        ->assertSessionHasNoErrors(['tel1'])
        ->assertSessionHasNoErrors(['tel2'])
        ->assertSessionHasNoErrors(['tel3'])
        ->assertSessionHasNoErrors(['contact_email'])
        ->assertSessionHasNoErrors(['description'])
        ->assertSessionHasNoErrors(['form_company'])
        ->assertSessionHasNoErrors(['postal_code'])
        ->assertSessionHasNoErrors(['prefect'])
        ->assertSessionHasNoErrors(['addr1'])
        ->assertSessionHasNoErrors(['addr2']);
    }

    /**
     * testValidation
     *
     * @param  string $item 項目名
     * @param  string $data 入力値
     * @param  boolean $expect 期待値 (true:validtionOK/false:validationZNG)
     *
     * @return void
     * @dataProvider servicedataproviderValidation
     */
    public function testServiceValidation($item, $data, $expect)
    {
        $data_list = [$item => $data];
        $request = new ContactPost();
        //フォームリクエストで定義したルールを取得
        $rules = $request->rules("nullable");
        $target_rule = [$item => $rules[$item]];
        $validator = Validator::make($data_list, $target_rule);
        $result = $validator->passes();
        $this -> assertEquals($expect, $result);
    }

    /*
    * URLのデータプロバイダ
    *
    */
    public function servicedataproviderURLs()
    {

        $faker = \Faker\Factory::create('ja_JP');
        $data = [
          'name' => $faker->name,
          'tel1' => $faker->bothify('###'),
          'tel2' => $faker->bothify('####'),
          'tel3' => $faker->bothify('####'),
          'contact_email' => $faker->safeEmail,
          'description' => $faker->realText(200),
          'form_company' => $faker->realText(20),
          'postal_code' => $faker->bothify('#######'),
          'prefect' => $faker->Text(5),
          'addr1' => $faker->realText(30),
          'addr2' => $faker->realText(30),
          'submit'=> $faker->bothify('contact'),
        ];

        return [
            'OK contacts' => [$data],
        ];
    }

    /*
    * 異常系のデータ
    *
    */
    public function servicedataproviderValidation()
    {
        $faker = \Faker\Factory::create('ja_JP');
        return [
            'OK name' => ['name', $faker->name, true],
            'OK_1 tel1' => ['tel1', $faker->bothify('##'), true],
            'OK_2 tel1' => ['tel1', $faker->bothify('#####'), true],
            'OK_NULL tel1' => ['tel1', "", true],
            'OK_1 tel2' => ['tel2', $faker->bothify('#'), true],
            'OK_2 tel2' => ['tel2', $faker->bothify('####'), true],
            'OK_NULL tel2' => ['tel2', "", true],
            'OK_1 tel3' => ['tel3', $faker->bothify('###'), true],
            'OK_2 tel3' => ['tel3', $faker->bothify('####'), true],
            'OK_NULL tel3' => ['tel3', "", true],
            'OK email' => ['contact_email', $faker->safeEmail, true],
            'OK description' => ['description', $faker->realText(200), true],
            'OK form_company' => ['form_company', $faker->realText(50), true],
            'OK_NULL form_company' => ['form_company', '', true],
            'OK postal_code' => ['postal_code', $faker->bothify('#######'), true],
            'OK_NULL postal_code' => ['postal_code', '', true],
            'OK prefect' => ['prefect', $faker->Text(5), true],
            'OK_NULL prefect' => ['prefect', "", true],
            'OK addr1' => ['addr1', $faker->realText(100), true],
            'OK_NULL addr1' => ['addr1', "", true],
            'OK addr2' => ['addr2', $faker->realText(100), true],
            'OK_NULL addr2' => ['addr2', "", true],

            'NG_NULL name' => ['name', '', false],
            'NG_OVER_TEXT name' => ['name', $faker->realText(21), false],
            'NG_LESS_NUM tel1' => ['tel1', $faker->bothify('#'), false],
            'NG_OVER_NUM tel1' => ['tel1', $faker->bothify('######'), false],
            'NG_TEXT tel1' => ['tel1', $faker->Text(5), false],

            'NG_OVER_NUM tel2' => ['tel2', $faker->bothify('#####'), false],
            'NG_TEXT tel2' => ['tel2', $faker->Text(5), false],

            'NG_LESS_NUM tel3' => ['tel3', $faker->bothify('##'), false],
            'NG_OVER_NUM tel3' => ['tel3', $faker->bothify('#####'), false],
            'NG_TEXT tel3' => ['tel3', $faker->Text(5), false],

            'NG_FORMAT email' => ['contact_email', 'NG_email', false],
            'NG_NULL description' => ['description', '', false],
            'NG_OVER_TEXT description' => ['description', $faker->realText(1001), false],

            'NG_OVER_TEXT form_company' => ['form_company', $faker->realText(51), false],

            'NG_TEXT postal_code' => ['postal_code', $faker->text(7), false],
            'NG_LESS_NUM postal_code' => ['postal_code', $faker->bothify('##'), false],
            'NG_OVER_NUM postal_code' => ['postal_code', $faker->bothify('##########'), false],

            'NG_OVER_TEXT prefect' => ['prefect', $faker->realText(10), false],
            'NG_OVER_TEXT addr1' => ['addr1', $faker->realText(101), false],
            'NG_OVER_TEXT addr2' => ['addr2', $faker->realText(101), false],
        ];
    }
}
