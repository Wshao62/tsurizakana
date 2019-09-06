<?php

namespace App\Http\Controllers\Fish;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fish;
use App\Models\Fish\Wisher;
use App\Http\Requests\Fish\ChooseWisherPost;

class WishController extends Controller
{
    public function addWisher(Fish $fish, Request $req)
    {
        $back_url = url('/fish', $fish->id);
        if (!$fish->isPublish()) {
            return redirect($back_url)
                    ->with(['error' => $fish->getPublicStatus().'の売魚は購入できません']);
        }

        if ($fish->isOwner()) {
            return redirect($back_url)
                    ->with(['error' => '自分の売魚は購入できません。']);
        }

        if (!\Auth::user()->isIdentified()) {
            abort(403);
        }

        $rtn = $fish->execWish();
        $data = ['status' => '購入希望を出しました。売主の購入者決定をお待ちください。'];
        if ($rtn === false) {
            $data = ['error' => 'システムエラーで、購入希望を出すのに失敗しました。再度お試しいただくか、お問い合わせください。'];
        } elseif ($rtn == 'buy') {
            return redirect('/mypage/fish/'.$fish->id)->with(['status' => 'ご購入ありがとうございます！取引が開始しました。まずは決済を実行してください。']);
        }

        return redirect($back_url)
                    ->with($data);
    }

    public function removeWisher(Fish $fish, Request $req)
    {
        $back_url = url('/fish', $fish->id);
        if (!$fish->isPublish()) {
            return redirect($back_url)
                    ->with(['error' => $fish->getPublicStatus().'の売魚は購入できません']);
        }
        if (!$fish->isWisher()) {
            return redirect($back_url)
                    ->with(['error' => 'あなたは購入希望を出していません。']);
        }

        $rtn = Wisher::deleter($fish->id, \Auth::id());

        $data = ['status' => '購入希望をキャンセルいたしました。'];
        if ($rtn === false) {
            $data = ['error' => 'システムエラーで、購入希望のキャンセルに失敗しました。再度お試しいただくか、お問い合わせください。'];
        }

        return redirect($back_url)
                    ->with($data);
    }

    public function list(Fish $fish)
    {
        if (!$fish->isOwner()) {
            abort(403);
        }

        $is_registerd_bank = !empty(\Auth::user()->bank_name);

        $limit = 10;
        $rtn = $fish->getWisherList();
        return view('fish.wisher', [
                'is_registerd_bank' => $is_registerd_bank,
                'fish' => $fish,
                'wishers' => $rtn['wishers'],
                'rates' => $rtn['rates'],
                'limit' => $limit,
            ]);
    }

    public function choose(ChooseWisherPost $req, Fish $fish)
    {
        $data = $req->all();
        if ($fish->isTransaction() || empty(\Auth::user()->bank_name)) {
            abort(404);
        }
        if (!$wisher = Wisher::find($fish->id, $data['wisher_id'])) {
            return redirect()->back()->withErrors(['wisher_id' => '該当の購入希望者が見つかりません。']);
        }

        $rtn = $fish->chooseWisher($wisher);
        if ($rtn === false) {
            return redirect()->back()
                    ->with(['error' => 'システムエラーで、購入者の確定に失敗しました。再度お試しいただくか、お問い合わせください。']);
        }

        $custom = ['url' => url('/mypage/fish/'. $fish->id)];
        \App\Models\User\DeviceToken::sendPushNotification($wisher['user_id'], "あなたが売り魚の購入者として確定しました！", $custom);

        return redirect('/mypage/fish/'.$fish->id)->with(['status' => '購入者確定が完了しました！　まずは購入者の決済を待ちましょう。']);
    }
}
