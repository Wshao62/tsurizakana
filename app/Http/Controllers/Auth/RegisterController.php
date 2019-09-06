<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\TempRegist;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Notifications\TempRegistNotification;
use App\Http\Requests\Register\TempRegistPost;
use App\Http\Requests\Register\RegistProfileStep1Post;
use App\Http\Requests\Register\RegistProfileStep2Post;
use App\Http\Requests\Register\RegistProfilePost;
use Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/mypage/fish';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 新規会員登録時、POSTで呼び出される
     *
     * @param  TempRegistPost $request
     * @return void
     */
    protected function register(TempRegistPost $req_data)
    {
        $data = $req_data->validated();
        $temp_user = TempRegist::register([
                'email' => $req_data['email'],
                'token' => TempRegist::makeUniqToken(),
            ]);

        // registerメソッド内で、ログイン処理しているため
        // ログアウトさせる
        $this->guard()->logout();

        if ($temp_user !== false) {
	    if ( false ) {
            #if (strpos(url()->previous(), '/register') === false) {
                //本サービスリリース前のティザーからの会員登録の場合
                $temp_user->notify(new TempRegistNotification(true));
                $url = url()->previous() . '#registration_form';
                return redirect($url)
                        ->with(['is_registerd' => true]);
            } else {
                $temp_user->notify(new TempRegistNotification(false));
                return redirect('register/thanks');
            }
        } else {
            if (strpos(url()->previous(), '/register') === false) {
                //本サービスリリース前のティザーからの会員登録の場合
                $url = url()->previous() . '#registration_form';
                $target = redirect($url);
            } else {
                $target = redirect()->back();
            }
            return $target->withInput()
                        ->with(['status' => 'エラーが発生しました、再度お試しください。それでも解決しない場合は運営へお問い合わせください。']);
        }
    }

    /**
     * 仮登録メールからプロフィール登録画面の表示 Step1
     *
     * @param  string $token
     *
     */
    public function createProfileStep1(string $token)
    {
        Session::forget('registering_user');

        $user = TempRegist::whereToken($token)->first();
        if (empty($user['token'])) {
            Session::forget('registering_profile_1');
            Session::forget('registering_profile_2');
            abort('404');
        }
        $user = $user->toArray();
        Session::put('registering_user', $user);

        $old_data = Session::get('registering_profile_1');
        if (empty($old_data['name'])) {
            $old_data = User::getProperties();
        }
        return view('auth.profile_regist.step1', [
            'user' => $user,
            'old_data' => $old_data,
        ]);
    }

    /**
     * 仮登録メールからプロフィール登録画面の表示 Step1
     *
     * @param  RegistProfileStep1Post $request
     *
     */
    public function createProfileStep2(RegistProfileStep1Post $request)
    {
        $user = Session::get('registering_user');

        $data = $request->validated();
        if (!empty($data['name'])) {
            // MEMO: エラーで戻った時や、確認画面からの戻りの際に値を上書きしないためのIF
            $data['email'] = $user['email'];
            Session::put('registering_profile_1', $data);
        }

        $old_data = Session::get('registering_profile_2');
        if (empty($old_data['zipcode'])) {
            $old_data = User::getProperties();
        }
        return view('auth.profile_regist.step2', [
            'user' => $user,
            'old_data' => $old_data,
        ]);
    }

    /**
     * registProfileConfirm
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function registProfileConfirm(RegistProfileStep2Post $request)
    {
        $user = Session::get('registering_user');

        $data = $request->validated();
        Session::put('registering_profile_2', $data);
        $data = Session::get('registering_profile_1') + $data;

        return view('auth.profile_regist.confirm', [
            'user' => $user,
            'data' => $data,
        ]);
    }

    public function registProfileComplete(Request $request, string $token)
    {
        if (!Session::has('registering_user')
        || Session::get('registering_user')['token'] != $token) {
            abort('403');
        }

        $data = Session::get('registering_profile_1') + Session::get('registering_profile_2');
        $validator = Validator::make($data, User::validate('confirm'));
        if ($validator->fails()) {
            return redirect('/register/profile/'.$token. '/step/1')
                    ->with(['error' => 'セッション切れか、不正な画面遷移です。再度入力して手続きを進めて下さい。']);
        }

        $data['password'] = Hash::make($data['password']);
        $user = User::register($data);
        if (!$user) {
            return redirect('/register/profile/'.$token. '/step/1')
            ->with(['error' => 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }

        //ログインさせる
        \Auth::login($user);

        Session::forget('registering_user');
        Session::forget('registering_profile_1');
        Session::forget('registering_profile_2');
        return view('auth.profile_regist.complete');
    }
}
