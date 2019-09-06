@extends('layouts.app')

@section('title', '釣魚商店について')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_about')
@section('css', 'about.css')
@section('not_need_header_img', true)

@section('content')
<div class="layout">
    <div class="title">
    <h2>釣魚商店について</h2>
    <p class="font_avenirnext">ABOUT</p>
    </div>
</div>

<div class="about_info">
    <div class="layout">
    <h3 class="about_info_title">
        <span>釣った魚</span>を<br class="hide_pc"><span>欲しい人</span>に届ける<br class="hide_pc"><span>サービス</span>です。
    </h3>
    <p class="about_info_text">
        釣魚商店は、釣り人と<br class="hide_pc">新鮮で安価な魚を仕入れたい飲食店を<br class="hide_pc">マッチングするサービスです。<br>
        WEBサイト・専用アプリからカンタンに<br class="hide_pc">ご利用いただけます。<br>
        シンプルなやりとりで新鮮な魚が手に入ります。
    </p>
    <div class="about_info_area">
        <div class="about_info_sell">
        <div class="about_info_image"></div>
        <p>釣る人</p>
        </div>
        <div class="about_info_arrow"></div>
        <div class="about_info_buy">
        <div class="about_info_image"></div>
        <p>魚がほしい人</p>
        </div>
    </div>

    <div class="info_block">
        <div class="info_block_box">
        <div class="info_block_image"></div>
        <div class="info_block_inner">
            <h4 class="info_block_title">新鮮な魚を安価でほしい方へ</h4>
            <p class="info_block_text">
            「旬な魚」や「今ほしい魚」を新鮮な状態でリクエストすることができます。あなたのお店の「今日のおすすめメニュー」の一品にいかがでしょうか。
            </p>
            <p class="info_block_text">
            朝獲れの新鮮な魚料理をあなたの店のウリにすることで店の繁盛間違いなし！です。
            </p>
            <a href="{{ url('/howto') }}" class="content_button_arrow">サービスの始め方はこちら</a>
        </div>
        </div>
        <div class="info_block_box">
        <div class="info_block_image"></div>
        <div class="info_block_inner">
            <h4 class="info_block_title">釣った魚を売りたい方へ</h4>
            <p class="info_block_text">
            「朝獲れ釣魚はなんでこんなに旨いのだろう！」<br>
            釣り人は、「自分の釣った魚を、他の誰かにも喜んで食べてもらいたい」と願っていますよね。
            </p>
            <p class="info_block_text">
            釣魚商店には、たくさんのお店が、あなたの釣った魚を待っています。<br>
            あなたの釣った魚をお店に届けてみませんか？
            </p>
            <a href="{{ url('/howto') }}" class="content_button_arrow">サービスの始め方はこちら</a>
        </div>
        </div>
    </div>
    </div>
</div>


<div class="start">
    <h3 class="start_title content_title">釣魚商店をはじめてみましょう！</h3>
    <div class="start_inner">
    <div class="start_area">
        <p>会員登録がまだの方はこちら</p>
        <a href="{{ route('register') }}" class="content_button">会員登録</a>
    </div>
    <div class="start_area">
        <p>サービスに関するお問い合わせはこちら</p>
        <a href="{{ url('/contact') }}" class="content_button">お問い合わせ</a>
    </div>
    </div>
</div>
@endsection
