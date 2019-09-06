<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv=“content-language” content=“{{ str_replace('_', '-', app()->getLocale()) }}”>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description')">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="@yield('meta_url')" />
    <meta property="og:image" content="/teaser/img/img_{{$__env->yieldContent('class')}}/ogp.png" />
    <meta property="og:site_name" content="@yield('title') | {{ config('app.name', '釣魚商店') }}" />
    <title>@yield('title') | {{ config('app.name', '釣魚商店') }}</title>
    <meta property="og:description" content="@yield('meta_description')"/>
    <link href="{{ url('/') }}/teaser/img/common/favicon.ico" rel="icon" type="image/png">
    <link rel="stylesheet" href="/teaser/css/index.css">
  </head>
  <body>
    <div id="{{$__env->yieldContent('class')}}">
      <header id="home">
        <div class="header_logo">
          <a href="#"><img class="hover" src="/teaser/img/common/logo.png" alt="{{ config('app.name', '釣魚商店') }}"></a>
        </div>
        <div class="header_menu pc">
          <ul class="header_menu_lists">
            <li><a class="hover header_menu_list menu_link" href="#about_service">{{ config('app.name', '釣魚商店') }}について</a></li>
            <li><a class="hover header_menu_list menu_link" href="#merits">メリット</a></li>
            <li><a class="hover header_menu_list menu_link" href="#services">サービス</a></li>
            <li><a class="hover header_menu_list menu_link" href="#how_to">こんな使い方ができる</a></li>
            <li><a class="hover header_menu_list menu_link" href="#contact">お問い合わせ</a></li>
            <li class="header_registration"><a class="hover menu_link" href="#registration">事前登録はこちら</a></li>
          </ul>
        </div>
        <!-- ヘッダー SP用メニュー（ハンバーガー） -->
        <div class="sp_header_menu sp">
          <div class="menu_btn_container">
            <a class="menu_btn" href="#"><img src="/teaser/img/common/menu.png" alt=""></a>
          </div>
          <div class="nav">
            <div class="nav_container">
              <ul class="sp_menu">
                <li><a class="home_link" href="#home">HOME</a></li>
                <li><a class="menu_link" href="#about_service">{{ config('app.name', '釣魚商店') }}について</a></li>
                <li><a class="menu_link" href="#merits">メリット</a></li>
                <li><a class="menu_link" href="#services">サービス</a></li>
                <li><a class="menu_link" href="#how_to">こんな使い方ができる</a></li>
                <li><a class="menu_link" href="#contact">お問い合わせ</a></li>
              </ul>
              {{-- <div class="nav_sns">
                <a class="nav_tw" href="#"><img src="/teaser/img/common/icon_tw.png" alt="Twitter">Twitterはこちら</a>
                <a class="nav_fb" href="#"><img src="/teaser/img/common/icon_fb.png" alt="Facebook">Facebookはこちら</a>
              </div> --}}
              <div class="close">
                <div class="close_contents">
                  <img src="/teaser/img/common/icon_close.png" alt="CLOSE">
                  <p>CLOSE</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>
      <main>
            @yield('content')
        <!-- 事前登録 -->
        <div id="registration" class="section">
          <h2 class="ttl_main txt_w">事前登録<span class="ttl_en">Registration</span></h2>
          <div class="registration_contents">
            <p>
              サービスが気になった方は事前登録をお願いします。<br>
              事前登録をする事で、サービスリリース時のお知らせと先行登録をして頂いた方に対してブログを書ける機能を<br class="pc">先行してご利用頂く事が可能になります。
            </p>
            <div id="registration_form" class="registration_form_container">
              @if (session('is_registerd'))
              <p class="registration_success">
              ご登録ありがとうございます。<br>
              ご入力いただいたメールアドレスに登録完了メールを送信しましたので、ご確認ください。
              </p>
              @endif
              <p>
                事前登録は下記のフォームからメールアドレスを入力し、<br>送信ボタンをクリックしてください。
              </p>
              <form method="POST" action="{{ route('register') }}">
                  <div class="registration_form">
                        @csrf
                        <input type="text" name="email" value="{{ old('email') }}">
                        <input class="hover" type="submit" name="submit" value="送信">
                </div>
                @if ($errors->has('email'))
                    <span class="error">
                        {{ $errors->first('email') }}
                    </span>
                @endif
              </form>
            </div>
          </div>
        </div>
      <!-- お問い合わせ -->
        <div id="contact" class="section">
          <h2 class="ttl_main">お問い合わせ<span class="ttl_en">Contact</span></h2>
          @include('parts/template_contact')
          </div>
      </main>

      <footer>
        <img src="/teaser/img/common/logo_footer.png" alt="{{ config('app.name', '釣魚商店') }}">
        <p>Copyright©{{ config('app.name', '釣魚商店') }} All Rights Reserved.</p>
      </footer>

      <script src="/teaser/js/jquery.min.js"></script>
      <script src="/teaser/js/script.js"></script>
      <script src="/teaser/js/swiper.js"></script>
      <script src="/teaser/js/slideSetting.js"></script>

    </div>
  </body>
</html>
