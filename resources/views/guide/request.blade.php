@extends('layouts.app')

@section('title', 'リクエスト・オファーについて')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_rqestofa')
@section('css', 'rqestofa.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>リクエスト・オファーについて</h2>
            <p class="font_avenirnext">Request offer</p>
        </div>
    </div>

    <div class="rqestofa_info">
        <div class="layout">
            <div class="rqestofa">
                <div class="container">
                    <div class="item">&emsp; <b>1</b>&emsp; リクエスト方法について<br>&emsp; ※【リクエストとは】<br>&emsp;
                        釣り人に、売魚をリクエストをする事が出来ます。<br>&emsp; 釣り人が、リクエストの中から応えられるものはオファーとして返信が来ます。<br>&emsp;
                        リクエストとオファーは、必ず魚を購入出来るものではありませんのでご了承ください。
                    </div>
                    <br>
                    <br>
                    <p>1.マイページ画面中央に表示されているメーニュ―タブの中から、「リクエスト魚一覧」をクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/rqest1.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>2.「新規で魚をリクエスト」をクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/rqest2.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>3.リクエスト入力画面が表示されますので、ご入力項目に従い各項目にご入力後、最後に「登録する」をクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/rqest3.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>4.リクエストの入力確認画面が表示されますので、「登録」をクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/rqest4.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>5.リクエストが完了しました。「リクエスト魚一覧」をクリックすると、自分の登録したリクエスト魚の一覧が表示されます。ユーザーからの、オファーを待ちましょう。
                    </p><br><br>
                    <center><img src="{{ asset('img/goriyou/rqest5.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>6.オファーを確認をクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/rqest6.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>7.オファー一覧画面が表示されます。オファーがあった場合、こちらの画面でご確認していただく事が出来ます。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/rqest7.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <br><br><br><br>
                </div>
            </div>
        </div>
    </div>
@endsection
