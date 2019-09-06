<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShopSearchGet;
use App\Models\User;
use App\Models\User\Shop;

class ShopController extends Controller
{
    public function list(ShopSearchGet $request)
    {
        $data = $request->all() + ['area' => '', 'keywords' => ''];
        $shop = Shop::search($request->validated());
        return view('shop.list', [
            'attributes' => $data,
            'shop' => $shop,
        ]);
    }
}
