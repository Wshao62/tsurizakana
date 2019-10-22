<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fish;
use App\Models\Order;
use Carbon\Carbon;
use App;

class ReceiptController extends Controller
{
    /*
    * Receipt List Dates
    * @return view
    */
    public function lists(Order $order)
    {
        if (!\Auth::user()->isIdentified()) {
            return redirect('/mypage/blog');
        }

        $receipts = $order->receiptDates();

        $receipt = array();
        foreach ($receipts as $year => $lists) {
            $month = array();
            foreach ($lists as $list) {
                $month[Carbon::parse($list->billed_at)->format('Y年m月')][] = $list;
            }
            $receipt[$year] = $month;
        }

        return view('receipt.receipt_list', [
            'receipt' => $receipt ]
        );
    }

    /**
     * get PDF stream
     *
     * @param  \Illuminate\Http\Request  $request
     * @return PDF stream.
     */
    public function getPDF(Request $request){
        $expDate  = explode("年", $request->date);
        $getMonth = preg_replace('/[^0-9]/','',$expDate[1]);
        $getDate  = $expDate[0].'-'.$getMonth;

        $today = Carbon::now();
        $date = new Carbon($getDate);

        if($today->month == $date->month){
           $dated = $today->toDateString();
        }else{
           $dated = $date->endOfMonth()->toDateString();
        }

        // Fetch resource database via date
        $orders = Order::receiptList($date);
        $receipts = [];
        foreach ($orders as $key => $receipt) {
            $collection              = (object) null;
            $collection->fish_name   = Fish::whereId($receipt->item_id)->first()->fish_category_name;
            $collection->billed_at   = Carbon::parse($receipt->billed_at)->format('Y年m月d日');
            $collection->fish_id     = $receipt->item_id;
            $collection->price       = $receipt->price;
            $receipts[]              = $collection;
        }
        $receipts = collect($receipts);

        $pdf = App::make('dompdf.wrapper');
        $pdf->setOptions(['isHtml5ParserEnabled' => true]);

        // Send data to the view using loadView function of PDF facade
        $pdf->loadView('receipt', [
            'date'   => mb_convert_kana(Carbon::parse($dated)->format('Y年m月d日'), 'n'),
            'total'  => mb_convert_kana($orders->sum('price') / 1.08, 'n'),
            'vat'    => mb_convert_kana($orders->sum('price') - ($orders->sum('price') / 1.08), 'n') ,
            'gtotal' => mb_convert_kana($orders->sum('price'), 'n'),
            'receipt'=> json_decode($receipts, true)
        ]);

        // Finally, you can stream the file using stream function
        $filename = Carbon::parse($dated)->format('Y年m月d日').'領収証.pdf';
        return $pdf->stream($filename);
    }

}
