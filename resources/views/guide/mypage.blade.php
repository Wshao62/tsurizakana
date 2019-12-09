@extends('layouts.app')

@section('title', 'マイページについて')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_mypase')
@section('css', 'mypase.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>マイページについて</h2>
            <p class="font_avenirnext">About My Page</p>
        </div>
    </div>

    <div class="mypase_info">
        <div class="layout">
            <div class="mypase">
                <div class="container">
                    <div class="item">&emsp; <b>1</b>&emsp; マイページを表示させましょう！</div>
                    <br><br>
                    <p>1.TOP画面からマイページを表示させたい場合は、TOP画面の右上に表示されている下記アイコンの隣の▼をクリックし、ドロップダウンから「マイページ」を選択します。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/mypase1.jpg') }}" alt="" width="500"></center>
                    <br>
                    <div class="item">2⃣マイページ各種機能について</div>
                    <br><br>
                    <center><img src="{{ asset('img/goriyou/mypase2.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>❶売魚一覧をクリックすると、現在公開中の全ての売魚一覧が表示されます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/mypase3.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>❷リクエスト魚一覧をクリックすると、現在リクエストがされている魚一覧を表示します。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/mypase4.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>❸お問合せ」をクリックすると、釣魚商店お問合せ入力画面へと進みます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/mypase03.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>❹よくある質問をクリックすると、釣魚商店へのよくある質問が表示されます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/mypase04.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>❺お知らせメッセージやお取引等に関する通知があった場合、赤くマークが表示されます。クリックすると内容をご確認いただけます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/mypase5.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>❻マイページメニューをクリックすると、プルダウンのメニューが表示されます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/mypase6.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>❼プロフィールを編集をクリックすると、マイページのプロフィール編集画面へと進みます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/mypase7.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>❽売魚をアップロードをクリックすると、売魚の出品詳細入力画面へと進みます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/mypase8.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>❾売魚一覧をクリックすると、現在「出品した魚」「購入した魚」「取引中の魚」の詳細を表示させる事が出来ます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/mypase9.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>❿リクエスト魚一覧をクリックすると、現在自身がリクエストを出している魚の一覧が表示されます。リクエストしたい場合も、こちらの画面からリクエストする事が出来ます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/mypase10.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>⓫領収書をクリックすると、お取引が完了している購入分の領収書を発行する事が出来ます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/mypase11.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>⓬売上管理をクリックすると、お取引が完了している売上の一覧を表示する事が出来ます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/mypase13.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>⓭ブログ管理をクリックすると、自身のブログ管理画面が表示されます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/mypase12.jpg') }}" alt="" width="500"></center>
                    <br><br><br><br>
                </div>
            </div>
        </div>
    </div>
@endsection
