<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocialAccountController extends Controller
{
    /**
     * Redirect the user to the SNS authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        if ($provider !== 'facebook') {
            return abort(404);
        }

        return \Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information
     *
     * @return Response
     */
    public function handleProviderCallback(\App\Models\SocialAccountService $accountService, $provider)
    {
        if ($provider !== 'facebook') {
            return abort(404);
        }

        try {
            $user = \Socialite::with($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['システムエラーが発生しました。時間をおいて再度お試しください。それでもうまくいかない場合はお問合せください。']);
        }
        if ($user = $accountService->findOrCreateUser($user, $provider)) {
            $redirect_url = $accountService->loginOrGetRedirectUrl($user);
            return redirect()->to($redirect_url);
        } else {
            return redirect('/login')->withErrors(['システムエラーが発生しました。時間をおいて再度お試しください。それでもうまくいかない場合はお問合せください。']);
        }
    }
}
