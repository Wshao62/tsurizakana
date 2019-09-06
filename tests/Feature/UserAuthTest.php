<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Traits\CreateUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use \App\Models\User;
use \App\Models\TempRegist;

class UserAuthTest extends TestCase
{
    use DatabaseMigrations;
    use CreateUser;

    private $user;
    private $temp_user;
    private $base_url;

    // MEMO: Laravel標準のAuthのテストも書いてみているが、
    // こういうこともできるという知見のため、そのまま残す

    /**
     *  未ログインユーザのみログインページが表示できること
     *
     * @return void
     */
    public function testLoginPageNotShow2LoginnedUser()
    {
        $guest_res = $this->get('/login');
        $guest_res->assertOK();
    }

    /**
     * ログイン済みユーザはマイページへリダイレクトされること
     *
     * @return void
     */
    public function testLoginPageShow2Guest()
    {
        $user = $this->createUser();

        $user_res = $this->actingAs($user, 'user')
                    ->get('/login');
        $user_res->assertRedirect('/mypage/fish');
    }

    /**
     * 正常にログインできること
     *
     * @return void
     */
    public function testLoginByEmail()
    {
        $user = $this->createUser();
        $succsess_data = [
            'email' => $user->email,
            'password' => 'password123',
        ];
        $this->post('/login', $succsess_data)
            ->assertRedirect('/mypage/fish');
    }

    /**
     *  パスワードが間違えているユーザ、削除済みユーザはログインができないこと
     *
     * @return void
     */
    public function testLoginFailByEmail()
    {
        $user = $this->createUser();
        $fail_data = [
            'email' => $user->email,
            'password' => 'fail_password',
        ];

        $deleted_user = $this->createUser('deleted');
        $deleted_data = [
            'email' => $deleted_user->email,
            'password' => 'password123',
        ];

        $this->post('/login', $fail_data)
            ->assertSessionHasErrors(['email']);

        $this->post('/login', $deleted_data)
            ->assertSessionHasErrors(['email']);
    }

    /**
     * 未ログインユーザに新規登録の画面が見えること
     *
     * @return void
     */
    public function testRegistPageShow2Guest()
    {
        $this->get('/register')
            ->assertOK();
    }

    /**
     * ログイン済みユーザに新規登録画面が見えず、マイページへリダイレクトされること
     *
     * @return void
     */
    public function testLoginPagehow2Guest()
    {
        $user = $this->createUser();

        $user_res = $this->actingAs($user, 'user')
                        ->get('/register');
        $user_res->assertRedirect('/mypage/fish');
    }

    /**
     * SNSログインURLを踏むと、302でリダイレクトすること
     *
     * @return void
     */
    public function testSNSLoginSuccess()
    {
        $user_res = $this->get('/login/facebook');
        $user_res->assertStatus(302);
    }

    /**
     * 許可されていないSNSログインを試みると、404となること
     *
     * @return void
     */
    public function testSNSLoginFail()
    {
        $user_res = $this->get('/login/twitter');
        $user_res->assertStatus(404);
    }

    /**
     * ティザー新規登録の流れ
     * メールの登録ができ
     * 登録したメールが飛ぶ
     *
     * @return void
     */
    public function testRegistFrowSuccess()
    {
        Notification::fake();

        $faker = \Faker\Factory::create('ja_JP');
        $email = $faker->safeEmail;

        //ティザーからメールの登録
        $this->post('/register', ['email' => $email])
                    ->assertRedirect(url('/').'#registration_form');

        $temp_user = TempRegist::find($email);
        Notification::assertSentTo(
            [$temp_user],
            \App\Notifications\TempRegistNotification::class
        );
    }

    public function testRegistByRegisterRedirect2ThanksPage()
    {
        $faker = \Faker\Factory::create('ja_JP');
        $email = $faker->safeEmail;

        $this->withHeaders([
                'HTTP_REFERER' =>  url('/register'),
            ])
            ->post('/register', ['email' => $email])
            ->assertRedirect(url('/register/thanks'));
    }

    /**
     * 会員登録Step1が正常に表示され、
     * Step2以降に進んでもデータが保持されていること(password以外)
     *
     * @return void
     */
    public function testRegistStep1Success()
    {
        $this->initialRegisterDatas();

        //Step1
        $this->get($this->base_url.'/step/1')
            ->assertOK();

        // now is Step2Page
        $this->post($this->base_url.'/step/2', self::getRegistData($this->user, 1))
            ->assertOK();

        // Back to Step1
        // 値が保持されていること(password以外)
        $this->get($this->base_url.'/step/1')
        ->assertSee('value="'.$this->user['name'].'"')
        ->assertSee('value="'.$this->user['furigana'].'"')
        ->assertSee('"password" value=""');
    }

    /**
     * 会員登録Step1でvalidationに通らないあたいの場合エラーが表示されること
     *
     * @return void
     */
    public function testRegistStep1FailValidation()
    {
        $this->initialRegisterDatas();

        //Step1
        $this->get($this->base_url.'/step/1')
            ->assertOK();

        // now is Step2Page
        $this->post($this->base_url.'/step/2', self::getRegistData($this->user, 1))
            ->assertOK();

        // Back to Step1
        // 値が保持されていること(password以外)
        $this->get($this->base_url.'/step/1')
        ->assertSee('value="'.$this->user['name'].'"')
        ->assertSee('value="'.$this->user['furigana'].'"')
        ->assertSee('"password" value=""');
    }

    /**
     * 会員登録Step1が正常に表示され、
     * 確認に進んでもデータが保持されていること
     *
     * @return void
     */
    public function testRegistStep2Success()
    {
        $this->initialRegisterDatas();

        // Step2
        $step1_done_data = self::getRegistData($this->user, 1);
        $step1_done_data['email'] = $this->user['email'];
        $this->withSession([
                'registering_user' => $this->temp_user,
                'registering_profile_1' => $step1_done_data,
            ])
            ->post($this->base_url. '/confirm', self::getRegistData($this->user, 2))
            ->assertOK();

        // now is ConfirmPage. Back to Step2
        $this->get($this->base_url.'/step/2')
            ->assertSee('"zipcode" value="'.$this->user['zipcode'].'"')
            ->assertSee('value="'.$this->user['prefecture'].'" selected="selected"')
            ->assertSee('"private_address" value="'.$this->user['private_address'].'"')
            ->assertSee('"private_address" value="'.$this->user['private_address'].'"')
            ->assertSee('"mobile_tel" value="'.$this->user['mobile_tel'].'"')
            ->assertSee('"tel" value="'.$this->user['tel'].'"');
    }

    /**
     * 会員登録の入力確認が正常に表示されること
     *
     * @return void
     */
    public function testRegistConfirm()
    {
        $this->initialRegisterDatas();

        $step1_done_data = self::getRegistData($this->user, 1);
        $step1_done_data['email'] = $this->user['email'];
        $confirm_res = $this->withSession([
                'registering_user' => $this->temp_user,
                'registering_profile_1' => $step1_done_data,
            ])
            ->post($this->base_url.'/confirm', self::getRegistData($this->user, 2))
            ->assertOK();

        unset($this->user['password']);
        foreach ($this->user as $data) {
            $confirm_res->assertSee($data);
        }
    }

    /**
     * 会員登録が正常に完了されること
     *
     * @return void
     */
    public function testRegistComplete()
    {
        $this->initialRegisterDatas();

        $step1_done_data = self::getRegistData($this->user, 1);
        $step1_done_data['email'] = $this->user['email'];
        $this->withSession([
                'registering_user' => $this->temp_user,
                'registering_profile_1' => $step1_done_data,
                'registering_profile_2' => self::getRegistData($this->user, 2),
            ])
            ->post($this->base_url.'/complete')
            ->assertOK();

        $registerd_user = User::find(1)->toArray();
        unset($registerd_user['id']);
        unset($registerd_user['created_at']);
        unset($registerd_user['updated_at']);
        unset($registerd_user['deleted_at']);
        $this->assertArraySubset($registerd_user, $this->user);
    }

    /**
     * 新規登録、入力後のStepのページに戻っても値が消えていないこと
     *
     * @return void
     */
    public function testRegistStepsCanBack()
    {
        $this->initialRegisterDatas();

        // Step1 -> Step2 -> Confirm -> Step1 -> Step2
        // Step1
        $this->get($this->base_url.'/step/1')
            ->assertOK();

        // Step2
        $this->post($this->base_url.'/step/2', self::getRegistData($this->user, 1))
            ->assertOK();

        // Confirm
        $this->post($this->base_url. '/confirm', self::getRegistData($this->user, 2))
            ->assertOK();
    }

    /**
     * プロフィール登録時に必要なデータ陣をプロパティにセットする
     *
     * @return void
     */
    private function initialRegisterDatas()
    {
        $this->temp_user = factory(TempRegist::class)->create()->toArray();

        $this->base_url = '/register/profile/'.$this->temp_user['token'];
        $this->user = factory(User::class)->make()->toArray();
        $this->user['email'] = $this->temp_user['email'];
    }

    /**
     * 会員登録時の入力データを返却する
     *
     * @param  array $user
     * @param  int $step nullable
     *
     * @return void
     */
    private function getRegistData($user, $step = null)
    {
        $rtn = [];
        $step1_data = [
            'name' => $user['name'],
            'furigana' => $user['furigana'],
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];
        $step2_data = [
            'zipcode' => $user['zipcode'],
            'prefecture' => $user['prefecture'],
            'public_address' => $user['public_address'],
            'private_address' => $user['private_address'],
            'mobile_tel' => $user['mobile_tel'],
            'tel' => $user['tel'],
        ];

        switch ($step) {
            case 1:
                $rtn = $step1_data;
                break;
            case 2:
                $rtn = $step2_data;
                break;
            default:
                $rtn = $step1_data + $step2_data;
        }

        return $rtn;
    }
}
