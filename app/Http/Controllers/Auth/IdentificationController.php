<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\IdentificationDoc;
use App\Http\Requests\IdentificationPost;

class IdentificationController extends Controller
{
    public function index()
    {
        if (\Auth::user()->isIdentified() || \Auth::user()->isWaiting4Identification()) {
            abort(403);
        }

        return view('auth.identification');
    }

    public function send2Admin(IdentificationPost $req)
    {
        $rtn = IdentificationDoc::userRegister($req->validated());

        if ($rtn === false) {
            return redirect('/mypage/blog')
                        ->with(['error' => 'システムエラーです。再度お試しいただくか、お問い合わせください。']);
        }

        return redirect('/mypage/blog')->with(['status' => '本人確認書類の送付が完了しました。運営の確認までお待ちください。']);
    }
}
