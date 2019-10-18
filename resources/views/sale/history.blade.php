@extends('layouts.app')

@section('title', '売上履歴')
@section('page_id', 'page_salesHistory')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
    @include('parts/template_mypage_header', ['current' => 'sales'])
    <div class="sales_cont">
        <div class="sales_tabs">
            <a href="{{ url('mypage/sales') }}">売上金</a>
            <a href="{{ url('mypage/sales/history') }}" class="current">売上履歴</a>
            <a href="{{ url('mypage/sales/application') }}">振込申請</a>
            <a href="{{ url('mypage/sales/application/history') }}">申請履歴</a>
        </div><!-- END sales_tabs -->
        <div class="saleslists_cont">
            <p>（全{{ $count }}件中）{{ $orders->firstItem() }}〜{{ $orders->lastItem() }}件表示</p>
            <table class="saleslists_table">
                <thead>
                <tr>
                    <th class="cell_productName">商品名</th>
                    <th class="cell_saleTo">販売先</th>
                    <th class="cell_saleDate">販売日</th>
                    <th class="cell_salePrice">販売代金</th>
                </tr>
                </thead><!-- END thead -->
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <th>商品名</th>
                        <td class="cell_productName">
                            <div class="fit_image">
                                <img src="{{ $order->fish->onePhoto->file_name }}">
                            </div>
                            <span>{{ $order->fish->fish_category_name }}</span>
                        </td>
                        <th>販売先</th>
                        <td class="cell_saleTo">{{ $order->fish->buyer ? $order->fish->buyer->name : null }}</td>
                        <th>販売日</th>
                        <td class="cell_saleDate">{{ $order->created_at->format('Y/m/d') }}</td>
                        <th>販売代金</th>
                        <td class="cell_salePrice">{{ number_format($order->price) }}円</td>
                    </tr><!-- END tr -->
                @endforeach
                </tbody><!-- END tbody -->
            </table><!-- END saleslists_table -->
            <div class="pager font_avenirnext">
                {{ $orders->links('vendor.pagination.sale') }}
            </div><!-- END pager -->
        </div><!-- END saleslists_cont -->
    </div><!-- END sales_cont -->
    </div><!-- END mp_cont -->
@endsection

@section('before_end')
    <script>
    </script>
    <link rel="stylesheet" href="{{ url('css') }}/sales.css">
@endsection
