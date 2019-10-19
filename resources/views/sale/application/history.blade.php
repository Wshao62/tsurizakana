@extends('layouts.app')

@section('title', '申請履歴')
@section('page_id', 'page_transferApplications')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
    @include('parts/template_mypage_header', ['current' => 'sales'])
    <div class="sales_cont">
        <div class="sales_tabs">
            <a href="{{ url('mypage/sales') }}">売上金</a>
            <a href="{{ url('mypage/sales/sale-history') }}">売上履歴</a>
            <a href="{{ url('mypage/sales/application') }}">振込申請</a>
            <a href="{{ url('mypage/sales/application-history') }}" class="current">申請履歴</a>
        </div><!-- END sales_tabs -->
        <div class="saleslists_cont">
            <p>（全{{ $count }}件中）{{ $transfer_requests->firstItem() }}〜{{ $transfer_requests->lastItem() }}件表示</p>
            <table class="saleslists_table">
                <thead>
                <tr>
                    <th class="cell_status">ステータス</th>
                    <th class="cell_applicationDate">申請日時</th>
                    <th class="cell_applicationPrice">振込申請金額</th>
                    <th class="cell_fee">振込手数料</th>
                    <th class="cell_transferPrice">振込金額</th>
                    <th class="cell_transferTo">振込先</th>
                </tr>
                </thead><!-- END thead -->
                <tbody>
                @foreach ($transfer_requests as $transfer_request)
                    <tr>
                        <th>ステータス</th>
                        <td class="cell_status">{{ \App\Models\TransferRequest::STATUS_NAMES[$transfer_request->status] }}</td>
                        <th>申請日時</th>
                        <td class="cell_applicationDate">{{ $transfer_request->requested_at }}</td>
                        <th>振込申請金額</th>
                        <td class="cell_applicationPrice">{{ number_format($transfer_request->price) }}</td>
                        <th>振込手数料</th>
                        <td class="cell_fee">{{ number_format($transfer_request->fee) }}円</td>
                        <th>振込金額</th>
                        <td class="cell_transferPrice">{{ number_format($transfer_request->transfer_price) }}円</td>
                        <th>振込先</th>
                        <td class="cell_transferTo">
                            {{ $transfer_request->user->bank_name }}<br>
                            {{ $transfer_request->user->bank_branch_code }} {{ \App\Models\User::BANK_TYPE_NAME[$transfer_request->user->bank_type] }} {{ $transfer_request->user->bank_number }}<br>
                            {{ $transfer_request->user->bank_user_name }}
                        </td>
                    </tr><!-- END tr -->
                @endforeach
                </tbody><!-- END tbody -->
            </table><!-- END saleslists_table -->
            <div class="pager font_avenirnext">
                {{ $transfer_requests->links('vendor.pagination.sale') }}
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
