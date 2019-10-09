@extends('layouts.app')

@section('title', '振込内容')
@section('page_id', 'page_transfers')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
    @include('parts/template_mypage_header', ['current' => 'sales'])
    <div class="sales_cont">
        <div class="sales_tabs">
            <a href="{{ url('mypage/sales') }}">売上金</a>
            <a href="{{ url('mypage/sales/history') }}">売上履歴</a>
            <a href="{{ url('mypage/sales/application') }}" class="current">振込申請</a>
            <a href="{{ url('mypage/sales/application/history') }}">申請履歴</a>
        </div><!-- END sales_tabs -->
        <div class="application_cont">
            <div class="application_flow">
                <p class="current">振込内容</p>
                <span>></span>
                <p>振込先<br class="sp">銀行口座</p>
                <span>></span>
                <p>入力情報<br class="sp">確認</p>
                <span>></span>
                <p>登録完了</p>
            </div><!-- END application_flow -->
            <form>
                <table class="application_table">
                    <tr>
                        <th>現在の売上金</th>
                        <td>10,000円</td>
                    </tr>
                    <tr>
                        <th>
                            振込申請額<br>
                            <span>※申請金額は現在の売上金の範囲内で入力してください。また、申請金額は1,000円以上から可能です。</span>
                        </th>
                        <td>
                            <input class="input_transferPrice" type="text">
                            <span>円</span>
                        </td>
                    </tr>
                    <tr class="applicatioTable_child">
                        <th>振込手数料</th>
                        <td>300円</td>
                    </tr>
                    <tr class="applicatioTable_child">
                        <th>実際の振込額</th>
                        <td><span class="calculated_price">9,700</span>円</td>
                    </tr>
                    <tr>
                        <th>申請後の売上残高</th>
                        <td>0円</td>
                    </tr>
                </table><!-- END application_table -->
                <div class="application_btn">
                    <button class="applctn_btn_blue">次へ</button>
                </div><!-- END application_btn -->
            </form><!-- END form -->
        </div><!-- END application_cont -->
    </div><!-- END sales_cont -->
    </div><!-- END mp_cont -->
@endsection

@section('before_end')
    <script>
    </script>
    <link rel="stylesheet" href="{{ url('css') }}/sales.css">
@endsection
