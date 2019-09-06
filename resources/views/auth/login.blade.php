@extends('layouts.app')

@section('title', 'ログイン')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」ログインページです。メールアドレスとパスワードを入力下さい。新規会員登録、Facebookでログインも可能です。')
@section('page_id', 'page_login')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
<div class="layout">
    <div class="mp_cont">
    <h3 class="content_title">ログイン</h3>
    <div class="login_box">
        <p>アカウントをお持ちでない方はこちら</p>
        <a class="content_button" href="{{ url('register') }}">新規会員登録</a>
        <hr>
        <a class="sns_button fb" href="{{ url('/login/facebook') }}"><span><img src="{{ url('/') }}/img/common/fb.png"></span>Facebookでログイン</a>
        <form class="login_form" action="{{ route('login') }}" method="post">
        @csrf
        @if ($errors->has('email'))
            <span class="alert">
                {{ $errors->first('email') }}
            </span>
        @endif
        @if ($errors->has('password'))
            <span class="alert">
                {{ $errors->first('password') }}
            </span>
        @endif
        <input id="email" type="email" name="email" value="{{ old('email') }}"placeholder="メールアドレス" required autofocus>
        <input id="password" type="password" name="password" placeholder="パスワード" required>
        @if ($is_app) <input type="hidden" name="remember" value="1"> @endif
        <button class="content_button btn_g">ログイン</button>
        </form>
        <a href="{{ route('password.request') }}">パスワードをお忘れの方</a>
    </div>
    </div>
</div>
@include('parts.template_auth_links')
@endsection
