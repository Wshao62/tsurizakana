<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessLicensePost;
use App\Models\User\BusinessLicenseDoc;
use Illuminate\Http\Request;
use App\Models\User\IdentificationDoc;
use App\Http\Requests\IdentificationPost;

class BusinessLicenseController extends Controller
{
    public function index()
    {
        if (\Auth::user()->isBusinessIdentified() || \Auth::user()->isWaiting4BusinessIdentification()) {
            abort(403);
        }

        return view('auth.business_license');
    }

    public function send2Admin(BusinessLicensePost $req)
    {
        $rtn = BusinessLicenseDoc::userRegister($req->validated());

        if ($rtn === false) {
            return redirect('/mypage/blog')
                        ->with(['error' => 'システムエラーです。再度お試しいただくか、お問い合わせください。']);
        }

        return redirect('/mypage/blog')->with(['status' => '営業許可証書類の送付が完了しました。運営の確認までお待ちください。']);
    }
}
