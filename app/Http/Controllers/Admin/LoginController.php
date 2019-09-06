<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller
{
    public function __construct()
    {
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'ad_email'   => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);

        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['email' => $request->ad_email, 'password' => $request->password])) {
            // if successful, then redirect to their intended location
            return redirect()->intended(url('/admin/payment'));
        }

        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('ad_email'))->withErrors(['ad_email' => 'IDとパスワードが一致しません。']);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}
