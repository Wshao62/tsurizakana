@extends('layouts.app')

@section('title', '出品方法について')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_shupin')
@section('css', 'shupin.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>出品方法について</h2>
            <p class="font_avenirnext">About the exhibition method</p>
        </div>
    </div>

    <div class="shupin_info">
        <div class="layout">
            <div class="shupin">
                <div class="container">
                    <div class="item">&emsp; <b>1</b>&emsp; 釣魚を出品しましょう！</div>
                    <br>
                    <p>1.マイページを表示させます。</p><br>
                    <p><br>2.画面右下に表示されている「出品する」をクリックするか、画面中央に表示されているメニュ―の中から、「売魚アップロード」を、クリックして 出品詳細入力画面へと進みます</p><br>
                    <center><img src="{{ asset('img/goriyou/shupin1.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p><br>3.「本人確認」及び「口座情報」のご登録がお済で無い方の場合は、以下の表示画面となりますので、
                        各お手続きをお願いいたします。</p><br><br>
                    <div class="item">&emsp; <b>2</b>&emsp; 本人確認を提出しましょう！</div>
                    <br><br>
                    <p>1．「本人確認」がお済でない場合は「本人確認」ボタンをクリックしてお手続きへとお進みください。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/shupin2.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>2．本人確認書類の入力項目に従い、ご入力後をお願いいたします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/shupin3.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>3．全ての項目に、ご入力が完了したら、最後に画像のアップロードをクリックします。<br>
                        ※書類をアップロードする前に、以下の内容をご確認ください。<br>
                        ・アップロード合計サイズが10MBを超えないようにしてください。<br>
                        ・書類に記載されている氏名、住所が釣魚商店アカウントに登録いただいているものと
                        一致していること。<br>
                        ・書類は表面だけでなく、住所変更の記載がない場合でも裏面もアップロードしてください。<br>
                        ・JPG、GIF、PNGなどの画像 ファイルであること。<br>
                        ・最新の内容であり、書類の情報がはっきりと読み取れる状態であること。</p><br><br>
                    <p>2．本人確認書類の入力項目に従い、ご入力後をお願いいたします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/shupin4.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <div class="item">&emsp; <b>3</b>&emsp; 銀行口座登録をしましょう！</div>
                    <br><br>
                    <p>1.「銀行情報」のご登録がお済で無い方の場合は、以下の表示画面となりますので、「プロフィール編集へ」ボタンをクリックしてお手続きへとお進みください。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/shupin5.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>2.「「プロフィール編集へ」をクリックすると、プロフィール編集画面が表示されます。銀行口座情報入力画面にて、口座情報をご入力後、最後に、「変更する」をクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/shupin6.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>3.確認画面が表示されますので、再度「変更する」をクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/shupin7.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>4.「プロフィール編集が完了しました！」と表示され変更が確定されました。以上で銀行口座情報のご登録が完了です。 　</p><br><br>
                    <center><img src="{{ asset('img/goriyou/shupin8.jpg') }}" alt="" width="500" height="200"></center>
                    <br><br>
                    <div class="item">&emsp; <b>4</b>&emsp; 釣魚を出品しましょう！</div>
                    <br><br>
                    <p>1.メニューから、「マイページ」をクリックして、マイページTOP画面を表示させます。</p><br><br>
                    <p>2.マイページTOP画面の右下に表示されている「出品する」をクリックするか、マイページメニューの中から「釣魚アップロード」をクリックします。　</p><br><br>
                    <center><img src="{{ asset('img/goriyou/shupin9.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <center><img src="{{ asset('img/goriyou/shupin10.jpg') }}" alt="" width="100"></center>
                    <br><br>
                    <center><img src="{{ asset('img/goriyou/shupin11.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>3.詳細入力画面に、出品したい釣魚の詳細情報を入力し、最後に『確認する』をクリックします。　</p><br><br>
                    <center><img src="{{ asset('img/goriyou/shupin12.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>4.釣魚の出品完了画面が表示されます。購入者からの購入を待ちましょう。　</p><br><br>
                    <center><img src="{{ asset('img/goriyou/shupin13.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <br><br><br><br>
                </div>
            </div>
        </div>
    </div>
@endsection
