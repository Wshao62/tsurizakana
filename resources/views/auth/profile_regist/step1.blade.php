@extends('layouts.app')


@section('title', '会員情報入力 ステップ１')
@section('page_id', 'page_step1')
@section('css', 'regist.css')
@section('not_need_head_img', true)

@section('content')
<div class="layout">
    <div class="title-simple">
        <h2>新規会員登録</h2>
    </div>
    <div class="flow">
        <p class="current"><span>会員情報入力</span></p>
        <p><span>個人情報入力</span></p>
        <p><span>確認画面</span></p>
        <p><span>登録完了</span></p>
    </div>
</div>

<div class="regist">
    @if (session('error'))
        <p class="alert">{{ session('error') }}</p>
    @endif
    <div class="regist_layout">
    <form class="regist_form" method="POST" action="{{ url('/register/profile/'. $user['token']. '/step/2' ) }}">
        @csrf
        <div class="regist_form_inner">
        <div class="regist_form_split">お名前</div>
        <input type="text" name="name" value="{{ old('name', $old_data['name']) }}" class="input_length_full" placeholder="(例）佐藤 太郎">
        @if ($errors->has('name'))
            <p class="alert">{{ $errors->first('name') }}</p>
        @endif
        <div class="regist_form_split">フリガナ</div>
        <input type="text" name="furigana" value="{{ old('furigana', $old_data['furigana']) }}" class="input_length_full" type="tel" placeholder="(例）サトウ タロウ">
        @if ($errors->has('furigana'))
            <p class="alert">{{ $errors->first('furigana') }}</p>
        @endif
        <div class="regist_form_split">メールアドレス</div>
        <p class="regist_form_entered">{{ $user['email'] }}</p>
        <div class="regist_form_split">パスワード</div>
        <input type="password" name="password" value="" class="input_length_full" placeholder="半角英数字6文字以上">
        @if ($errors->has('password'))
            <p class="alert">{{ $errors->first('password') }}</p>
        @endif
        <div class="regist_form_split">パスワード(確認)</div>
        <input type="password" name="password_confirmation" class="input_length_full" placeholder="半角英数字6文字以上">

        <p class="regist_form_small">「次へ進む」ボタンをクリックすると、釣魚商店の<a href="{{ route('privacy') }}" class="regist_form_point">個人情報保護方針</a>と<a href="/term/kiyaku.html" class="regist_form_point">利用規約</a>に同意したことになります。</p>
        </div>
        <button class="content_button_arrow" type="submit">次へ進む</button>
    </form>
    </div>
</div>
@include('parts.template_auth_links')
@endsection