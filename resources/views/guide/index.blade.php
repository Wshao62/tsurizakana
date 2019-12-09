@extends('layouts.app')

@section('title', 'ご利用ガイドメニュー')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_goriyou')
@section('css', 'goriyou.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>ご利用ガイドメニュー</h2>
            <p class="font_avenirnext">Gide Menu</p>
        </div>
    </div>

    <div class="goriyou_info">
        <div class="layout">
            <div class="goriyou">
                <p><br><br><center><font size="5em" color="#4699ca">初めて方へ</font></center></p><br>
                <div class="container">
                    <div class="item"> <a href="{{ url('/hajimete/service') }}" class="content_button_sky"><font color=#ffffff>　１　サービス内容/取引の流れ<br></font></a></div>
                    <div class="item"><a href="{{ url('/hajimete/kinsi') }}" class="content_button_sky"><font color=#ffffff>　２　禁止行為／出品物<br></font></a></div>
                    <div class="item"><a href="{{ url('/hajimete/houritu') }}" class="content_button_sky"><font size="0.7px"color=#ffffff　>　３　法律の遵守（食品安全衛生法／漁業法）</font></a></div>
                    <div class="item"><a href="{{ url('/hajimete/system') }}" class="content_button_sky"><font color=#ffffff>　４　システム利用料について<br></font></a></div>
                    <div class="item"><a href="{{ url('/hajimete/sinsei') }}" class="content_button_sky"><font color=#ffffff>　５　振込申請について<br></font></a></div>
                    <div class="item"><a href="{{ url('/hajimete/direct-trading') }}" class="content_button_sky"><font color=#ffffff>　６　直接取引の禁止<br></font></a></div>
                    <div class="item"><a href="{{ url('/hajimete/cancel') }}" class="content_button_sky"><font color=#ffffff>　７　キャンセル・返金について<br></font></a></div>
                    <div class="item"><a href="{{ url('/pioneer') }}" class="content_button_sky"><font color=#ffffff>　８　飲食店会員開拓希望について<br></font></a></div>
                </div>

                <p><br><br><center><font size="5em" color="#3b82c4" >ご利用ガイド操作方法</font></center></p><br>
                <div class="container">
                    <div class="item"> <a href="{{ url('/guide/kaiin') }}" class="content_button_blue"><font color=#ffffff>　１　会員登録</font></a></div>
                    <div class="item"><a href="{{ url('/guide/shupin') }}" class="content_button_blue"><font color=#ffffff>　２　出品方法</font></a></div>
                    <div class="item"><a href="{{ url('/guide/keiyaku') }}" class="content_button_blue"><font color=#ffffff>　３　出品後～決済方法</font></a></div>
                    <div class="item"><a href="{{ url('/guide/kounyu') }}" class="content_button_blue"><font color=#ffffff>　４　購入方法</font></a></div>
                    <div class="item"><a href="{{ url('/guide/mypage') }}" class="content_button_blue"><font color=#ffffff>　５　マイページ機能</font></a></div>
                    <div class="item"><a href="{{ url('/guide/request') }}" class="content_button_blue"><font color=#ffffff>　６　リクエスト・オファー</font></a></div>
                    <div class="item"><a href="{{ url('/guide/blog') }}" class="content_button_blue"><font color=#ffffff>　７　ブログ機能</font></a></div>
                    <div class="item"><a href="{{ url('/guide/sales') }}" class="content_button_blue"><font color=#ffffff>　８　売上管理/振込申請について</font></a></div>
                </div>
            </div>
        </div>
    </div>
@endsection
