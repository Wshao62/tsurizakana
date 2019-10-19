@extends('layouts.app')

@section('title', '入力情報確認')
@section('page_id', 'page_transferConfirm')
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
                <p>振込内容</p>
                <span>></span>
                <p>振込先<br class="sp">銀行口座</p>
                <span>></span>
                <p class="current">入力情報<br class="sp">確認</p>
                <span>></span>
                <p>登録完了</p>
            </div><!-- END application_flow -->
            <form action="{{ url('/mypage/sales/application/complete') }}" method="post">
                @csrf
                <table class="confirm_table">
                    <thead>
                    <tr>
                        <th colspan="2">振込内容</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>現在の売上金</th>
                        <td>{{ number_format($sale_remain) }}円</td>
                    </tr>
                    <tr>
                        <th>振込申請金額</th>
                        <td>{{ number_format($transfer_form['price']) }}円</td>
                    </tr>
                    <tr>
                        <th>振込手数料</th>
                        <td>{{ number_format($transfer_form['fee']) }}円</td>
                    </tr>
                    <tr>
                        <th>実際の振込額</th>
                        <td>{{ number_format($transfer_form['transfer_price']) }}円</td>
                    </tr>
                    <tr>
                        <th>申請後の売上残高</th>
                        <td>{{ number_format($sale_remain - $transfer_form['price']) }}円</td>
                    </tr>
                    </tbody>
                </table><!-- END confirm_table -->
                <table class="confirm_table">
                    <thead>
                    <tr>
                        <th colspan="2">振込銀行口座</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>銀行名</th>
                        <td>{{ $bank_form['bank_name'] }}</td>
                    </tr>
                    <tr>
                        <th>支店コード</th>
                        <td>{{ $bank_form['bank_branch_code'] }}</td>
                    </tr>
                    <tr>
                        <th>口座種別</th>
                        <td>{{ \App\Models\User::BANK_TYPE_NAME[$bank_form['bank_type']] }}</td>
                    </tr>
                    <tr>
                        <th>口座番号</th>
                        <td>{{ $bank_form['bank_number'] }}</td>
                    </tr>
                    <tr>
                        <th>口座名義（カナ）</th>
                        <td>{{ $bank_form['bank_user_name'] }}</td>
                    </tr>
                    </tbody>
                </table><!-- END confirm_table -->
                <div class="application_btn">
                    <button class="applctn_btn_gray return_btn">修正する</button>
                    <button class="applctn_btn_blue">申請する</button>
                </div><!-- END application_btn -->
            </form><!-- END form -->
        </div><!-- END application_cont -->
    </div><!-- END sales_cont -->
    </div><!-- END mp_cont -->
@endsection

@section('before_end')
    <script>
        $(function() {
            $('.return_btn').click (function(e) {
                e.preventDefault();
                document.location.href = "{{ url('/mypage/sales/application/get-bank') }}";
            })
        })
    </script>
    <link rel="stylesheet" href="{{ url('css') }}/sales.css">
@endsection
