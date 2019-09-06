<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;

class PaymentManagementController extends Controller
{
    public function lists()
    {
        $year = [];
        for ($y = 2019; $y <= date('Y'); $y++) {
            for ($m = 1; $m <= 12; $m++) {
                $year[$y.'-'.sprintf('%02d', $m)] = $y.'年'.$m.'月';
                if (date('Ym') == $y.sprintf('%02d', $m)) {
                    break 2;
                }
            }
        }
        return view('admin.payments.payment_management', [
            'users' => User::all(),
            'ym' => $year,
        ]);
    }

    public function getPaymentData(Request $request)
    {
        return response()->json(Order::getDataTable($request->all()));
    }

    // public function joinTable(){
    //      $query = DB::table('orders')
    //                  ->join('users', function($qry){
    //                      $qry->on('users.id', '=', 'orders.user_id');
    //                  })
    //                 ->select('orders.user_id', DB::raw('sum(orders.price) as price'), 'users.name',
    //                             DB::raw('sum(orders.price) * ' . config('const.service_charge') . ' as ServiceFee '),
    //                             DB::raw('DATE_FORMAT(orders.billed_at, "%Y") as billYear' ),
    //                             DB::raw('DATE_FORMAT(orders.billed_at, "%m") as billMonth'))
    //                 ->groupBy('orders.user_id','users.name',DB::raw('DATE_FORMAT(orders.billed_at, "%Y")' ), DB::raw('DATE_FORMAT(orders.billed_at, "%m")') );
    //      return $query;
    // }
}
