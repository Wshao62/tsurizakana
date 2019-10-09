@extends('layouts.app')

@section('title', '登録完了')
@section('page_id', 'page_transferComplete')
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
                <p>入力情報<br class="sp">確認</p>
                <span>></span>
                <p class="current">登録完了</p>
            </div><!-- END application_flow -->
            <p class="transfer_comptext">
                振込申請が完了しました。<br>
                入金は4営業日以内を予定しております。
            </p>
            <div class="application_btn">
                <a href="#" class="applctn_btn_blue">マイページへ</a>
            </div><!-- END application_btn -->
        </div><!-- END application_cont -->
    </div><!-- END sales_cont -->
    </div><!-- END mp_cont -->
@endsection

@section('before_end')
    <script>
    </script>
    <link rel="stylesheet" href="{{ url('css') }}/sales.css">
@endsection
