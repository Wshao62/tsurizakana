@extends('layouts.app')

@section('title', '購入方法について')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_kounyu')
@section('css', 'kounyu.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>購入方法について</h2>
            <p class="font_avenirnext">How to purchase</p>
        </div>
    </div>

    <div class="kounyu_info">
        <div class="layout">
            <div class="kounyu">
                <div class="container">
                    <div class="item">※ご購入前に店舗のご登録をお願いいたします。</div>
                    <br>
                    <p>1.店舗登録がまだ、お済で無い方はマイページTOPに表示されております下記「店舗登録」ボタンをクリックし、ご登録へとお進みください。<br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu20.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>2.営業許可証のアップロードをお願いいたします。<br>お店のご登録情報と同じである事をご確認ください。最後にっ書類をアップロードをクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu21.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>3.アップロード確認画面が表示されますので、運営からの確認結果を４営業日以内にご登録メールアドレスへご連絡させていただきます。ご登録完了後、ご購入が可能となります。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu22.jpg') }}" alt="" width="500"></center>
                    <br>
                    <div class="item">&emsp; <b>1</b>&emsp;購入したい釣魚を検索しましょう！</div>
                    <br><br>
                    <p>1.購入したい魚を検索しましょう。検索方法については、以下となります。<br>
                        検索方法❶：ご希望の「キーワード」「エリア」を検索ボックスにご入力後、「釣魚を探す」をクリックして検索する方法があります。<br>
                        検索方法❷：TOP画面右上に表示されている「売魚一覧」をクリックすると、現在出品中の売魚の一覧が表示されますので、一覧から検索する方法があります。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu1.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>2.検索すると釣魚一覧が表示されます。一覧の中から、購入したい釣魚の画像をクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu2.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>3.選択した売魚の詳細画面が表示されます。売魚詳細内容をご確認後、「購入希望をする」をクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu3.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>4.購入のお手続きへと進みます。購入希望確認のポップアップ画面が表示されますので、「OK」をクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu4.jpg') }}" alt="" width="500"></center>
                    <p>5.出品者からの購入者決定通知が届くのを待ちます。<br>「購入希望」のお手続きが完了すると、下記のメッセージが表示されます。<br>
                        ※キャンセルしたい場合は、「購入希望キャンセル」ボタンをクリックしてください。</p><br><br>
                    <div class="item">&emsp; <b>2</b>&emsp;購入決定通知が届いたら、出品者とお取引に関するやり取りをしましょう！</div>
                    <br><br>
                    <p>1.出品者が購入者を決定すると、ご登録いただいているメールアドレスに購入希望を出した売魚の、購入者決定通知が届きますので、詳細内容をご確認ください。<br></p><br><br>
                    <p>2.「売魚詳細へ」をクリックするか、または、マイページ＞売魚一覧＞購入した魚タブから、取引詳細画面へと進みます。<br></p><br><br>
                    <p>3.「売魚詳細へ」にて、出品者との個人ダイレクトメッセージ入力が可能となります。メッセージをご入力後、『メッセージを送る』をクリックします。自分のメッセージは右側に表示されます。<br>売魚詳細画面にて、個人ダイレクトメッセージ内で出品者とのお取引に関するやり取りは、お取引が完了するまで可能です。<br>※出品者からの、ダイレクトメッセージが届いた場合は、マイページの右上に表示されているベルのマーク（お知らせ）に赤く通知が届きます。※取引詳細画面を開いている状態では、通知されません。<br>
                    </p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu7.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <div class="item">&emsp; <b>3</b>&emsp;お取引に関するやり取り後、購入が決まったら決済のお手続きへと進みます。</div>
                    <br><br>
                    <p>1.売魚詳細画面が表示され、決済のお手続きへと進みます。この段階では、仮決済状態となり本決済はなされません。本決済は、魚の受け取り完了後に本決済となります。<br></p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu8.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>2.出品者とのお取引に関するやり取り完了後、購入が決まったら「購入画面へ進む」をクリックし、購入のお手続きへと進みます。<br></p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu9.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>3.購入確認画面が表示されます。<br></p><br><br>
                    <p>4.このまま「決済する」をクリックし、決済へのお手続きへと進みます。<br></p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu10.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>5.決済お続き画面が表示されますので、入力項目に従ってご入力をお願いいたします。<br></p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu11.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>6.決済のお手続きが完了しました。出品者からの配達を待ちましょう。<br></p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu12.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>7.決済お手続きの完了と同時に、ご登録メールアドレスに、釣魚商店運営局からのメールが届きますので、メールボックスをご確認下さい。<br></p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu13.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>
                        9.ご購入した釣魚の、お取引内容詳細画面が表示されます。出品者との配達に関するやり取りをダイレクトメッセージ内でする事が可能です。配送（クール宅急便）でお願いする場合等は、配達前にダイレクトメッセージで連絡をしましょう！<br>
                    </p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu15.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <div class="item">&emsp; <b>4</b>&emsp;品者から売魚の配達・発送（クール宅急便）がなされ、売魚が到着します。</div>
                    <br><br>
                    <p>1.売魚到着後、売魚の確認をします。<br>
                        ❶売魚の情報内容に相違はない場合は⇒受け取り時に、その場で「受取完了」ボタンをクリックします。<br> <br>
                        ❷売魚に不備がありキャンセルをしたい場合<br><br>
                        配達の場合は、万一、売魚に不備があった場合は、「受取り完了」ボタンは押さずに、その場で出品者と受取り拒否に関する交渉をお願いいたします。<br>出品者と合意完了後に、「このユーザーとの取引を中止する」ボタンをクリックして下さい。<br>配送の場合は、まず、DMにて出品者へその旨を連絡をし、返品に関するやり取りをして下さい。<br>お取引キャンセルとなった場合は、釣魚運営局にて、お取引キャンセルのお手続きをさせていただきますので、「受取完了」ボタンは押さずに、お問合せにてご連絡をお願いいたします。
                    </p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu16.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p> 2.受け取り処理を行います。ポップアップが表示されますので、「OK」をクリックします。<br>※「OK」を押すと、本決済がなされ返品や返金の処理等は出来ません。<br></p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu17.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <div class="item">&emsp; <b>5</b>&emsp;最後に出品者への評価をしましょう！</div>
                    <br><br>
                    <p> 1.お取引詳細画面が表示させます。</p><br><br>
                    <p>2.画面下部に表示されている取引評価にて、出品者への評価を選択します。評価は「良い」「普通」「悪い」の３段階となります。３段階の中から１つ選択して下さい。</p><br><br>
                    <p>3.出品者へのお礼をのメッセージを入力します。</p><br><br>
                    <p> 4.最後に※「コメントを書く」ボタンをクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu18.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p> 5.お取引完了のメッセージが表示されます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/kounyu19.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p> 以上でご購入に関するお取引が完了です。</p><br><br>
                    <br><br><br><br>
                </div>
            </div>
        </div>
    </div>
@endsection
