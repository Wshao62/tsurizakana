 @extends('layouts.app')

@section('title', 'お問い合わせ完了')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_pioneercomplete')
@section('css', 'pioneer.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>飲食店会員開拓希望について</h2>
            <p class="font_avenirnext">New restaurant development</p>
        </div>
    </div>

    <div class="layout_pioneer">
        <div class="flow">
            <p><span>お問い合わせ情報入力</span></p>
            <p><span>入力情報確認</span></p>
            <p class="current"><span>入力完了</span></p>
        </div>
    </div>

    <div class="pioneer">
        <div class="layout_pioneer">
            <div class="pioneer_form">
                <h3>飲食店会員開拓希望登録が<br class="hide_pc">完了しました</h3>
                <p>飲食店会員開拓にご希望いただき<br class="hide_pc">ありがとうございました。<br>飲食店会員開拓希望を受け付けました。</p>
                <p>折り返し、担当者より<br class="hide_pc">ご連絡いたしますので、<br class="hide_sp">恐れ入りますが、しばらくお待ちください。</p>
                <p>
                    なお、ご入力いただいた<br class="hide_pc">メールアドレス宛に受付完了メールを配信しております。<br>
                    完了メールが届かない場合、<br class="hide_pc">処理が正常に行われていない<br class="hide_pc">可能性があります。<br>
                    大変お手数ですが、再度お問い合わせの<br class="hide_pc">手続きをお願い致します。
                </p>
                <a href="/" class="content_button">トップページに戻る</a>
            </div>
        </div>
    </div>

    <!-- ↓SPのみアプリダウンロード（下層全ページ共通） -->
    <div class="sp sp_app">
        <div class="spa_cont">
            <p class="white">\&nbsp;&nbsp;アプリのダウンロードはこちらから！&nbsp;/</p>
            <a class="sp_apple" href="#"><img src="{{ asset('img/store_apple.png') }}"></a>
            <a class="sp_google" href="#"><img src="{{ asset('img/store_google.png') }}"></a>
        </div>
    </div>
@endsection
