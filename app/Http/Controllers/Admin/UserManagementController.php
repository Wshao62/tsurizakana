<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\Admin\UserDownloadRequest;
use App\Http\Requests\Admin\IdentificationImageGet;
use App\Http\Requests\Admin\JudgIdentificationPost;
use App\Models\User;
use App\Models\UserPhoto;

use Session;

class UserManagementController extends Controller
{
    public function lists(){

        // $query = User::withTrashed()->get();
        Session::forget('updating_profile');
        Session::forget('errors');
        Session::forget('error');

        return view('admin.user.user_management', [
                'users' => User::all(),
        ]);
    }

    public function getUserDataTables(Request $request)
    {
        return response()->json(User::getDataTable($request->all()));
    }

    public function userDetail(User $user)
    {
        $user['profilepreview'] =  $user->photo->getProfile();
        $user['coverpreview'] =  $user->photo->getCover();
        $shop = $user->shop;
        if (!empty($shop)) {
            foreach ($shop->toArray() as $_k => $_v) {
                $user['shop_'. $_k] = $_v;
            }
        } else {
            $user['shop_name'] = "";
            $user['shop_zipcode'] = "";
            $user['shop_prefecture'] = "";
            $user['shop_address1'] = "";
            $user['shop_address2'] = "";
        }

        $status = Session::get('status');
        Session::forget('status');

        if($user['profilepreview'] == null) $user['profilepreview'] = url(config('const.profile_img_default_icon'));
        if($user['coverpreview'] == null) $user['coverpreview'] = url(config('const.profile_img_default_cover'));

        return view('admin.user.edit', [
                        'userInfo' => $user,
                        'status' => $status,
                        ]);
    }

    public function userRegister(UserRequest $request, User $user)
    {
        // $user = new User;
        $data = $request->all();

        // $validator = Validator::make($data, User::validate('admin_add'));

        // if ($validator->fails()) {
        //     Session::put('errors', $validator->messages());
        //     Session::put('updating_profile', $data);
        //     return redirect()->back()->withInput();
        // }

        $data['password'] = Hash::make($request['password']);
        unset($data['_token']);

        $rtn = $user->adminRegister($data);

        if ($rtn == false) {
            return  redirect('/admin/user/create')->withInput()
                    ->with(['error' => 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }

        Session::put('status', 'ユーザーを作成致しました。');

        return redirect('/admin/user/' . $rtn->id . '/edit');
    }

    public function showIdentification(User $user)
    {
        if (!$user->isWaiting4Identification()) {
            abort(404);
        }
        return view('admin.user.identification', [
            'user' => $user,
            'identification' => $user->identification,
        ]);
    }

    public function judgIdentification(JudgIdentificationPost $request, User $user)
    {
        $data = $request->validated();
        $rtn = $user->identification->judgeAndNotify($user, $data);
        if (!$rtn) {
            return redirect()->back()->withInput()->with(['error' => 'システムエラーです。再度お試しください。']);
        }

        Session::put('status', '本人確認は正常にステータス「"'.$data['judge'].'"」で処理されました。');
        return redirect('/admin/user/'.$user->id.'/edit');
    }

    public function getImage(IdentificationImageGet $req, int $user_id, string $slug, string $ext)
    {
        $path = storage_path(config('const.identification_path').$user_id. '/'. $slug . '.'. $ext);
        if (\File::exists($path)) {
            $image = \File::get($path);
            return response()->make($image, 200, ['content-type' => 'image/jpg']);
        } else {
            return response()->make('', 404);
        }
    }

    public function userReset(){
        $uri = $_SERVER['REQUEST_URI'];
        $userID = explode('/',$uri)[count(explode('/',$uri))-1];

        User::withTrashed()->find($userID)->restore();
        UserPhoto::withTrashed()->where('user_id','=',$userID)->restore();

        return redirect('/admin/user')->with(['status' => 'ユーザーを復元致しました。']);
    }

    public function userCreate(){
        $user = new User;

        $userInfo = Session::get('updating_profile');

        if (isset($userInfo)) {
            $user = $userInfo;
            Session::forget('updating_profile');
            Session::forget('errors');
        }

        $user['profilepreview'] = url(config('const.profile_img_default_icon'));

        return view('admin.user.register', [
                        'userInfo' => $user,
                ]);
    }

    public function userUpdate(UserRequest $request, User $user)
    {
        $data = $request->all();

        $profile_photo = $data['profilepreview'];
        $cover_photo = $data['coverpreview'];
        unset($data['_token']);

        foreach ($data as $key => $value) {
            if (strpos($key, 'edit') !== false) {
                unset($data[$key]);
            }
        }

        $data['profilepreview'] = $profile_photo;
        $data['coverpreview'] = $cover_photo;
        $data['password'] = $request['password'] != null ? Hash::make($request['password']) : $request['password'];

        $rtn = $user->adminUpdater($data);

        if ($rtn == false) {
            Session::put('error', 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。');
            return redirect('/admin/user/' . $data['id'] . '/edit');
        }
        Session::forget('error');
        Session::put('status', 'ユーザー情報を更新しました。');

        return redirect('/admin/user/' . $data['id'] . '/edit');
    }

    public function userDelete(User $user)
    {
        $rtn = $user->adminDelete($user['id']);

        if ($rtn == false) {
            return redirect('/admin/user')
                    ->with(['error' => 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }

        return redirect('/admin/user')
                    ->with(['status' => 'ユーザーを削除致しました。']);
    }
}
