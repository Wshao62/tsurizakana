<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Traits\CreateUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use \App\Models\User;
use \App\Models\Notification\ContactNotification;
use \App\Http\Requests\ContactPost;
use Illuminate\Support\Facades\Validator;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class ContactsTest extends TestCase
{
    /**
    *  お問い合わせ欄正常系
    *
    * @param  string $base_url 元URL
    * @param  string $redirect_url URLリダイレクト先
    * @dataProvider dataproviderURLs
    */
    public function testContact($base_url, $redirect_url, $data)
    {
        $this->withHeaders([
          'HTTP_REFERER' => url($base_url),
        ])
        ->post('contact', $data)
        ->assertRedirect(url($redirect_url))
        ->assertSessionHasNoErrors(['name'])
        ->assertSessionHasNoErrors(['tel1'])
        ->assertSessionHasNoErrors(['tel2'])
        ->assertSessionHasNoErrors(['tel3'])
        ->assertSessionHasNoErrors(['contact_email'])
        ->assertSessionHasNoErrors(['description']);
    }

    /**
    *  お問い合わせ欄、未入力
    *
    * @param  string $base_url 元URL
    * @param  string $redirect_url URLリダイレクト先
    * @dataProvider dataproviderURLs
    */
    public function testContactNull($base_url, $redirect_url, $data)
    {
        $Null_data = [
          'name' => '',
          'tel1' => '',
          'tel2' => '',
          'tel3' => '',
          'contact_email' => '',
          'description' => '',
          
        ];
        $this->withHeaders([
          'HTTP_REFERER' => url($base_url),
        ])
        ->post('contact', $Null_data)
        ->assertRedirect(url($redirect_url))
        ->assertSessionHasErrors(['name'])
        ->assertSessionHasErrors(['tel1'])
        ->assertSessionHasErrors(['tel2'])
        ->assertSessionHasErrors(['tel3'])
        ->assertSessionHasErrors(['contact_email'])
        ->assertSessionHasErrors(['description']);
    }

    /**
     * testValidation
     *
     * @param  string $item 項目名
     * @param  string $data 入力値
     * @param  boolean $expect 期待値 (true:validtionOK/false:validationZNG)
     *
     * @return void
     * @dataProvider dataproviderValidation
     */
    public function testValidation($item, $data, $expect)
    {
        
        $data_list = [$item => $data];
        $request = new ContactPost();
        //フォームリクエストで定義したルールを取得
        $rules = $request->rules("required");
        $target_rule = [$item => $rules[$item]];
        $validator = Validator::make($data_list, $target_rule);
        $result = $validator->passes();
        $this -> assertEquals($expect, $result);
    }

    /*
    * URLのデータプロバイダ
    *
    */
    public function dataproviderURLs()
    {
        $faker = \Faker\Factory::create('ja_JP');
        $data = [
          'name' => $faker->name,
          'tel1' => $faker->bothify('###'),
          'tel2' => $faker->bothify('####'),
          'tel3' => $faker->bothify('####'),
          'contact_email' => $faker->safeEmail,
          'description' => $faker->realText(200),
          'submit'=> $faker->bothify('notcontact'),
        ];

        return [
            'OK buyer' => ['/buyer', '/buyer#contact', $data],
            'OK seller' => ['/seller', '/seller#contact', $data],
        ];
    }

    /*
    * 異常系のデータ
    *
    */
    public function dataproviderValidation()
    {
        $faker = \Faker\Factory::create('ja_JP');
        return [
            'OK name' => ['name', $faker->name, true],
            'OK_1 tel1' => ['tel1', $faker->bothify('##'), true],
            'OK_2 tel1' => ['tel1', $faker->bothify('#####'), true],
            'OK_1 tel2' => ['tel2', $faker->bothify('#'), true],
            'OK_2 tel2' => ['tel2', $faker->bothify('####'), true],
            'OK_1 tel3' => ['tel3', $faker->bothify('###'), true],
            'OK_2 tel3' => ['tel3', $faker->bothify('####'), true],
            'OK email' => ['contact_email', $faker->safeEmail, true],
            'OK description' => ['description', $faker->realText(200), true],

            'NG_NULL name' => ['name', '', false],
            'NG_OVER_TEXT name' => ['name', $faker->realText(21), false],
            'NG_NULL tel1' => ['tel1', '', false],
            'NG_LESS_NUM tel1' => ['tel1', $faker->bothify('#'), false],
            'NG_OVER_NUM tel1' => ['tel1', $faker->bothify('######'), false],
            'NG_TEXT tel1' => ['tel1', $faker->text(5), false],

            'NG_NULL tel2' => ['tel2', '', false],
            'NG_OVER_NUM tel2' => ['tel2', $faker->bothify('#####'), false],
            'NG_TEXT tel2' => ['tel2', $faker->text(5), false],

            'NG_NULL tel3' => ['tel3', '', false],
            'NG_LESS_NUM tel3' => ['tel3', $faker->bothify('##'), false],
            'NG_OVER_NUM tel3' => ['tel3', $faker->bothify('#####'), false],
            'NG_TEXT tel3' => ['tel3', $faker->text(5), false],

            'NG_FORMAT email' => ['contact_email', 'NG_email', false],
            'NG_NULL description' => ['description', '', false],
            'NG_OVER_TEXT description' => ['description', $faker->realText(1001), false],
        ];
    }
}
