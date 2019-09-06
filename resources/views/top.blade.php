@extends('layouts.app')

@section('title', 'トップページ')
@section('not_need_head_img', true)

@section('content')
<div class="hero">
    <div class="flex layout">
        <div class="hero_text">
            <h2>釣った魚を<span>かんたん</span>に欲しい人へ</h2>
            <p>
                釣魚商店は、スマホカメラで気軽に釣った魚を出品し、<br>
                かんたんに釣魚を購入する事が出来るサービスです。
            </p>
            <div class="hero_band">釣魚商店は、2019年<br class="hide_pc">ネット内魚取引件数業界<span class="font_avenirnext">No.1</span></div>
        </div>
        <div class="hero_phone"></div>
    </div>
</div>
<div class="search">
    <div class="layout">
        <form id="topForm" class="search_form" method="GET" action="">
            <div class="layout_760">
                <p class="search_title_line"><span>釣魚・お店を探す</span></p>
                <p class="search_title_middle"><span class="icon_before icon_before_search"></span>キーワードから探す</p>
                <input type="text" name="keyword" class="search_keyword" placeholder="キーワードを入力してください「真鯛、タラ」">

                <p class="search_title_middle"><span class="icon_before icon_before_location"></span>エリアから探す</p>
                <div class="search_area">
                    <label class="search_text_label">
                        <input type="text" name="area" class="search_keyword" placeholder="エリアを入力してください「大田区、光町」">
                    </label>
                </div>
                <div class="flex">
                    <button type="submit" class="content_button_arrow" onclick="return searchFish();">釣魚を探す</button>
                    <button type="submit" class="content_button_arrow content_button_gray" onclick="return searchShop();">お店を探す</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="about" class="about">
    <h3 class="about_title content_title">釣魚商店について</h3>
    <p class="about_text">
        釣魚商店は、釣り人と魚を買いたい人を繋げるマッチングサービスです。<br><br class="hide_pc">
        釣り人が釣った魚をサービスに掲載する事で、<br>
        購入者はその魚達を釣り人から<br class="hide_pc">直接買取る事が出来ます。
    </p>
</div>

<div id="pickup" class="pickup">
    <h3 class="pickup_title content_title">ピックアップ釣魚</h3>
    @if (count($fish) > 0)
    <div class="pickup_inner">
        <div class="js_pickup_slider pickup_slider">
            @foreach ($fish as $_f)
            <div class="pickup_card">
                <a href="{{ url('/fish', $_f->id) }}">
                    <div class="fit_image"><img src="{{ $_f->onePhoto->file_name }}" alt=""></div>
                    <div class="pickup_textarea">
                        <p class="pickup_title_middle">{{ $_f->fish_category_name }}</p>
                        <p class="pickup_price font_avenirnext">¥{{ number_format($_f->price) }}<span class="pickup_tax">（税込）</span></p>
                        <p class="pickup_location"><span class="icon_before icon_before_location"></span>{{ $_f->location }}</p>
                        <p class="pickup_time font_avenirnext"><span class="icon_before icon_before_clock"></span>{{ $_f->getFormatedCreatedAt() }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <a href="{{ url('fish') }}" class="content_button_arrow">釣魚一覧へ</a>
    @else
    <div class="layout">
        <div class="content_default_box">
            <p>売魚の登録はありません。</p>
        </div>
    </div>
    @endif
</div>

<div id="recommend" class="recommend">
    <h3 class="recommend_title content_title">こんな方におすすめです！</h3>
    <div class="recommend_inner">
        <div class="layout flex flex_center">
            <div class="recommend_panel">
                <div class="recommend_icon"><span class="icon_before icon_before_rod_blue"></span></div>
                <p class="recommend_panel_title">釣り人</p>
                <p class="recommend_text">
                    たくさん釣れ過ぎて、自分では食べきれなく、<br>
                    魚を配る相手も身近にはいない・・
                </p>
                <p class="recommend_text">
                    釣った魚が小遣い稼ぎになれば・・
                </p>
            </div>
            <div class="recommend_panel">
                <div class="recommend_icon"><span class="icon_before icon_before_basket"></span></div>
                <p class="recommend_panel_title">魚が欲しい方</p>
                <p class="recommend_text">
                    本日のオススメになにかないかな・・<br>
                    釣りたての旬の新鮮な魚をお客様にお出ししたい・・<br>
                    仕入先では入荷しない高級魚がほしい・・
                </p>
            </div>
        </div>
    </div>
</div>

<div class="howto">
    <h3 class="howto_title content_title">サービスの始め方</h3>
    <div class="layout">
        <div class="layout_860 flex flex_center">
            <div class="js_howto_panel howto_panel current">釣り人の方</div>
            <div class="js_howto_panel howto_panel">魚が欲しい方</div>
        </div>

        <div class="howto_inner current layout_860">
            <div class="howto_area">
                <div class="howto_icon"><span class="icon_before icon_before_boat"></span></div>
                <div class="howto_step">
                    <p class="font_avenirnext">STEP1</p>
                    <p>魚を釣る</p>
                </div>
                <p class="howto_text">
                    魚を釣りましょう！<br>
                    また、ユーザーがどんな魚が欲しいかは<br class="hide-sp">
                    リクエストから確認ができます。
                </p>
            </div>
            <div class="howto_area">
                <div class="howto_icon"><span class="icon_before icon_before_upload"></span></div>
                <div class="howto_step">
                    <p class="font_avenirnext">STEP2</p>
                    <p>サービスにアップする</p>
                </div>
                <p class="howto_text">
                    釣った魚をサービスにアップしてみましょう。<br>
                    スマートフォンアプリからもアップが可能です。
                </p>
            </div>
            <div class="howto_area">
                <div class="howto_icon"><span class="icon_before icon_before_pick"></span></div>
                <div class="howto_step">
                    <p class="font_avenirnext">STEP3</p>
                    <p>購入後、届ける</p>
                </div>
                <p class="howto_text">
                    購入されるのを待ちましょう！<br>
                    購入後はチャットで配達日時と場所を決め、<br class="hide-sp">
                    お届けしましょう。
                </p>
            </div>
        </div>

        <div class="howto_inner layout_860">
            <div class="howto_area">
                <div class="howto_icon"><span class="icon_before icon_before_show"></span></div>
                <div class="howto_step">
                    <p class="font_avenirnext">STEP1</p>
                    <p>サービスを見る</p>
                </div>
                <p class="howto_text">
                    サービスを確認し、お目当ての魚を見つけましょう！
                </p>
            </div>
            <div class="howto_area">
                <div class="howto_icon"><span class="icon_before icon_before_buy"></span></div>
                <div class="howto_step">
                    <p class="font_avenirnext">STEP2</p>
                    <p>魚を購入する</p>
                </div>
                <p class="howto_text">
                    お目当ての魚が見つかったら、購入をしてみましょう。<br>
                    購入後は釣り人と連絡を取り、受け取り場所と日時が確定します。
                </p>
            </div>
            <div class="howto_area">
                <div class="howto_icon"><span class="icon_before icon_before_time"></span></div>
                <div class="howto_step">
                    <p class="font_avenirnext">STEP3</p>
                    <p>届くのを待つ</p>
                </div>
                <p class="howto_text">
                    魚が届くのを待ちましょう！<br>
                    魚が届いたあとは、評価を行い取引完了となります。
                </p>
            </div>
        </div>
    </div>
</div>

<div class="search bg_lightblue">
    <h3 class="search_title content_title">釣魚を探す</h3>
    <div class="layout">
        <form class="search_form" method="GET" action="{{ url('/fish') }}">
            <div class="layout_760">
                <p class="search_title_line hide_pc"><span>釣魚を探す</span></p>
                <p class="search_title_middle"><span class="icon_before icon_before_search"></span>キーワードから探す</p>
                <input type="text" name="keyword" class="search_keyword" placeholder="キーワードを入力してください「真鯛、タラ」">

                <p class="search_title_middle"><span class="icon_before icon_before_location"></span>エリアから探す</p>
                <div class="search_area">
                    {{-- <label class="search_area_label">
                        <select>
                            <option value="" selected>都道府県</option>
                            <option value="東京都">東京都</option>
                            <option value="神奈川県">神奈川県</option>
                        </select>
                    </label> --}}
                    <label class="search_text_label">
                        <input type="text" name="area" class="search_keyword" placeholder="エリアを入力してください「大田区、光町」">
                    </label>
                </div>
                <button type="submit" class="content_button_arrow">釣魚を探す</button>
            </div>
        </form>
    </div>
</div>

<div id="faq" class="faq">
    <h3 class="faq_title content_title">よくある質問</h3>
    <div class="layout">
        <div class="js_faq_line faq_line">
            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>サービスの利用にはお金がかかりますか？</span></p>
            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>サービスの利用にお金はかかりません。魚を購入する時に魚の値段分の支払いが発生します。</span></p>
        </div>
        <div class="js_faq_line faq_line">
            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>どのようなサービスですか？</span></p>
            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚商店は、釣り人と魚を買いたい人を繋げるマッチングサービスです。釣り人が釣った魚をサービスに掲載する事で、購入者はその魚達を釣り人から直接買取る事が出来ます。</span></p>
        </div>
        <div class="js_faq_line faq_line">
            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>取引時にトラブルなどは発生しますか？<br class="hide_pc">また、フォローなどはしてもらえますか？</span></p>
            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>トラブルの発生は考えられます。その際は運営事務局までお問い合わせください。</span></p>
        </div>
        <div class="js_faq_line faq_line">
            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>写真や産地などを偽装した人を発見した場合はどうしたらいいですか？</span></p>
            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>運営事務局までお問い合わせください。出品者の登録抹消するなど対応を行います。</span></p>
        </div>
        {{-- <a href="#"><span class="content_button_arrow">よくある質問一覧</span></a> --}}
    </div>
</div>

<div class="start">
    <h3 class="start_title content_title">釣魚商店をはじめてみましょう！</h3>
    <div class="start_inner">
        <div class="start_area">
            <p>会員登録がまだの方はこちら</p>
            <a href="{{ url('/register') }}" class="content_button">会員登録</a>
        </div>
        <div class="start_area">
            <p>サービスに関するお問い合わせはこちら</p>
            <a href="{{ url('/contact') }}" class="content_button">お問い合わせ</a>
        </div>
    </div>
</div>

@if (!$is_app)
{{-- <div class="store">
    <div class="store_inner layout">
        <div class="store_phone"></div>
        <div class="store_text">
            <h4 class="store_title">アプリなら、<br class="hide_pc">釣魚商店がもっと快適に使えます！</h4>
            <p>テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。</p>
            <div class="store_image">
                <a href="#" class="store_apple">Download on the App Store</a>
                <a href="#" class="store_google">GET IT ON Google Play</a>
            </div>
        </div>
    </div>
</div> --}}
@endif
@endsection

@section('before_end')
<script>
function searchFish() {
    $('#topForm').attr('action', '{{ url("/fish") }}');
    return true;
}
function searchShop() {
    $('#topForm').attr('action', '{{ url("/shop") }}');
    return true;
}
</script>
@endsection
