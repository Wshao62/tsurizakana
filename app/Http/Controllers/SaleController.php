<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Session;
use Zend\Diactoros\Request;

class SaleController extends Controller
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * 売上管理画面を表示
     */
    public function index()
    {
        $sale_remain = $this->order->getSaleRemain();
        $sale_total = $this->order->getSaleTotal();
        return view('sale.index', compact('sale_remain', 'sale_total'));
    }

    /**
     * 売上履歴画面を表示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function history()
    {
        $orders = $this->order->closed()->paginate(12);
        $count = $this->order->closed()->count();
        return view('sale.history', compact('orders', 'count'));
    }

    /**
     * 振込申請画面を表示
     */
    public function application()
    {
        return view('sale.application.index');
    }

    /**
     * 振込先銀行口座画面を表示
     */
    public function bank()
    {
        return view('sale.application.bank');
    }

    /**
     * 振込申請確認画面を表示
     */
    public function confirm()
    {
        return view('sale.application.confirm');
    }

    /**
     * 振込申請完了画面を表示
     */
    public function complete()
    {
        return view('sale.application.complete');
    }

    /**
     * 振込申請履歴画面を表示
     */
    public function applicationHistory()
    {
        return view('sale.application.history');
    }


}
