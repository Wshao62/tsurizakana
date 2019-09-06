@extends('layouts.teaser')

@section('title', '釣り魚商店ティザーサイト（買い主様向け）')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のティザーサイトです。釣魚商店では、近隣の釣人が釣った魚を直接購入する事が出来る魚のマッチングサービスです。居酒屋のメニューで困っていたり、夕飯の一品でお困りの方は、無料で利用出来る釣り魚商店をぜひご利用下さい。')
@section('class', 'buyer')

@section('content')
        <!-- PC用TOPへ戻る、SNSアイコン -->
        <div class="icons">
          <img class="btn_pagetop_sp" src="teaser/img/img_buyer/btn_pagetop_sp.png" alt="TOPへ戻る">
          <img class="hover btn_pagetop" src="teaser/img/img_buyer/btn_pagetop_pc.png" alt="TOPへ戻る">
          {{-- <a class="hover" href="#"><img src="teaser/img/img_buyer/btn_tw.png" alt="Twitter"></a>
          <a class="hover" href="#"><img src="teaser/img/img_buyer/btn_fb.png" alt="Facebook"></a> --}}
        </div>
        <!-- SP用追従事前登録ボタン -->
        <div class="sp registration_btn">
          <a class="menu_link" href="#registration">事前登録はこちら</a>
        </div>


        <!-- メイン　コピー -->
        <div class="copy">
          <!-- PC用動画 -->
          <video class="pc" playsinline autoplay muted loop>
            <source src="teaser/video/main_video_buyer.mp4" type="video/mp4">
            <source src="teaser/video/main_video_buyer.webm" type="video/webm">
          </video>
          <!-- SP用画像 -->
          <img class="sp copy_bg_img" src="teaser/img/img_buyer/mainimg_sp.jpg" alt="">
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
              釣魚商店は、釣り人と魚を買いたい人を繋げるマッチングサービスです。<br>
              釣り人が釣った魚をサービスに掲載する事で、<br class="pc">購入者はその魚達を釣り人から直接買取る事が出来ます。<br>
              釣られた魚を中間コストなく、最後まで釣り人が責任を持って届ける事で<br class="pc">格安かつ新鮮な魚を直接ご提供出来るサービスをお届け致します。
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
          <h2 class="ttl_main">メリット<span class="ttl_en">Merits</span></h2>
          <div class="container">
            <!-- メリット01～06 -->
            <div class="marit merit_odd">
              <p class="merit_number">01</p>
              <h3>安心の直接売買</h3>
              <img src="teaser/img/img_buyer/merit_icon_01.png" alt="安心の直接売買">
              <p class="merit_description">
                安全な評価制度のもと、<br>信頼の出来る釣り人から<br class="pc">買取が可能です。
              </p>
            </div>
            <div class="marit merit_even">
              <p class="merit_number">02</p>
              <h3>新鮮な魚をお届け</h3>
              <img src="teaser/img/img_buyer/merit_icon_02.png" alt="新鮮な魚をお届け">
              <p class="merit_description">
                水揚げされて数時間の新鮮な魚を<br>手に入れる事ができます。
              </p>
            </div>
            <div class="marit merit_odd">
              <p class="merit_number">03</p>
              <h3>たくさんの種類から選べる</h3>
              <img src="teaser/img/img_buyer/merit_icon_03.png" alt="たくさんの種類から選べる">
              <p class="merit_description">
                サービスには、リクエスト機能がある為、<br>店舗/個人が欲しい魚が<br class="pc">ひと目で分かります。
              </p>
            </div>
            <div class="marit merit_even">
              <p class="merit_number">04</p>
              <h3>すぐに取引が行われる</h3>
              <img src="teaser/img/img_buyer/merit_icon_04.png" alt="すぐに取引が行われる">
              <p class="merit_description">
                市場やスーパーに行かずとも魚が<br class="pc">手に入る他、<br>釣り人が魚を持ってきてくれます。
              </p>
            </div>
            <div class="marit merit_odd">
              <p class="merit_number">05</p>
              <h3>どんなデバイスでもOK</h3>
              <img src="teaser/img/img_buyer/merit_icon_05.png" alt="どんなデバイスでもOK">
              <p class="merit_description">
                Webサイト、iOSアプリ、<br>Androidアプリでご利用が可能です。
              </p>
            </div>
            <div class="marit merit_even">
              <p class="merit_number">06</p>
              <h3>使いやすいサイト</h3>
              <img src="teaser/img/img_buyer/merit_icon_06.png" alt="使いやすいサイト">
              <p class="merit_description">
                サイトは人間中心設計に基づく<br>使いやすい設計の為、<br>誰でもご利用出来ます。
              </p>
            </div>
            <div class="clear"></div>
          </div>
          <img class="marit_left_img pc" src="teaser/img/img_buyer/merit_bg_l_pc.png" alt="">
          <img class="marit_right_img pc" src="teaser/img/img_buyer/merit_bg_r_pc.png" alt="">
        </div>
        <div class="clear"></div>


        <!-- サービス -->
        <div id="services" class="section">
          <div class="services_title">
            <!-- PC用タイトル背景 -->
            <img class="pc" src="teaser/img/img_buyer/service_title_pc.png" alt="">
            <!-- SP用タイトル背景 -->
            <img class="sp" src="teaser/img/img_buyer/service_title_sp.png" alt="">
            <div class="services_title_text">
              <h2 class="ttl_main txt_w">サービス<span class="ttl_en">Service</p></span>
            </div>
          </div>
          <div class="container">
            <div class="service service_01">
              <div class="s_img_container">
                <img class="service_img" src="teaser/img/img_buyer/service_img_01.jpg" alt="">
                <img class="service_bg sp" src="teaser/img/img_buyer/service_bg.png" alt="">
              </div>
              <div class="service_contents">
                <p class="service_number">SERVICE01</p>
                <h3>新鮮な魚を中間コストなく直接あなたの元へ</h3>
                <p class="service_description">
                  釣魚商店では、新鮮な魚を近隣で釣りをされている釣り人から直接魚を買取る事が可能です。<br>
                  今まで新鮮な魚を手に入れるには、市場に買いにいくのか独自ルートを利用して購入をする方法しかありませんでしたが、釣魚商店を利用する事によって、<br class="pc">「早く」「直接」「新鮮」な魚を中間手数料なしで手に入れる事が可能です。
                </p>
              </div>
              <div class="clear"></div>
              <img class="service_bg pc" src="teaser/img/img_buyer/service_bg.png" alt="">
            </div>
            <div class="service service_02">
              <div class="s_img_container">
                <img class="service_img" src="teaser/img/img_buyer/service_img_02.jpg" alt="">
                <img class="service_bg sp" src="teaser/img/img_buyer/service_bg.png" alt="">
              </div>
              <div class="service_contents">
                <p class="service_number">SERVICE02</p>
                <h3>欲しい魚を釣り人にリクエスト</h3>
                <p class="service_description">
                  釣り人に対して店舗の方は欲しい魚をリクエストする事が可能です。<br>
                  近くで釣り人がリクエストの魚を釣った際は、通知が届き、誰よりも先にお目当ての魚を買取る事が出来ます。<br>
                  また、近隣で釣り人が釣った魚はすべて買取る事ができる為、お目当ての魚以外でも、金額や写真から感じれる新鮮さなどから、今日のメニューを決める事が出来ます。
                </p>
              </div>
              <div class="clear"></div>
              <img class="service_bg pc" src="teaser/img/img_buyer/service_bg.png" alt="">
            </div>
            <div class="service service_03">
              <div class="s_img_container">
                <img class="service_img" src="teaser/img/img_buyer/service_img_03.jpg" alt="">
                <img class="service_bg sp" src="teaser/img/img_buyer/service_bg.png" alt="">
              </div>
              <div class="service_contents">
                <p class="service_number">SERVICE03</p>
                <h3>安心できる評価機能と使いやすいサービス</h3>
                <p class="service_description">
                  「依頼した魚が届かない」<br>
                  そんな不安を払拭する為に、本サービスでは独自の評価機能を用いています。<br>
                  店舗、釣り人の両方が評価される事により、不安なく取引を行う事が可能です。<br>
                  また、サービス自体は、Webサイト、iOSアプリ、Androidアプリの3種展開を行う為、お好きなデバイスで見やすいサービスの中で魚を買取る事が出来ます。
                </p>
              </div>
              <div class="clear"></div>
              <img class="service_bg pc" src="teaser/img/img_buyer/service_bg.png" alt="">
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
            <img class="pc" src="teaser/img/img_buyer/howto_bg_pc.jpg" alt="">
            <!-- SP用背景1 -->
            <img class="sp" src="teaser/img/img_buyer/howto_bg_sp_01.jpg" alt="">
            <div class="how_to_discription how_to_discription1">
              <div class="how_to_text_container">
                <p class="how_to_number">01</p>
                <h3>居酒屋主人</h3>
                <p class="how_to_text">
                  「今までの魚の仕入れは近くの市場に通ってました。」<br>
                  「ネット社会にあったサイトで、仕入れの仕方が色々変わる時期ですよね」
                </p>
                <h3>使い方</h3>
                <p class="how_to_text">
                  居酒屋やレストランなどの仕入れに利用する事が出来ます。<br>
                  市場に行く必要がなく直接届けてくれる為、市場に取られるような中間マージンもなく、信頼が出来る釣り人から魚を直接仕入れる事が出来ます。
                </p>
              </div>
            </div>
            <!-- SP用背景2 -->
            <img class="sp" src="teaser/img/img_buyer/howto_bg_sp_02.jpg" alt="">
            <div class="how_to_discription how_to_discription2">
              <div class="how_to_text_container">
                <p class="how_to_number">02</p>
                <h3>主婦</h3>
                <p class="how_to_text">
                  「新鮮な真鯛って中々買えないんですよね。」<br>
                  「スーパーで買うのもいいんですけど、<br class="pc">本当に新鮮で美味しいものっていいじゃないですか。」
                </p>
                <h3>使い方</h3>
                <p class="how_to_text">
                  居酒屋やレストランなどの仕入れに利用する事が出来ます。<br>
                  市場に行く必要がなく直接届けてくれる為、市場に取られるような中間マージンもなく、信頼が出来る釣り人から魚を直接仕入れる事が出来ます。
                </p>
              </div>
            </div>
            <!-- SP用背景3 -->
            <img class="sp" src="teaser/img/img_buyer/howto_bg_sp_03.png" alt="">
          </div>
        </div>
@endsection
