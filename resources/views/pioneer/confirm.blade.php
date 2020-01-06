 @extends('layouts.app')

@section('title', '飲食店会員開拓希望確認')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_pioneerconfirm')
@section('css', 'pioneer.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>飲食店会員開拓希望について</h2>
            <p class="font_avenirnext">New restaurant development</p>
        </div>
    </div>

    <div class="layout_pioneer">
        <div class="flow">
            <p><a href="javascript:history.back();"><span>開拓希望飲食店情報入力</span></a></p>
            <p class="current"><span>入力情報確認</span></p>
            <p><span>入力完了</span></p>
        </div>
    </div>

    <div class="pioneer">
        <div class="layout_pioneer">
            <form class="pioneer_form" id="form" action="{{ url('/pioneer/send-email') }}" method="post">
                @csrf
                <center><b><p>ご登録者様情報</p></b></center><br>
                <div class="pioneer_form_split">
                    <p class="pioneer_form_split_title">お名前</p>
                    <p class="pioneer_form_split_content">{{ $form['first_name'] }} {{ $form['last_name'] }}</p>
                    <input type="hidden" name="first_name" value="{{ $form['first_name'] }}">
                    <input type="hidden" name="last_name" value="{{ $form['last_name'] }}">
                </div>
                <div class="pioneer_form_split">
                    <p class="pioneer_form_split_title">メールアドレス</p>
                    <p class="pioneer_form_split_content">{{ $form['email'] }}</p>
                    <input type="hidden" name="email" value="{{ $form['email'] }}">
                </div>
                <br><br><center><b><p>新規開拓ご希望店舗情報</p></b></center><br>
                <div class="pioneer_form_split">
                    <p class="pioneer_form_split_title">新規開拓希望の店舗種類</p>
                    <p class="pioneer_form_split_content">{{ $form['shop_type'] }}</p>
                    <input type="hidden" name="shop_type" value="{{ $form['shop_type'] }}">
                </div>
                <div class="pioneer_form_split">
                    <p class="pioneer_form_split_title">店舗名</p>
                    <p class="pioneer_form_split_content">{{ $form['shop_name'] }}</p>
                    <input type="hidden" name="shop_name" value="{{ $form['shop_name'] }}">
                </div>
                <div class="pioneer_form_split">
                    <p class="pioneer_form_split_title">電話番号</p>
                    <p>{{ $form['tel'] }}</p>
                    <input type="hidden" name="tel" value="{{ $form['tel'] }}">
                </div>
                <div class="pioneer_form_box">
                    <p class="pioneer_form_box_inner"><span class="pioneer_form_split_title">郵便番号</span><span class="pioneer_form_split_content">{{ $form['zip_code'] }}</span></p>
                    <p class="pioneer_form_box_inner"><span class="pioneer_form_split_title">都道府県</span><span class="pioneer_form_split_content">{{ $form['prefecture'] }}</span></p>
                    <p class="pioneer_form_box_inner"><span class="pioneer_form_split_title">住所1</span><span class="pioneer_form_split_content">{{ $form['address_1'] }}</span></p>
                    <p class="pioneer_form_box_inner"><span class="pioneer_form_split_title">住所2</span><span class="pioneer_form_split_content">{{ $form['address_2'] }}</span></p>
                    <input type="hidden" name="zip_code" value="{{ $form['zip_code'] }}">
                    <input type="hidden" name="prefecture" value="{{ $form['prefecture'] }}">
                    <input type="hidden" name="address_1" value="{{ $form['address_1'] }}">
                    <input type="hidden" name="address_2" value="{{ $form['address_2'] }}">
                </div>

                <div class="pioneer_form_split">
                    <p class="pioneer_form_split_title">ご要望やご希望等</p>
                    <p class="pioneer_form_split_content"> {!! nl2br(htmlspecialchars($form['request'])) !!}</p>
                    <input type="hidden" name="request" value="{{ $form['request'] }}">
                </div>
                <div class="pioneer_button">
                    <a href="javascript:history.back();" class="content_button">修正する</a>
                    <button class="content_button" type="submit"><a onclick="$('#form').submit()">送信する</a></button>
                </div>
            </form>
        </div>
    </div>

    <!-- ↓SPのみアプリダウンロード（下層全ページ共通） -->
    <div class="sp sp_app">
        <div class="spa_cont">
            <p class="white">\&nbsp;&nbsp;アプリのダウンロードはこちらから！&nbsp;/</p>
            <a class="sp_apple" href="#"><img src="{{ asset('img/store_apple.png') }}"></a>
            <a class="sp_google" href="#"><img src="{{ asset('img/store_google.png') }}"></a>
        </div>
    </div>
@endsection
