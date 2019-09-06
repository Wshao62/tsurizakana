@extends('layouts.app')

@section('title', 'サービスの始め方')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」の釣り人の方のサービスの始め方を説明しています。①魚を釣る。②サービスにアップする。③購入される。④やり取りをする。⑤届ける。⑥評価する。の手順をわかりやすく表示しています。')
@section('page_id', 'page_howto')
@section('css', 'howto.css')
@section('not_need_header_img', true)

@section('content')
<div class="layout">
    <div class="title">
    <h2>サービスの始め方</h2>
    <p class="font_avenirnext">HOW TO START SERVICES</p>
    </div>
</div>
<div class="faq">
    <div class="layout tab">
    <div class="tab_baloon">
        <div class="js_tab_baloon tab_baloon_button current">釣り人の方</div>
        <div class="js_tab_baloon tab_baloon_button">飲食店の方</div>
    </div>
    <div class="tab_select">
        <p class="hide-pc tab_select_label">釣り人の方</p>
        <select class="js_tab_select">
        <option class="" value="#">釣り人の方</option>
        <option class="" value="#">飲食店の方</option>
        </select>
    </div>

    <div class="js_tab_baloon_inner tab_baloon_inner current">
        <h3 class="tab_baloon_title">釣り人の方のサービスの始め方</h3>
        <div class="box box_seller">
        <div class="box_image"></div>
        <div class="box_text">
            <p class="box_title">①魚を釣る</p>
            <p class="box_message">魚を釣りましょう！<br>また、ユーザーがどんな魚が欲しいかはリクエストから確認ができます。</p>
        </div>
        </div>
        <div class="box box_seller">
        <div class="box_image"></div>
        <div class="box_text">
            <p class="box_title">②サービスにアップする</p>
            <p class="box_message">釣った魚をサービスにアップしてみましょう。<br>スマートフォンアプリからもアップが可能です。</p>
        </div>
        </div>
        <div class="box box_seller">
        <div class="box_image"></div>
        <div class="box_text">
            <p class="box_title">③やりとりして条件を確定させましょう</p>
            <p class="box_message">魚をアップしたあと、チャットで問い合わせが来たらやり取りをして、配達の「日時」「配達方法」「お届け場所」などを決めましょう。</p>
        </div>
        </div>
        <div class="box box_seller">
        <div class="box_image"></div>
        <div class="box_text">
            <p class="box_title">④届ける</p>
            <p class="box_message">チャットで決めた住所、日時に購入された魚を届けに行きましょう。<br>あいさつも忘れずにお互い心地よい取引を心掛けましょう。</p>
        </div>
        </div>
        <div class="box box_seller">
        <div class="box_image"></div>
        <div class="box_text">
            <p class="box_title">⑤納品確認</p>
            <p class="box_message">釣り人と飲食店双方で魚の検品を行い、「納品確認ボタン」を押すことで契約を成立させましょう。</p>
        </div>
        </div>
        <div class="box box_seller">
        <div class="box_image"></div>
        <div class="box_text">
            <p class="box_title">⑥評価する</p>
            <p class="box_message">魚も届け、取引が終わった後はお互いの評価をしましょう。</p>
        </div>
        </div>
    </div>

    <div class="js_tab_baloon_inner tab_baloon_inner">
        <h3 class="tab_baloon_title">魚が欲しい方のサービスの始め方</h3>
        <div class="box box_buyer">
        <div class="box_image"></div>
        <div class="box_text">
            <p class="box_title">①サービスを見る</p>
            <p class="box_message">サービスを見て、欲しい魚をみつけましょう。釣魚をリクエストをする事も可能です。</p>
        </div>
        </div>
        <div class="box box_buyer">
        <div class="box_image"></div>
        <div class="box_text">
            <p class="box_title">②やりとりをして条件を確定させましょう</p>
            <p class="box_message">「魚に関する確認」や「配達日時」「配達場所の指定」などを行い条件を確定させましょう。</p>
        </div>
        </div>
        <div class="box box_buyer">
        <div class="box_image"></div>
        <div class="box_text">
            <p class="box_title">③届けられるのを待つ</p>
            <p class="box_message">チャットで話した配達日時と受け取り場所で釣盛んを受け取りましょう。</p>
        </div>
        </div>
        <div class="box box_buyer">
        <div class="box_image"></div>
        <div class="box_text">
            <p class="box_title">④納品確認</p>
            <p class="box_message">飲食店と釣り人双方で魚の検品を行い、「納品確認ボタン」を押すことで契約を成立させましょう。</p>
        </div>
        </div>
        <div class="box box_buyer">
        <div class="box_image"></div>
        <div class="box_text">
            <p class="box_title">⑤評価をする</p>
            <p class="box_message">魚も届き、取引が終わった後はお互いの評価をしましょう。</p>
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
