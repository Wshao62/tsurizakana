<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のトップページです。釣魚商店について・釣魚検索・会員登録・お問い合わせ等、こちらからご覧ください。')">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title')　|　{{ config('app.name', '釣魚商店') }}">
    <meta property="og:description" content="@yield('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のトップページです。釣魚商店について・釣魚検索・会員登録・お問い合わせ等、こちらからご覧ください。')">
    <meta property="og:image" content="@yield('meta_img', url('/img/common/ogimage.png'))">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="@yield('title')　|　{{ config('app.name', '釣魚商店') }}">
    <meta name="twitter:description" content="@yield('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のトップページです。釣魚商店について・釣魚検索・会員登録・お問い合わせ等、こちらからご覧ください。')">
    <meta name="twitter:image" content="@yield('meta_img', url('/img/common/ogimage.png'))">
    {{-- TODO:本リリース時に削除すること --}}
    <meta name=”robots” content=”noindex,nofollow”>
    <link rel="icon" href="{{ url('/img/common/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ url('/img/common/apple_touch_icon.png') }}">

    <title>@yield('title')　|　{{ config('app.name', '釣魚商店') }}</title>
    <link rel="stylesheet" href="{{ url('css/libs/slick.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/picker-ui/jquery.datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/index.css') }}">
    @if (trim($__env->yieldContent('css')))
    <link rel="stylesheet" href="{{ url('css') }}/@yield('css')">
    @endif
    <script src="{{ url('js/libs/jquery.min.js') }}"></script>
    <script src="{{ url('js/libs/slick.min.js') }}"></script>
    <script src="{{ url('js/libs/jquery.datetimepicker.full.min.js') }}"></script>
    @auth('user')
    <style>
    @media screen and (max-width:768px) {
        .header .header_profile {
            background: url("{{ url(\Auth::user()->photo->getCover()) }}");
            background-repeat:no-repeat;
            background-position: 50% 50%;
            background-size: cover;
        }
    }
    </style>
    @endauth
</head>

<body>
    @if (!$is_app)
    <header class="header">
        <h1 class="header_logo">
            <a href="{{ url('/') }}">
                釣魚商店 TSURIZAKANA SHOUTEN
            </a>
        </h1>
        @auth('user')
            <button class="header_alert js_notif_open icon_bell"><span class="badge">{{ Auth::user()->notificationCount() }}</span></button>
            <div class="header_notif">
                <div class="dropdown-header">
                    <span class="heading">通知</span>
                    <span class="count">{{ Auth::user()->notificationCount() }}</span>
                </div>
                <div class="dropdown-body">
                    @foreach (Auth::user()->notificationList() as $notif)
                    <div class="notification new">
                        <a href="{{ url('/') }}/mypage/fish/{{$notif->fish_id}}">
                            <div class="notification-image-wrapper">
                                <div class="notification-image">
                                    <img src="{{ $notif->profile }}" width="32">
                                </div>
                            </div>
                            <div class="notification-text">
                                <span class="highlight">{{ $notif->name }}</span>さんからメッセージが届いています。<br/>
                                <p>{{ $notif->created_at }}</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="dropdown-footer">
                    <a class="btn-mark">
                        <span class="heading">全て既読にする</span>
                    </a>
                </div>
            </div>
         @endauth
        <button class="js_header_open header_open icon_menu"></button>
        <div class="js_header_band header_band">
            <button class="js_header_close header_close icon_closs"></button>
        </div>
        <nav class="js_header_navi header_navi">
            <div class="header_navi_inner">
                <div class="header_profile @auth('user') blue_cover @endauth">
                    @auth('user')
                    <div class="header_profile_detail">
                        <div class="header_profile_image"><img src="{{ \Auth::user()->photo->getProfile() }}" alt=""></div>
                        <p class="header_profile_name">{{ Auth::user()->name }}</p>
                    </div>
                    @else
                    <div class="header_profile_logo">
                    </div>
                    @endauth
                </div>
                <div class="header_menu">
                    <p class="header_navi_title">MENU</p>
                    <ul class="header_navi_select">

                        @auth('user')
                        <li><a href="{{ url('fish') }}"><span class="icon_before icon_before_bucket"></span>売魚一覧</a></li>
                        <li><a href="{{ url('/fish/request') }}"><span class="icon_before icon_before_rod"></span>リクエスト魚一覧</a></li>
                        <li><a href="{{ url('/blog/list') }}"><span class="icon_before icon_before_rod"></span>ブログ一覧</a></li>
                        <li><a href="{{ url('/fisher/list') }}"><span class="icon_before icon_before_rod"></span>釣人一覧</a></li>
                        <li><a href="{{ url('/shop/list') }}"><span class="icon_before icon_before_rod"></span>店舗一覧</a></li>
                        <li><a href="{{ url('contact') }}"><span class="icon_before icon_before_mail"></span>お問い合わせ</a></li>
                        @endauth
                        @guest('user')
                        <li><a href="{{ url('/about') }}"><span class="icon_before icon_before_rod"></span>釣魚商店について</a></li>
                        <li><a href="@if (!Request::is('/')){{ url('/') }}@endif#pickup"><span class="icon_before icon_before_fish"></span>ピックアップ釣魚</a></li>
                        <li><a href="{{ url('/howto') }}"><span class="icon_before icon_before_phone"></span>サービスの始め方</a></li>
                        @endguest
                        <li><a href="{{ url('/question') }}"><span class="icon_before icon_before_info"></span>よくある質問</a></li>
                        @guest('user')
                        <li class="hide_sp"><a href="{{ url('/register') }}"><button class="header_navi_button content_button">会員登録</button></a></li>
                        <li class="hide_sp"><a href="{{ url('/login') }}"><button class="header_navi_button content_button">ログイン</button></a></li>
                        @endguest
                        <li class="hide_pc"><a href="{{ route('company') }}"><span class="icon_before icon_before_office"></span>運営会社</a></li>
                        <li class="hide_pc"><a href="{{ route('term') }}"><span class="icon_before icon_before_rule"></span>利用規約</a></li>
                        <li class="hide_pc"><a href="{{ route('privacy') }}"><span class="icon_before icon_before_document"></span>個人情報保護方針</a></li>
                        <li class="hide_pc"><a href="{{ route('law') }}"><span class="icon_before icon_before_note"></span>利用規約</a></li>
                    </ul>
                </div>
                @auth('user')
                <button class="js_header_dropdown header_dropdown hide_sp"><span></span></button>
                @endauth
                <div class="header_account">
                    @guest('user')
                    <p class="header_navi_title">アカウント</p>
                    <a href="{{ url('/register') }}" class="header_account_button content_button hide_pc">会員登録</a>
                    <a href="{{ url('/login') }}" class="header_account_button content_button hide_pc">ログイン</a>
                    @endguest

                    @auth('user')
                    <ul class="header_navi_select">
                        <li><a href="@if (\Auth::user()->isIdentified()){{ url('/mypage/fish')}} @else {{ url('/mypage/blog') }} @endif"><span class="icon_before icon_before_gear"></span>マイページ</a></li>
                        <li><a href="{{ url('/mypage/profile/edit')}}"><span class="icon_before icon_before_pencil"></span>プロフィール編集</a></li>
                        <li><a href=""><span class="icon_before icon_before_message"></span>売魚取引一覧</a></li>
                        <li><a href="" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><span class="icon_before icon_before_unlock"></span>ログアウト</a></li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    @endauth
                </div>
            </div>
        </nav>
    </header>
    @endif
    <main id="@yield('page_id')" class="@if ($is_app) pt_none4app @endif @if (!trim($__env->yieldContent('not_need_head_img'))) lower_bg @endif ">
        @yield('content')

        @if (!Request::is('/') && $is_app)
        {{-- ↓SPのみアプリダウンロード（下層全ページ共通）--}}
        <div class="sp sp_app">
            <div class="spa_cont">
                <p class="white">\&nbsp;&nbsp;アプリのダウンロードはこちらから！&nbsp;/</p>
                <a class="sp_apple" href="#"><img src="{{ url('/') }}/img/store_apple.png"></a>
                <a class="sp_google" href="#"><img src="{{ url('/') }}/img/store_google.png"></a>
            </div>
            </div>
        </main>
        @endif
    <footer class="footer">
        <div class="footer_copy">
            <div class="layout">
                <div class="footer_logo">釣魚商店</div>
                <div class="footer_menu">
                    <ul>
                        <li><a href="@if (!Request::is('/')){{ url('/') }}@endif#about">釣魚商店について</a></li>
                        <li><a href="@if (!Request::is('/')){{ url('/') }}@endif#pickup">ピックアップ釣魚</a></li>
                        <li><a href="@if (!Request::is('/')){{ url('/') }}@endif#recommend">サービスの始め方</a></li>
                        <li><a href="@if (!Request::is('/')){{ url('/') }}@endif#faq">よくある質問</a></li>
                        <li><a href="{{ url('/guide') }}">ご利用ガイド</a></li>
                    </ul>
                    <ul>
                        <li><a href="{{ url('fish') }}">売魚一覧</a></li>
                        <li><a href="{{ url('/fish/request') }}">リクエスト魚一覧</a></li>
                        <li><a href="{{ url('/blog/list') }}">ブログ一覧</a></li>
                        <li><a href="{{ url('/fisher/list') }}">釣人一覧</a></li>
                        <li><a href="{{ url('/shop/list') }}">店舗一覧</a></li>
                    </ul>
                    <ul>
                        <li><a href="{{ route('company') }}">運営会社</a></li>
                        <li><a href="{{ route('term') }}">利用規約</a></li>
                        <li><a href="{{ route('privacy') }}">個人情報保護方針</a></li>
                        <li><a href="{{ route('law') }}">特定商取引法に基づく表記</a></li>
                        <li><a href="{{ url('contact')}}">お問い合わせ</a></li>
                    </ul>
                </div>
                <small>Copyright&copy;釣魚商店 All Rights Reserved.</small>
            </div>
        </div>
        @if(!Request::is('/') && !$is_app)
        {{-- <div class="footer_download hide_sp">
            <p class="white">\&nbsp;&nbsp;アプリのダウンロードはこちらから！&nbsp;/</p>
            <div class="footer_store">
                <a href="#" class="store_apple">Download on the App Store</a>
                <a href="#" class="store_google">GET IT ON Google Play</a>
            </div>
        </div> --}}
        @endif
    </footer>

    <script src="{{ url('/') }}/js/slider.js" defer></script>
    <script src="{{ url('/') }}/js/common.js" defer></script>

    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
    <script src="{{ url('js/libs/echo.js') }}"></script>
    <script>
        var $authId  = "{{ Auth::check() ? Auth::user()->id : null }}";

        window.Echo = new Echo({
            broadcaster: 'socket.io',
            host: window.location.hostname + ':6001'
        });
    </script>
    <script src="{{ url('js/notification.js') }}"></script>

    @yield('before_end')
</body>

</html>
