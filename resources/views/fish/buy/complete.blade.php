@extends('layouts.app')

@section('title', '決済完了')
@section('page_id', 'page_fishcomplete')
@section('css', 'fish.css')
@section('not_need_head_img', true)

@section('content')
<div class="layout">
    <div class="title-simple">
        <h2>決済完了</h2>
    </div>

    <div class="message">
        <p>{{ \Auth::user()->name }}様<br>決済が完了しました！<br>※ご請求は商品受領後です。</p>
        <p>この度は、釣魚商店を<br class="hide_pc">ご利用いただきありがとうございます。<br>
            お取引情報は、下記内容にてご確認ください。<br>
            次回も釣魚商店のご利用をお待ちしております。</p>
    </div>

    <div class="fish">
        <table class="fish_table">
            <thead>
                <tr><th>商品名</th><th>代金</th></tr>
            </thead>
            <tbody>
                <tr>
                    <th class="fish_table_number hide_pc"><div class="font_avenirnext">魚情報</div></th>
                    <th class="fish_table_status"><div>商品名</div></th>
                    <td class="fish_table_status_fish">
                    <div>
                        <div class="fit_image"><img src="{{ $fish->onePhoto['file_name'] }}" alt="{{ $fish['fish_category_name'] }}"></div>
                        <p class="fish_table_status_name">{{ $fish['fish_category_name'] }}</p>
                    </div>
                    </td>
                    <th class="fish_table_price"><div>代金</div></th><td><div>￥{{ number_format($fish['price']) }}</div></td>
                </tr>
            </tbody>
        </table>

        <div class="fish_link">
            <a href="{{ url('mypage/fish', $fish->id) }}" class="content_button_arrow">取引詳細に戻る</a>
            <a href="{{ url('/fish') }}" class="content_button_arrow">魚一覧に戻る</a>
        </div>
    </div>
</div>
</div>
@endsection
