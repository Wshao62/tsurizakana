<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User\Shop;

class ShopController extends Controller
{
    /**
     * 店舗一覧ページ
     *
     * @param Request $request
     * @param Shop $shop
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, Shop $shop)
    {
        $count = $request->get('count', 20);
        $search = $request->get('search', null);
        $shops = $shop::getListAll($count, 'created_at', $search);
        $total_count = $shops->total();
        $params = $request->all();
        return view('shop.list_all', compact('shops', 'total_count', 'count', 'sort', 'search', 'params'));
    }
}
