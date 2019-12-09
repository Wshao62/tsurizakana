@extends('layouts.app')

@section('title', '会員登録について')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_kaiin')
@section('css', 'kaiin.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>会員登録について</h2>
            <p class="font_avenirnext">Member registrationu</p>
        </div>
    </div>

    <div class="kaiin_info">
        <div class="layout">
            <div class="kaiin">
                <div class="container">
                    <div class="item">&emsp; <b>1</b>&emsp; 新規会員登録をしましょう！</div>
                    <br><br>
                    <p>1.TOP画面右上の、会員登録をクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/top.png') }}" alt=""></center>
                    <br>
                    <p>2.ご登録されたいメールアドレスを入力します。</p><br><br>
                    <p>3.仮登録をクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/kaiin2.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>4.ご入力いただいたメールアドレスに仮登録完了のメールが届きます。メールアドレスの受信箱をご確認ください。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/kaiin3.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>5.「プロフィール登録へ」をクリックし、登録画面へと進みます。</p><br><br>
                    <div class="item">&emsp; <b>2</b>&emsp; プロフィールの「基本情報」入力</div>
                    <br><br>
                    <p>
                        1.釣魚商店運営局から届いた「仮登録完了のお知らせ」メールに添付されている「「プロフィール登録へ」ボタンをクリックしていただきますと、釣り魚商店本サイトの「新規会員登録」画面が表示されます。以下プロフィール詳細をご入力下さい。</p>
                    <br><br>

                    <p>❶お名前をご入力下さい。【公開】<br>
                        ❷フリガナをご入力下さい。【非公開】<br>
                        ❸メールアドレスは自動で入力されておりますので不要です。【非公開】<br>
                        ❹半英数字6文字以上でパスワードをご入力下さい。【非公開】<br>
                        ❺上記と同じ内容のパスワードをご入力下さい。【非公開】<br>
                        ❻入力内容をご確認の上、「次へ進む」をクリックします。</p><br><br><br>
                    <center><img src="{{ asset('img/goriyou/kaiin4.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>❼お届け先住所をご入力ください。<br>
                        ※公開住所「都道府県市町村」<br>非公開住所「番地・建物名・部屋番号」を入力します。<br>
                        ❽電話番号を半角英数字で入力します。【非公開】<br>
                        ❾お店でご登録される方は、お店名をご入力ください
                        。【非公開】<br>❿同じくご登録されるお店の住所をご入力ください。【非公開】<br>最後に次へ進むをクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/kaiin5.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>2.入力内容確認画面が表示されます。</p><br><br>
                    <p>3.「登録する」をクリックします。</p><br><br>
                    <p>4.「登録完了」画面が表示されます。<br>※直ぐに売買のお取引やリクエスト魚のご登録をされる場合は、「本人確認する」をクリックします。
                        後でご登録される場合は、「あとで」をクリックすると、マイページへと進みます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/kaiin6.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <div class="item">&emsp; <b>3</b>&emsp; 本人確認登録をする</div>
                    <br><br>
                    <p>1.新規会員登録画面にて「本人確認をする」をクリックすると、本人確認画面が表示されます。</p><br><br>
                    <p>2.入力項目に従い、ご入力後画像のアップロードをクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/kaiin7.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>3.運営局の審査結果が、２営業日以内にご登録のメールアドレスに届きますのでご確認下さいませ。</p><br><br>
                    <p>【PCメールアドレスご使用の方】
                        <br><br>ご使用されているメールサービス、メールソフト、ウィルス対策ソフト等の設定により「迷惑メール」と認識されて、釣魚商店からのメールが届かない場合があります。<br>
                        特にYahoo!メールやHotmailなどのフリーメールをお使いの場合は「迷惑メールフォルダー」等をご確認いただくかお使いのサービス、ソフトウェアの設定をご確認ください。<br>
                        以下ドメインを受信できるように設定をお願い致します。<br>
                        @tsurizakana-shoten.com<br><br>
                        【携帯・スマートフォンアドレスをご使用の方】<br><br>
                        docomo、au、softbankなど各キャリアのセキュリティ設定をされているため、ユーザー受信拒否と認識されているか、お客様が迷惑メール対策等で、ドメイン指定受信を設定されている場合に、メー
                        ルが正しく届かないことがございます。<br>
                        以下ドメインを受信できるように設定をお願い致します。<br>
                        @tsurizakana-shoten.com</p><br><br><br><br>
                </div>
            </div>
        </div>
    </div>
@endsection
