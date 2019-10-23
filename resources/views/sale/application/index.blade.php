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
            <div>
                @if ($errors->has('price'))
                    <p class="error">
                        {{ $errors->first('price') }}
                    </p>
                @endif
            </div>
            <form action="{{ url('/mypage/sales/application/bank') }}" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
                <table class="application_table">
                    <tr>
                        <th>現在の売上金</th>
                        <td>{{ number_format($sale_remain) }}円</td>
                    </tr>
                    <tr>
                        <th>振込申請可能額</th>
                        <td>
                            {{ number_format($able_transfer) }}円
                            <input type="hidden" id="able_transfer" value="{{ $able_transfer }}">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            振込申請額<br>
                            <span>※申請金額は現在の売上金の範囲内で入力してください。また、申請金額は1,000円以上から可能です。</span>
                        </th>
                        <td>
                            <input class="input_transferPrice" type="text" name="price" value="{{ old('price') }}">
                            <span>円</span>
                        </td>
                    </tr>
                    <tr class="applicatioTable_child">
                        <th>振込手数料</th>
                        <td>300円</td>
                        <input type="hidden" name="fee" value="300">
                    </tr>
                    <tr class="applicatioTable_child">
                        <th>実際の振込額</th>
                        <td>
                            <span class="calculated_price"></span>円
                            <input type="hidden" name="transfer_price" value="">
                        </td>
                    </tr>
                    <tr>
                        <th>申請後の売上残高</th>
                        <td><span class="remain_after"></span>円</td>
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
        $(function() {
            $('[name=price]').change (function() {
                if ($(this).val() !== '') {
                    if (Number($('#able_transfer').val()) < $(this).val()) {
                        alert('振込申請可能額を上回っています。');
                        $(this).val('');
                        return false;
                    }
                    if ($(this).val() < 1000) {
                        alert('申請金額は1,000円以上から可能です。');
                        $(this).val('');
                        return false;
                    }
                    $('.calculated_price').text(($(this).val() - 300).toLocaleString());
                    $('[name=transfer_price]').val(($(this).val() - 300));
                    $('.remain_after').text(({{ $sale_remain }} - $(this).val()).toLocaleString());
                } else {
                    $('.calculated_price').text('');
                    $('[name=transfer_price]').val('');
                    $('.remain_after').text('');
                }
            });

            const price = $('[name=price]').val();
            if (price !== '') {
                $('.calculated_price').text(($('[name=price]').val() - 300).toLocaleString());
                $('[name=transfer_price]').val((($('[name=price]').val() - 300)));
                $('.remain_after').text(({{ $sale_remain }} - $('[name=price]').val()).toLocaleString());
            }
        })
    </script>
    <link rel="stylesheet" href="{{ url('css') }}/sales.css">
    <style>
        .error {
            color: red;
            text-align: center;
        }
    </style>
@endsection
