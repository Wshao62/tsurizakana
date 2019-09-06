<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\CreateUser;
use App\Models\TempRegist;
use App\Models\User;
use App\Models\SocialAccountService;
use App\Models\LinkedSocialAccount;

class SocialAccountServiceTest extends TestCase
{
    use DatabaseMigrations;
    use CreateUser;

    protected $provid_user;
    protected $provider = 'facebook';

    /**
     * 初めての利用ユーザがSNSログインしたとき、link_social_accounts、temp_registsが作成され、temp_registsが返却されること
     *
     * @return void
     */
    public function testFindOrCreateWithFirstRegister()
    {
        $attributes = self::getProviderUserAttributes();
        $this->setMockProviderUser($attributes);

        $provid_user = (new SocialAccountService)->findOrCreateUser($this->provid_user, $this->provider);
        $this->assertInstanceOf(TempRegist::class, $provid_user);

        $find_temp_regists = TempRegist::find($provid_user->email)->exists();
        $this->assertTrue($find_temp_regists);

        $find_account = LinkedSocialAccount::whereTempRegistEmail($provid_user->email)->exists();
        $this->assertTrue($find_account);
    }

    /**
     * 仮登録済みのユーザが初めてSNSログインすると、linked_social_accountsが登録され、temp_registが返却されること
     *
     * @return void
     */
    public function testFindOrCreateWithTempRegistedNotSNSLogined()
    {
        $temp_user = factory(TempRegist::class)->create()->toArray();
        $attributes = self::getProviderUserAttributes(['getEmail' => $temp_user['email']]);
        $this->setMockProviderUser($attributes);

        $provid_user = (new SocialAccountService)->findOrCreateUser($this->provid_user, $this->provider);
        $this->assertInstanceOf(TempRegist::class, $provid_user);

        $find_temp_regists = TempRegist::find($provid_user->email)->exists();
        $this->assertTrue($find_temp_regists);

        $find_account = LinkedSocialAccount::whereTempRegistEmail($provid_user->email)->exists();
        $this->assertTrue($find_account);
    }

    /**
     * 本登録済みのユーザが初めてSNSログインをした時にすでにある
     * linked_social_accountsにデータを登録され、usersが返却されること
     *
     * @return void
     */
    public function testFindOrCreateWithRegistedNotSNSLogined()
    {
        $user = $this->createUser();
        $attributes = self::getProviderUserAttributes(['getEmail' => $user['email']]);
        $this->setMockProviderUser($attributes);

        $provid_user = (new SocialAccountService)->findOrCreateUser($this->provid_user, $this->provider);
        $this->assertInstanceOf(User::class, $provid_user);

        $find_account = LinkedSocialAccount::whereUserId($user->id)->exists();
        $this->assertTrue($find_account);
    }

    /**
     * SNSで仮登録したユーザが再度ログインした場合にtemp_registsが返却されること
     *
     * @return void
     */
    public function testFindOrCreateWithTempRegistSNSLogined()
    {
        $temp_user = factory(TempRegist::class)->create()->toArray();
        $accounts = factory(LinkedSocialAccount::class)->create(['temp_regist_email' => $temp_user['email']])->toArray();

        $attributes = self::getProviderUserAttributes(['getEmail' => $temp_user['email']]);
        $this->setMockProviderUser($attributes);

        $provid_user = (new SocialAccountService)->findOrCreateUser($this->provid_user, $this->provider);
        $this->assertInstanceOf(TempRegist::class, $provid_user);
    }

    /**
     * SNSでログインしたことのある本登録済みユーザはusersが返却されること
     *
     * @return void
     */
    public function testFindOrCreateWithUserSNSLogined()
    {
        $user = $this->createUser();
        $accounts = factory(LinkedSocialAccount::class)->create(['user_id' => $user['id']])->toArray();

        $attributes = self::getProviderUserAttributes(['getEmail' => $user['email']]);
        $this->setMockProviderUser($attributes);

        $provid_user = (new SocialAccountService)->findOrCreateUser($this->provid_user, $this->provider);
        $this->assertInstanceOf(User::class, $provid_user);
    }

    /**
     * 処理中にエラーが起きてもDBがロールバックされ、falseが返却されること
     *
     * @return void
     */
    public function testFindOrCreateOnError()
    {
        //emailを空->エラーに
        $temp_user = factory(TempRegist::class)->make(['email' => null])->toArray();
        $attributes = self::getProviderUserAttributes(['getEmail' => null]);
        $this->setMockProviderUser($attributes);

        $rtn = (new SocialAccountService)->findOrCreateUser($this->provid_user, $this->provider);
        $this->assertFalse($rtn);
    }

    /**
     * 渡したuserによってtemp_registsならプロフィール登録画面、usersならマイページを返却
     *
     * @return void
     */
    public function testloginOrGetRedirectUrl()
    {
        $temp_user = factory(TempRegist::class)->create();
        $user = $this->createUser();

        $temp_user_rtn = (new SocialAccountService)->loginOrGetRedirectUrl($temp_user);
        $this->assertEquals('/register/profile/'.$temp_user['token'].'/step/1', $temp_user_rtn);

        $user_rtn = (new SocialAccountService)->loginOrGetRedirectUrl($user);
        $this->assertEquals('/mypage/fish', $user_rtn);
    }

    /**
     * Socialite->with($provider)->user()の返却値、provider_userをモック化
     *
     * @param  array $attributes
     *
     * @return void
     */
    private function setMockProviderUser($attributes)
    {
        $this->provid_user = \Mockery::mock('Laravel\Socialite\Two\User');
        foreach ($attributes as $method => $rtn) {
            $this->provid_user->shouldReceive($method)
                        ->andReturn($rtn);
        }
    }

    /**
     * Socialiteのモック化に用いる値を返却
     *
     * @param  array $attributes
     *
     * @return array
     */
    private static function getProviderUserAttributes($attributes = null)
    {
        $faker = \Faker\Factory::create('ja_JP');

        $rtn = [
            'getId' => $faker->bothify('************'),
            'getEmail' => $faker->safeEmail,
            'getNickname' => $faker->secondaryAddress,
            'getName' => $faker->name,
            'getAvatar' => 'https://placehold.jp/150x150.png',
        ];
        if (!empty($attributes)) {
            foreach ($attributes as $method => $value) {
                $rtn[$method] = $value;
            }
        }

        return $rtn;
    }
}
