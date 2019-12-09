@extends('layouts.app')

@section('title', '出品後のお取引契約の流れ')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_keiyaku')
@section('css', 'keiyaku.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>出品後のお取引契約の流れ</h2>
            <p class="font_avenirnext">Transaction flow</p>
        </div>
    </div>

    <div class="keiyaku_info">
        <div class="layout">
            <div class="keiyaku">
                <div class="container">
                    <div class="item">&emsp; <b>1</b>&emsp; 購入希望者一覧から購入者を決定しましょう！</div>
                    <br>
                    <p>1.現在、ご登録いただいているメールアドレスをご確認いただくか、マイページ＞売り魚一覧＞出品した魚とお進みいただきますと下記画面が表示されます。</p><br>
                    <center><img src="{{ asset('img/goriyou/keiyaku11.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>2.＜メールアドレスからのご確認方法><br><br>現在出品されている売魚に、購入希望があった際に以下内容のメールが釣り魚運営局から届きます。</p><br>
                    <p>3.購入希望者一覧のボタンをクリックします。</p><br>
                    <center><img src="{{ asset('img/goriyou/keiyaku1.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>4.＜マイページからのご確認方法><br><br>マイページ＞売り魚一覧＞出品した魚をクリックすると、下記画面が表示されますので、「購入希望者一覧」をクリックすると、購入希望者一覧画面が表示されます。
                    </p><br>
                    <center><img src="{{ asset('img/goriyou/keiyaku2.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>5．購入希望者一覧画面が表示されます。一覧の中から、購入者を決定して「この人に販売」をクリックします。</p><br>
                    <center><img src="{{ asset('img/goriyou/keiyaku3.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>6．購入者決定確認のポップアップメッセージが表示されるので、「OK」をクリックします。</p><br>
                    <center><img src="{{ asset('img/goriyou/keiyaku4.jpg') }}" alt="" width="500" 　></center>
                    <br><br>
                    <p>7．以上で購入者決定の処理が完了し、以下の画面が表示されます。購入者の決済手続き完了を待ちましょう!</p><br>
                    <center><img src="{{ asset('img/goriyou/keiyaku5.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <div class="item">&emsp; <b>2</b>&emsp; 購入者の決済お手続き完了後、売魚を配達・発送をしましょう！</div>
                    <br>
                    <p>1．購入希望者が決済手続きを完了すると、ご登録メールアドレスに以下内容のメールが釣魚商店運営局から届きます。ご登録いただいておりますメールボックスをご確認ください。 <br>または、マイページ＞売り魚一覧＞出品した魚＞取引中の魚タブを選択し、一覧の中から現在お取引中の「取引詳細」ボタンをクリックいただきますと、取引詳細画面が表示されます。
                    </p><br>
                    <p>2.「取引詳細へ」をクリックします。</p><br>
                    <center><img src="{{ asset('img/goriyou/keiyaku6.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>3．売魚の取引詳細画面が表示されます。</p><br>
                    <center><img src="{{ asset('img/goriyou/keiyaku7.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>4．取引詳細画面にてダイレクトメッセージが開通します。ダイレクトメッセージで購入者と配達や発送についての詳細をやり取りします。<br>例）「配送方法」「配達到着時間」「配達場所」「その他」等
                    </p><br>
                    <center><img src="{{ asset('img/goriyou/keiyaku8.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>5．売魚を配達・発送しましょう。<br>※配達の際に、購入者へ魚を確認して貰い合意のもと「受け取り確認」ボタンを、その場で押してもらいましょう！【重要です】
                        購入者に、「受け取り確認」ボタンが押されると、自身の取引詳細画面「商品名」横に表示されている「配達待ち」が、「評価待ち」に変わりますので、必ずその場でご確認ください。</p><br>
                    <center><img src="{{ asset('img/goriyou/keiyaku9.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>6．最後に、購入者への評価をしましょう！<br>評価画面にて良い・普通・悪いの三段階評価をお願いいたします。コメントも入力していただけますので、御礼メッセージ等も添えて、最後にコメントを書くをクリックしてください。
                    </p><br>
                    <center><img src="{{ asset('img/goriyou/keiyaku10.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p><br>以上で、出品に関するお取引は完了となります。</p></div>
            </div>
        </div>
    </div>
@endsection
