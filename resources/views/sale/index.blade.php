@extends('layouts.app')

@section('title', '売上金')
@section('page_id', 'page_sales')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
    @include('parts/template_mypage_header', ['current' => 'sales'])
    <div class="sales_cont">
        <div class="sales_tabs">
            <a href="{{ url('mypage/sales') }}" class="current">売上金</a>
            <a href="{{ url('mypage/sales/history') }}">売上履歴</a>
            <a href="{{ url('mypage/sales/application') }}">振込申請</a>
            <a href="{{ url('mypage/sales/application/history') }}">申請履歴</a>
        </div><!-- END sales_tabs -->
        <table class="sales_table">
            <tr>
                <th>現在の売上金残高</th>
                <td>{{ number_format($sale_remain) }}円</td>
            </tr>
            <tr>
                <th>累計売上高</th>
                <td>{{ number_format($sale_total) }}円</td>
            </tr>
        </table><!-- END sales_table -->
    </div><!-- END sales_cont -->
    </div><!-- END mp_cont -->
@endsection

@section('before_end')
    <script>
    </script>
    <link rel="stylesheet" href="{{ url('css') }}/sales.css">
@endsection
