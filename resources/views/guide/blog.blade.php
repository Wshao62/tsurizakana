@extends('layouts.app')

@section('title', 'ブログについて')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_blog')
@section('css', 'blog_guide.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>ブログについて</h2>
            <p class="font_avenirnext">About the blog</p>
        </div>
    </div>

    <div class="blog_info">
        <div class="layout">
            <div class="blog">
                <div class="container">
                    <div class="item">&emsp; <b>1</b>&emsp; ブログ記事を投稿しましょう！</div>
                    <br>
                    <p>1.マイページ画面中央に表示されているメーニュ―タブの中から、「ブログ管理」をクリックします。</p><br><br>
                    　　　
                    <center><img src="{{ asset('img/goriyou/blog1.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>2.「記事を投稿する」をクリックします。</p><br><br>
                    <center><img src="{{ asset('img/goriyou/blog2.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>3.リクエスト入力画面が表示されますので、入力内容に従って各項目のご入力下さい。<br><br>
                        ❶ブログタイトルをご入力ください。<br><br>
                        ❷画像をドロップでアップします。画像サイズは５MBまでとなっておりますのでご注意ください。<br><br>
                        ❸画像ファイルを選択し、アップします。<br>※❷、❸いづれかの方法でアップしてください。<br><br>
                        ❹記事詳細内容をご入力ください。<br><br>
                        ❺ステータスにて、「公開」を選択した場合は、ブログは全ユーザーに公開される状態での投稿となります。<br>「非公開」の場合は、ブログは、全ユーザーには公開されずマイページに保存されます。<br><br>
                        ❻全ての項目にご入力後、「登録する」をクリックします。<br></p><br><br>
                    <center><img src="{{ asset('img/goriyou/blog3.jpg') }}" alt="" width="500"></center>
                    <br>
                    <p>以上でブログ記事が投稿完了です。</p><br>
                    <div class="item">&emsp; <b>2</b>&emsp;ブログ記事を編集しましょう！</div>
                    <br>
                    <p>1.マイページ画面中央に表示されているメーニュ―タブの中から、編集したい「ブログ管理」画面にある記事タイトルをクリックします。</p><br>
                    　　　
                    <center><img src="{{ asset('img/goriyou/blog4.jpg') }}" alt="" width="500"></center>
                    <br><br>
                    <p>
                        2.記事タイトルをクリックすると、記事編集画面が表示されますので、❶～❹の編集したい箇所を編集後、最後に❻「登録する」をクリックしてください。記事を削除したい場合は❼の「削除する」をクリックしてください。</p>
                    <br><br>
                    <center><img src="{{ asset('img/goriyou/blog4.2.jpg') }}" alt="" width="500"></center>
                    <br>
                    <br>
                    <p>以上でブログ記事が編集が完了です。</p><br>
                </div>
            </div>
        </div>
    </div>
@endsection
