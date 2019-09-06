@extends('layouts.app')


@section('title', '会員登録確認')
@section('page_id', 'page_registconfirm')
@section('css', 'regist.css')
@section('not_need_head_img', true)

@section('content')
<div class="layout">
    <div class="title-simple">
        <h2>新規会員登録</h2>
    </div>
    <div class="flow">
    <p><a href="step1.html"><span>会員情報入力</span></a></p>
    <p><a href="step2.html"><span>個人情報入力</span></a></p>
    <p class="current"><span>確認画面</span></p>
    <p><span>登録完了</span></p>
    </div>
</div>

<div class="regist">
    <div class="regist_layout">
        <div class="regist_form">
            <div class="regist_form_inner">
            <div class="regist_form_split">お名前</div>
            <p>{{ $data['name'] }}</p>
            <div class="regist_form_split">フリガナ</div>
            <p>{{ $data['furigana'] }}</p>
            <div class="regist_form_split">メールアドレス</div>
            <p>{{ $data['email'] }}</p>
            <div class="regist_form_split">パスワード</div>
            <p>※セキュリティ上表示されません</p>
            <div class="regist_form_split">郵便番号</div>
            <p>{{ $data['zipcode'] }}</p>
            <div class="regist_form_split">公開住所</div>
            <p>{{ $data['prefecture'] }}{{ $data['public_address'] }}</p>
            <div class="regist_form_split">非公開住所</div>
            <p>{{ $data['private_address'] }}</p>
            <div class="regist_form_split">携帯電話</div>
            <p>{{ $data['mobile_tel'] }}</p>
            <div class="regist_form_split">電話番号</div>
            <p>{{ $data['tel'] }}</p>

            <div class="regist_form_split">お店の名前</div>
            <p>{{ $data['shop_name'] }}</p>
            <div class="regist_form_split">お店の郵便番号</div>
            <p>{{ $data['shop_zipcode'] }}</p>
            <div class="regist_form_split">お店の都道府県</div>
            <p>{{ $data['shop_prefecture'] }}</p>
            <div class="regist_form_split">お店の住所１</div>
            <p>{{ $data['shop_address1'] }}</p>
            <div class="regist_form_split">お店の住所２</div>
            <p>{{ $data['shop_address2'] }}</p>
            </div>
            <form action="{{ url('/register/profile/'. $user['token']. '/complete' ) }}" method="POST" class="buttons">
                @csrf
                <a href="{{ url('/register/profile/'. $user['token'].'/step/1') }}" class="content_button gray">戻って修正</a>
                <button class="content_button" type="submit">登録する</button>
            </form>
        </div>
    </div>
</div>
@include('parts.template_auth_links')
@endsection