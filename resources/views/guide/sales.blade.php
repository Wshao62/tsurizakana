@extends('layouts.app')

@section('title', '売上管理・振込申請について')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_uriagekanri')
@section('css', 'uriagekanri.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>売上管理/振込申請</h2>
            <p class="font_avenirnext">Sales management Transfer application</p>
        </div>
    </div>

    <div class="uriagekanri_info">
        <div class="layout">
            <div class="uriagekanri">
                <div class="container">
                    <div class="item">&emsp; <b>1</b>&emsp; 売上金の確認方法について</div>
                    <br>
                    <p>1.TOP画面からマイページを表示させたい場合は、TOP画面の右上に表示されている下記アイコンの隣の▼をクリックし、ドロップダウンから「マイページ」を選択します。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/mypase1.jpg') }}" alt="" width="500"></center>
                    <br> <br>
                    <p>2.マイページが表示されたら、「売上管理・振込申請」タブをクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/uriage1.1.png') }}" alt="" width="500"></center>
                    <p>3.「売上金」タブをクリックすると、現在の売上金残高と、累計売上金が表示されます。<br>❶現在の売上金残高＝累計売上金-振込申請額を計上し表示されます。<br>❷累計売上金＝過去の総売上金が表示されます。
                    </p><br><br>
                    <center><img src="{{ asset('img/goriyou/uriage1.png') }}" alt="" width="500"></center>
                    <br><br>
                    <div class="item">&emsp; <b>2</b>&emsp; 振込申請方法について</div>
                    <br><br>
                    <p>1.マイページ＞売上管理・振込申請画面を表示させ、振込申請タブをクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/uriage2.1.png') }}" alt="" width="500"></center>
                    <br><br>
                    <p>2.振込申請したい金額をご入力ください。<br>
                        ※申請金額は振込申請可能額の範囲内で入力してください。また、申請金額は1,000円以上から可能です。</p>
                    <br><br>
                    <center><img src="{{ asset('img/goriyou/uriage2.png') }}" alt="" width="500"></center>
                    <br><br>
                    <p>3.金額を入力すると、振込手数料300円を差し引いた金額が実際の振込額に自動的に反映されます。<br> 次へをクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/uriage2.2.png') }}" alt="" width="500"></center>
                    <br><br>
                    <p>4.銀行口座情報をご確認ください。<br> マイページにご登録いただいている銀行口座情報が自動的に反映され表示されます。<br> 変更が無い場合は、「申請する」をクリックしてください。</p>
                    <br><br>
                    <center><img src="{{ asset('img/goriyou/uriage2.3.png') }}" alt="" width="500"></center>
                    <br><br>
                    <p>5.振込申請内容の確認画面が表示されますので、ご入力内容をご確認後、「申請する」をクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/uriage2.4.png') }}" alt="" width="500"></center>
                    <br><br>
                    <p>6.振込申請完了の画面が表示され、以上で振込申請のお手続きは完了となります。<br> ご入金は、振込申請日から４営業日となっております。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/uriage2.5.png') }}" alt="" width="500"></center>
                    <br><br>
                    <br><br>
                    <p>7.振込申請完了通知がご登録メールアドレスに届きます。<br> 振込申請金額のご確認は、マイページの「申請履歴」または、こちらのメールからご確認いただけます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/uriage6.png') }}" alt="" width="500"></center>
                    <br><br>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
@endsection
