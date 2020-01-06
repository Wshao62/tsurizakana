<?php

namespace App\Http\Controllers;

use App\Http\Requests\PioneerRequest;
use App\Models\User;
use App\Notifications\PioneerNotification;
use Illuminate\Http\Request;

class PioneerController extends Controller
{
    /**
     * 飲食店会員開拓希望フォーム
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pioneer.index');
    }

    /**
     * 飲食店会員開拓希望確認
     *
     * @param PioneerRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm(PioneerRequest $request)
    {
        $form = $request->all();
        return view('pioneer.confirm', ['form' => $form]);
    }

    /**
     * 飲食店会員開拓希望送信
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendEmail(Request $request)
    {
        $form = $request->all();
        $tmp_user = new User(['email' => 'support@tsurizakana-shoten.com']);
        $tmp_user->notify(new PioneerNotification($form));

        $tmp_user = new User(['email' => $form['email']]);
        $tmp_user->notify(new PioneerNotification($form));

        return redirect('/pioneer/complete');
    }

    /**
     * 飲食店会員開拓希望送信完了
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function complete()
    {
        return view('pioneer.complete');
    }
}
