@extends('layouts.app')

@section('title', '購入確認')
@section('page_id', 'page_fishbuy')
@section('css', 'fish.css')
@section('not_need_head_img', true)

@section('content')
<div class="layout">
    <div class="title-simple">
        <h2>購入確認</h2>
    </div>

    <div class="fish">
    @if (count($errors) > 0)
    <div class="content_alert_box">
        <span class="alert">パラメータエラーです。再度決済をしてください。</span>
    </div>
    @endif
        <table class="fish_table">
            <thead>
                <tr><th>商品名</th><th>金額</th></tr>
            </thead>
            <tbody>
                <tr>
                    <th class="fish_table_number hide_pc"><div class="font_avenirnext">魚情報</div></th>
                    <th class="fish_table_status"><div>商品名</div></th>
                    <td class="fish_table_status_fish">
                    <div>
                        <div class="fit_image"><img src="{{ $fish->onePhoto->file_name }}" alt=""></div>
                        <p class="fish_table_status_name">{{ $fish['fish_category_name'] }}</p>
                    </div>
                    </td>
                    <th class="fish_table_price"><div>代金</div></th><td><div>￥{{ number_format($fish['price']) }}</div></td>
                </tr>
            </tbody>
        </table>

        <div class="fish_link">
            <a href="" class="content_button_arrow" id="btn_exec_buy">決済する</a>
            <p>※ご請求は商品の受領後に確定されます。<br class="sp">それまで請求が行われることはありません。</p>
        </div>

        <form id="buy_form" method="POST" action="{{ url('fish/'.$fish['id'].'/buy') }}">
            @csrf
            <input type="hidden" name="fish_id" value="{{ $fish['id'] }}">
            <input type="hidden" name="buy_token" value="">
        </form>
    </div>
</div>
@endsection

@section('before_end')
<script src="https://checkout.stripe.com/checkout.js"></script>
<script>
let handler = StripeCheckout.configure({
    key: '{{ config('stripe.token') }}',
    image: '{{ url(config('stripe.icon_image')) }}',
    locale: 'auto',
    token: function(token) {
        $('input[name="buy_token"]').val(token.id);
        $('#buy_form').submit();
    },
    capture: false,
});

$(function(){
    $('#btn_exec_buy').on('click', function(e) {

        handler.open({
            name: '{{ config('app.name') }}',
            description: '{{ $fish->seller['name'] }}さん出品の{{ $fish['fish_category_name'] }}',
            locale: 'jp',
            currency: 'jpy',
            amount: {{ $fish['price'] }},
            email: "{{ \Auth::user()['email'] }}"
        });
        e.preventDefault();
    });

    {{-- "戻る"をされた際は決済画面を消す --}}
    history.pushState(null, null, null);
    $(window).on("popstate", function (event) {
        if (!event.originalEvent.state) {
            handler.close();
            return;
        }
    });
});

{{-- window.addEventListener('popstate', function() {
}); --}}
</script>
@endsection