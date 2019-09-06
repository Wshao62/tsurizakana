<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserPhoto;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditProfilePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use Session;

class ProfileController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfileForm()
    {
        $user = \Auth::user();
        if (!$user->isOwner()) {
            abort(403);
        }

        $data = $user->toArray();
        $data['photo'] = $user->photo;
        $shop = $user->shop;
        if (!empty($shop)) {
            foreach ($shop->toArray() as $_k => $_v) {
                $data['shop_'. $_k] = $_v;
            }
        } else {
            $data['shop_name'] = "";
            $data['shop_zipcode'] = "";
            $data['shop_prefecture'] = "";
            $data['shop_address1'] = "";
            $data['shop_address2'] = "";
        }

        if (Session::exists('updating_profile')) {
            $data = Session::get('updating_profile') + $data;
            Session::forget('updating_profile');
        }

        /**
        * clean temporary directories
        * @path = /storage/app/public/img/tmp/profile/
        */
        UserPhoto::cleanTempPath($user->id);

        return view('auth.update', [
            'user' => $data,
        ]);
    }


    /**
     * Show the Profile Review page
     *
     * @param  \Illuminate\Http\EditProfilePost  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfileConfirm(EditProfilePost $request)
    {
        $user = \Auth::user();
        $data = $request->validated();
        $data['photo'] = $user->photo;

        /**
        * create & retrieve temporary photos
        * @path = /storage/app/public/img/tmp/profile/{$user->id}/
        */
        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = UserPhoto::createTempPath("profile_photo", $request, $user->id);
        }
        if ($request->hasFile('cover_photo')) {
            $data['cover_photo'] = UserPhoto::createTempPath("cover_photo", $request, $user->id);
        }


        Session::put('updating_profile', $data);
        Session::save();

        return view('auth.profile_update.confirm', [
            'data' => $data,
        ]);
    }

     /**
     * Post Request to update info in session
     *
     * @param  Session;
     * @return \Illuminate\Http\Response
     */
    public function updateProfile()
    {
        $user = \Auth::user();
        if (!Session::has('updating_profile')) {
            abort('403');
        }

        $data = Session::get('updating_profile');

        $rtn = $user->updater($data);

        if ($rtn == false) {
            return redirect('/mypage/profile/edit')
                    ->with(['error' => 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }

        Session::forget('updating_profile');
        return redirect('/mypage/profile/edit')
                    ->with(['isCompleted' => true]);
    }

    /**
     * 新しいメールアドレスの変更メールからの確認
     *
     * @param  string $token
     */
    public function verifyNewEmail(string $token)
    {
        $user = \Auth::user();
        $url = '/mypage/profile/edit';
        if (empty($user->newEmail) || $user->newEmail->token != $token) {
            return redirect($url)
                ->with(['error' => '不明なトークンのため、メールアドレスの変更はできません。もう一度新しいメールアドレスに変更してメールを再送してお試しください。']);
        }

        $rtn = $user->newEmail->verify();
        if ($rtn === false) {
            return redirect($url)
            ->with(['error' => 'システムエラーが発生しました。確認メールから再度URLにアクセスいただくか、もう一度新しいメールアドレスに変更してメールを再送してお試しください。']);
        }

        return redirect($url)
            ->with(['status' => 'メールアドレスの変更が完了しました。']);
    }
}
