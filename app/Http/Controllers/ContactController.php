<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactPost;
use App\Notifications\ContactNotification;
use App\Models\User;
use App\Models\Admin;
use Session;

class ContactController extends Controller
{

    public function index()
    {
        if (!Session::exists('contact_data')) {
            $data = [
                'contact_type' => '釣魚商店について',
                'name' => '',
                'form_company' => '',
                'contact_email' => '',
                'postal_code' => '',
                'prefect' => '',
                'addr1' => '',
                'addr2' => '',
                'tel1' => '',
                'tel2' => '',
                'tel3' => '',
                'description' => '',
            ];
        } else {
            $data = Session::get('contact_data');
        }
        return view('contact.contact', $data);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(ContactPost $request)
    {
        $data = $request->all();

        if ($data['submit'] === 'contact') {
            Session::put('contact_data', $data);
            return view('contact.confirm', $data);
        }

        if ($data['submit'] === 'complete') {
            Session::forget('contact_data');

            $this->sendemail($request);
            return redirect('/contact/complete');
        }
        $this->sendemail($request);

        $url = url()->previous() . '#contact';
        return redirect($url)
                ->with(['contacted' => true]);
    }

    public function complete()
    {
        return view('contact.complete');
    }

    public function sendemail($request)
    {

        $user_data = $request->all();
        $user_data['email'] = $user_data['contact_email'];
        $tmp_user = new User($user_data);
        //ユーザーにメール通知
        $tmp_user->notify(new ContactNotification($user_data, false));


        //送信先メールアドレスを担当者に置き換える
        $admin_data = $request->all();

        //担当者にメール通知、担当に送信するのはユーザーのデータ
        Admin::first()->notify(new ContactNotification($user_data, true));
    }
}
