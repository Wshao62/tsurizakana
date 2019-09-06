<?php

namespace App\Http\Controllers\Fish;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fish;
use App\Models\Order;
use App\Http\Requests\Fish\BuyPost;
use Session;

class BuyController extends Controller
{
    /**
     * 購入確認画面を表示
     *
     * @param  Fish $fish
     *
     */
    public function buyConfirm(Fish $fish)
    {
        if (!$fish->canOrder()) {
            return redirect(url('/mypage/fish', $fish->id))
                    ->with(['error' => $fish->getStatus().'の売魚、購入者でない売魚は購入できません。']);
        }

        return view('fish.buy.confirm', [
            'fish' => $fish
        ]);
    }

    /**
     * 購入を実施
     *
     * @param  BuyPost $request
     * @param  Fish $fish
     *
     */
    public function buy(BuyPost $request, Fish $fish)
    {
        if (!$fish->canOrder()) {
            return redirect(url('/mypage/fish', $fish->id))
                ->with(['error' => $fish->getStatus().'の売魚、購入者でない売魚は購入できません。']);
        }

        $data = $request->all();
        $rtn = $fish->execSuspencePay($data['buy_token']);
        if ($rtn === false) {
            return redirect('/mypage/fish/'.$fish->id)
                    ->with(['error' => 'システムエラーが発生しました。商品のステータスが[配達待ち]となっていない場合はしばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }

        return redirect('fish/'. $fish->id. '/buy/complete');
    }

    public function showComplete(Fish $fish)
    {
        if (!$order = $fish->order) {
            abort(404);
        }

        return view('fish.buy.complete', [
            'order' => $order,
            'fish' => $fish,
        ]);
    }
}
