@extends('layouts.teaser')

@section('title', '釣り魚商店ティザーサイト（売り主様向け）')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のティザーサイトです。釣った魚の写真を撮り、サイトにアップする事で近隣で魚を求めている方に販売する事が出来ます。釣果で終わるのではなく、釣った魚をお金にしてみませんか？')
@section('class', 'seller')

@section('content')
        <!-- PC用TOPへ戻る、SNSアイコン -->
        <div class="icons">
          <img class="btn_pagetop_sp" src="teaser/img/img_seller/btn_pagetop.png" alt="TOPへ戻る">
          <img class="hover btn_pagetop" src="teaser/img/img_seller/btn_pagetop.png" alt="TOPへ戻る">
          {{-- <a class="hover" href="#"><img src="teaser/img/img_seller/btn_tw.png" alt="Twitter"></a>
          <a class="hover" href="#"><img src="teaser/img/img_seller/btn_fb.png" alt="Facebook"></a> --}}
        </div>
        <!-- SP用追従事前登録ボタン -->
        <div class="sp registration_btn">
          <a class="menu_link" href="#registration">事前登録はこちら</a>
        </div>


        <!-- メイン　コピー -->
        <div class="copy">
          <!-- PC用動画 -->
          <video class="pc" playsinline autoplay muted loop>
            <source src="teaser/video/main_video_seller.mp4" type="video/mp4">
            <source src="teaser/video/main_video_seller.webm" type="video/webm">
          </video>
          <!-- SP用画像 -->
          <img class="sp copy_bg_img" src="teaser/img/img_seller/mainimg_sp.jpg" alt="">
          <!-- SPのテキストは画像で対応 -->
          <img class="sp copy_text_img" src="teaser/img/img_buyer/maintxt_sp.png" alt="">
          <p class="main_copy pc">
            釣り人の<span>「誰かに」</span>と<br>
            お店の<span>「欲しい」</span>をあなたに
          </p>
          <p class="sub_copy pc">新鮮な釣魚を気軽に売買が出来る<br class="sp">マッチングサービス</p>
          <a class="scrollDown_btn pc" href="#"><span></span></a>
        </div>


        <!-- 釣魚商店について -->
       <div class="about_service section">
          <div id="about_service" class="container">
            <h2 class="ttl_main txt_w">釣魚商店について<span class="ttl_en">About</span></h2>
            <p>
              釣魚商店は、釣り人と魚を買いたい人とを繋ぐマッチングサービスです。<br>
              釣り人が釣った魚をサービスに掲載する事で、<br class="pc">購入者はその魚達を釣り人から直接買取る事が出来ます。<br>
              釣った魚を直接店舗に売る事で、<br class="pc">魚を有効活用し、あなたの「好き」をお金にする事が可能です。
            </p>
            <!-- 釣魚商店ロゴ -->
            <img src="teaser/img/about_logo.png" alt="釣魚商店">
          </div>
        </div>


        <!-- スライダー -->
        <div id="slider" class="section">
          <!-- スライダー全体を括るメインコンテナ -->
          <div class="swiper-container">
            <!-- 全スライドをまとめるラッパー -->
            <div class="swiper-wrapper">
              <!-- 各スライド -->
              <div class="swiper-slide"><img src="teaser/img/about_img_01.jpg" alt=""></div>
              <div class="swiper-slide"><img src="teaser/img/about_img_02.jpg" alt=""></div>
              <div class="swiper-slide"><img src="teaser/img/about_img_03.jpg" alt=""></div>
            </div>
          </div>
        </div>


        <!-- メリット -->
        <div id="merits" class="section">
          <img class="marit_left_img pc" src="teaser/img/img_seller/merit_bg_l_pc.png" alt="">
          <img class="marit_right_img pc" src="teaser/img/img_seller/merit_bg_r_pc.png" alt="">

          <h2 class="ttl_main">メリット<span class="ttl_en">Merits</span></h2>
          <div class="container">
            <!-- メリット01～06 -->
            <div class="marit merit_odd">
              <p class="merit_number">01</p>
              <h3>安心の直接取引</h3>
              <img src="teaser/img/img_seller/merit_icon_01.png" alt="安心の直接取引">
              <p class="merit_description">
                安全な評価制度のもと、<br>信頼の出来る店舗/個人に<br class="pc">魚を売る事が可能です。
              </p>
            </div>
            <div class="marit merit_even">
              <p class="merit_number">02</p>
              <h3>売れるのは「近隣」のみ</h3>
              <img src="teaser/img/img_seller/merit_icon_02.png" alt="売れるのは「近隣」のみ">
              <p class="merit_description">
                魚を売る事が出来るのは近隣のみの為、<br>手が届く範囲で売る事が出来ます。
              </p>
            </div>
            <div class="marit merit_odd">
              <p class="merit_number">03</p>
              <h3>欲しい魚がわかる</h3>
              <img src="teaser/img/img_seller/merit_icon_03.png" alt="欲しい魚がわかる">
              <p class="merit_description">
                サービスには、リクエスト機能がある為、<br>店舗/個人が
                欲しい魚が<br class="pc">ひと目で分かります。
              </p>
            </div>
            <div class="marit merit_even">
              <p class="merit_number">04</p>
              <h3>すぐに取引が行われる</h3>
              <img src="teaser/img/img_seller/merit_icon_04.png" alt="すぐに取引が行われる">
              <p class="merit_description">
                釣って出品された魚は、沢山の<br>「買取り希望者」が見ている為、<br>リアルタイムで売買がされます。
              </p>
            </div>
            <div class="marit merit_odd">
              <p class="merit_number">05</p>
              <h3>どんなデバイスでもOK</h3>
              <img src="teaser/img/img_seller/merit_icon_05.png" alt="どんなデバイスでもOK">
              <p class="merit_description">
                Webサイト、iOSアプリ、<br>Androidアプリでご利用が可能です。
              </p>
            </div>
            <div class="marit merit_even">
              <p class="merit_number">06</p>
              <h3>使いやすいサイト</h3>
              <img src="teaser/img/img_seller/merit_icon_06.png" alt="使いやすいサイト">
              <p class="merit_description">
                サイトは人間中心設計に基づく<br>使いやすい設計の為、<br>誰でもご利用出来ます。
              </p>
            </div>
            <div class="clear"></div>
          </div>
        </div>
        <div class="clear"></div>


        <!-- サービス -->
        <div id="services" class="section">
          <div class="services_title">
            <!-- PC用タイトル背景 -->
            <img class="pc" src="teaser/img/img_seller/service_title_pc.png" alt="">
            <!-- SP用タイトル背景 -->
            <img class="sp" src="teaser/img/img_seller/service_title_sp.png" alt="">
            <div class="services_title_text">
              <h2 class="ttl_main txt_w">サービス<span class="ttl_en">Service</span></h2>
            </div>
          </div>
          <div class="container">
            <div class="service service_01">
              <div class="s_img_container">
                <img class="service_img" src="teaser/img/img_seller/service_img_01.jpg" alt="">
                <img class="service_bg sp" src="teaser/img/img_seller/service_bg.png" alt="">
              </div>
              <div class="service_contents">
                <p class="service_number">SERVICE01</p>
                <h3>好きがお金に釣果がお金に</h3>
                <p class="service_description">
                  釣魚商店では、自分が釣った魚ををサービスに掲載する事で魚を店舗/個人向けに売る事が可能です。<br>
                  好きな釣りによって得た釣果をお金に出来る他、求めれれている人に魚を提供する事で全ての方がハッピーになるようなシステムです。
                </p>
              </div>
              <div class="clear"></div>
              <img class="service_bg pc" src="teaser/img/img_seller/service_bg.png" alt="">
            </div>
            <div class="service service_02">
              <div class="s_img_container">
                <img class="service_img" src="teaser/img/img_seller/service_img_02.jpg" alt="">
                <img class="service_bg sp" src="teaser/img/img_seller/service_bg.png" alt="">
              </div>
              <div class="service_contents">
                <p class="service_number">SERVICE02</p>
                <h3>リクエスト機能で欲しい魚を確認</h3>
                <p class="service_description">
                  店舗や個人の方欲しい魚は「リクエスト」としてサービスで確認する事が出来る為、お金になる魚はどの魚か判別出来る他、その魚を狙う面白みも味わう事ができます。<br>
                  ほとんどの利用は居酒屋などの店舗を想定している為、あなたが釣った魚が美味しい料理として振る舞われる事は間違いありません。
                </p>
              </div>
              <div class="clear"></div>
              <img class="service_bg pc" src="teaser/img/img_seller/service_bg.png" alt="">
            </div>
            <div class="service service_03">
              <div class="s_img_container">
                <img class="service_img" src="teaser/img/img_seller/service_img_03.jpg" alt="">
                <img class="service_bg sp" src="teaser/img/img_seller/service_bg.png" alt="">
              </div>
              <div class="service_contents">
                <p class="service_number">SERVICE03</p>
                <h3>安心できる評価機能と使いやすいサービス</h3>
                <p class="service_description">
                  「買取りされた魚がキャンセルされた」<br>
                  そんな不安を払拭する為に、本サービスでは独自の評価機能を用いています。<br>
                  店舗、釣り人の両方が評価される事により、不安なく取引を行う事が可能です。<br>
                  また、サービス自体は、Webサイト、iOSアプリ、Androidアプリの3種展開を行う為、お好きなデバイスで見やすいサービスの中で魚の購入をする事が出来ます。
                </p>
              </div>
              <div class="clear"></div>
              <img class="service_bg pc" src="teaser/img/img_seller/service_bg.png" alt="">
            </div>
          </div>
        </div>


        <!-- こんな使い方ができる -->
        <div id="how_to"  class="section">
          <div class="how_to_title">
            <h2 class="ttl_main txt_w">こんな使い方ができる<span class="ttl_en">How to</span></h2>
          </div>
          <div class="how_to_contents">
            <!-- PC用背景 -->
            <img class="pc" src="teaser/img/img_seller/howto_bg_pc.jpg" alt="">
            <!-- SP用背景1 -->
            <img class="sp" src="teaser/img/img_seller/howto_bg_sp_01.jpg" alt="">
            <div class="how_to_discription how_to_discription1">
              <div class="how_to_text_container">
                <p class="how_to_number">01</p>
                <h3>本格的な釣り人</h3>
                <p class="how_to_text">
                  「今まで釣った魚は独自のルートで売っていたけど、<br class="pc">これならいつもは売れない魚も売る事もできそうだね。」
                </p>
                <h3>使い方</h3>
                <p class="how_to_text">
                  様々な魚が欲しい方が登録し、リクエストを出している為、<br class="pc">普段は安値がついたり売れない魚でも、<br class="pc">求めれている店舗/個人に対して売る事が可能です。
                </p>
              </div>
            </div>
            <!-- SP用背景2 -->
            <img class="sp" src="teaser/img/img_seller/howto_bg_sp_02.jpg" alt="">
            <div class="how_to_discription how_to_discription2">
              <div class="how_to_text_container">
                <p class="how_to_number">02</p>
                <h3>趣味の釣り人</h3>
                <p class="how_to_text">
                  「持ち帰っても家内に怒られるんですよ（笑）」<br>
                  「これならリリースする以外にも役に立ちますし、釣った甲斐がありますね。」
                </p>
                <h3>使い方</h3>
                <p class="how_to_text">
                  沢山の魚が釣れても、新鮮な状態で保存する事が不可能な為、<br class="pc">サービスを使って魚を売る事で思わぬ副収入や<br class="pc">釣った事が無駄になる事はありません。
                </p>
              </div>
            </div>
            <!-- SP用背景3 -->
            <img class="sp" src="teaser/img/img_seller/howto_bg_sp_03.jpg" alt="">
          </div>
        </div>
@endsection
