<?php

namespace App\Models;

use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Support\Facades\DB;

class SocialAccountService
{
    /**
     * ソーシャルログインするユーザが見つかればそのままusersを返却
     * 見つからなければtemp_registsを作成する
     *
     * @param  ProviderUser $provider_user
     * @param  string $provider
     *
     * @return User/TempRegist $user
     */
    public function findOrCreateUser(ProviderUser $provider_user, $provider)
    {
        DB::beginTransaction();
        try {
            $account = LinkedSocialAccount::where('provider_name', $provider)
                                            ->where('provider_id', $provider_user->getId())
                                            ->first();

            if (!empty($account) && !empty($account->user_id)) {
                //すでに過去ログイン済みのアカウント

                // MEMO: メールアドレスと名前の更新処理について、決済周りや本人確認が関わってくるので一旦なしとする。
                // $new_datum = [
                //     'email' => $provider_user->getEmail(),
                //     // 'name' => $provider_user->getName(),
                // ];
                $user = $account->user;
                // $user->update($new_datum);
            } elseif (!empty($account)) {
                //プロフィール登録の終わったユーザではないが、SNSログインをしたことがある
                $user = $account->tempRegist;
            } elseif ($user = TempRegist::find($provider_user->getEmail())) {
                //仮登録済みだが、初めてSNSログインを利用した人は、すでにあるtempregistと紐づける。
                LinkedSocialAccount::register([
                    'temp_regist_email' => $provider_user->getEmail(),
                    'provider_id' => $provider_user->getId(),
                    'provider_name' => $provider,
                ]);
            } elseif ($user = User::whereEmail($provider_user->getEmail())->first()) {
                //プロフィール登録済みだが、初めてSNSログインを利用した人は、すでにあるusers情報とSNSのIDを紐づける。
                LinkedSocialAccount::register([
                    'user_id' => $user->id,
                    'provider_id' => $provider_user->getId(),
                    'provider_name' => $provider,
                ]);
            } else {
                // 初めての利用+初めてのSNSログイン
                $user = TempRegist::register([
                    'email' => $provider_user->getEmail(),
                    'token' => TempRegist::makeUniqToken(),
                ]);
                LinkedSocialAccount::register([
                    'temp_regist_email' => $provider_user->getEmail(),
                    'provider_id' => $provider_user->getId(),
                    'provider_name' => $provider,
                ]);
            }
            DB::commit();

            return $user;
        } catch (\Exception $e) {
            \Log::error(get_class().':findOrCreateUser(): '.$e->getMessage());
            return false;
        }
    }

    /**
     * getRedirectUrl
     *
     * @param  User/TempRegist $user
     *
     * @return string url
     */
    public static function loginOrGetRedirectUrl($user)
    {
        $url = '/';
        if ($user instanceof User) {
            auth()->login($user, true);
            $url = '/mypage/fish';
        } else {
            $url = '/register/profile/'.$user->token.'/step/1';
        }

        return $url;
    }
}
