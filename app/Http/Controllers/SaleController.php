<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankRequest;
use App\Http\Requests\TransferRequest;
use App\Models\Fish\Category;
use App\Models\Order;
use App\Models\TransferRequest as TransferRequestModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class SaleController extends Controller
{
    private $order;
    private $transferRequest;

    public function __construct(Order $order, TransferRequestModel $transferRequest)
    {
        $this->order = $order;
        $this->transferRequest = $transferRequest;
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
        $orders = $this->order->closed()->sellerOwn()->paginate(12);
        $count = $this->order->closed()->sellerOwn()->count();
        return view('sale.history', compact('orders', 'count'));
    }

    /**
     * 振込申請画面を表示
     */
    public function application()
    {
        $sale_remain = $this->order->getSaleRemain();
        $able_transfer = $this->transferRequest->getAbleTransfer();
        return view('sale.application.index', compact('sale_remain', 'able_transfer'));
    }

    /**
     * 振込先銀行口座画面を表示
     *
     * @param TransferRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bank(TransferRequest $request)
    {
        $transfer_form = $request->all();
        $request->session()->put('transfer_form', $transfer_form);
        $user = Auth::user();
        return view('sale.application.bank', compact('user'));
    }

    /**
     * 振込先銀行口座画面を表示
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBank(Request $request)
    {
        $bank_form = $request->session()->get('bank_form');
        $user = Auth::user();
        return view('sale.application.bank', compact('user', 'bank_form'));
    }

    /**
     * 振込申請確認画面を表示
     *
     * @param BankRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm(BankRequest $request)
    {
        $sale_remain = $this->order->getSaleRemain();
        $transfer_form = $request->session()->get('transfer_form');
        $bank_form = $request->all();
        $request->session()->put('bank_form', $bank_form);

        return view('sale.application.confirm', compact('sale_remain', 'transfer_form', 'bank_form'));
    }

    /**
     * 振込申請完了画面を表示
     */
    public function complete(Request $request)
    {
        $bank_form = $request->session()->get('bank_form');
        $transfer_form = $request->session()->get('transfer_form');

        if (is_null($bank_form) || is_null($transfer_form)) {
            return redirect('/mypage/sales/application');
        }

        // 口座情報更新
        $user = Auth::user();
        $user->update([
            'bank_name' => $bank_form['bank_name'],
            'bank_branch_code' => $bank_form['bank_branch_code'],
            'bank_type' => $bank_form['bank_type'],
            'bank_number' => $bank_form['bank_number'],
            'bank_user_name' => $bank_form['bank_user_name'],
        ]);

        // 振込申請情報登録
        $transfer_form['requested_at'] = Carbon::now();

        $dt = Carbon::today();
        // 週の最後を金曜日に設定
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        // 月曜日締め当週支払い
        // dayOfWeekIsoは 1(月) から 7(日)で曜日を取得
        if ($dt->dayOfWeekIso == 1  || $dt->dayOfWeekIso == 6 || $dt->dayOfWeekIso == 7) {
            $transfer_form['transfer_at'] = $dt->endOfWeek();;
        } else {
            $transfer_form['transfer_at'] = $dt->addWeek()->endOfWeek();
        }
        $transfer_form['status'] = \App\Models\TransferRequest::STATUS_REQUEST;
        $this->transferRequest->fill($transfer_form)->save();

        return redirect('/mypage/sales/application/get-complete');
    }

    /**
     * 振込先銀行口座画面を表示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getComplete()
    {
        return view('sale.application.complete');
    }

    /**
     * 振込申請履歴画面を表示
     */
    public function applicationHistory()
    {
        $transfer_requests = $this->transferRequest->own()->paginate(12);
        $count = $this->transferRequest->own()->count();
        return view('sale.application.history', compact('transfer_requests', 'count'));
    }
}
