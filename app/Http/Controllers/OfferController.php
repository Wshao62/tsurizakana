<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FishRequests;
use App\Models\Fish\Offer;
use App\Http\Requests\OfferPost;
use App\Models\UserPhoto;
use App\Models\User;
use App\Models\UserRating;
use App\Models\Fish;

class OfferController extends Controller
{
    public function offer(FishRequests $fish_req, Offer $offer)
    {
        if (!\Auth::user()->isIdentified() || $fish_req->isOwner() || $fish_req->isOffered()) {
            abort(403);
        }

        $user = \Auth::user();
        $buyer = $fish_req->user;
        return view('fish.offer.detail', [
            'fish_request' => $fish_req,
            'buyer' => $buyer,
            'buyer_rate' => $buyer->getRateCounts(),
            'seller' => $user,
            'fish' => $user->fishPublished()->with('onePhoto')->get(),
        ]);
    }

    /**
     * mypageのリクエスト魚に対するオファー一覧ページ
     *
     * @param  FishRequests $fish_req
     */
    public function list(FishRequests $fish_req)
    {
        if (!$fish_req->isOwner() || !$fish_req->isOpen()
        || !\Auth::user()->isIdentified()) {
            abort(403);
        }

        return view('fish.offer.mypage_list', [
            'offers' => $fish_req->offers()->latest()->with(['offerUser', 'fish', 'fish.onePhoto'])->paginate(10),
        ]);
    }

    public function complete(OfferPost $request, FishRequests $fish_req, Offer $offer)
    {
        if ($fish_req->isOwner() || $fish_req->isOffered()) {
            abort(403);
        }

        $data = $request->validated();
        $rtn = $offer->postOffer($_POST);
        if ($rtn === false) {
            return redirect()->back()
                    ->withInput()
                    ->with(['error' => 'システムエラーです。再度お試しいただくか、お問い合わせください。']);
        }

        return redirect('/request/offer/complete');
    }

    public function showComplete()
    {
        return view('fish.offer.complete');
    }
}
