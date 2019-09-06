@extends('layouts.app')

@section('title', 'パスワードの再設定')
@section('page_id', 'page_password2')
@section('css', 'regist.css')

@section('content')
<div class="layout">
    <div class="title-simple">
    <h2>パスワードを<br class="hide_pc">再設定</h2>
    </div>
</div>

<div class="regist">
    <div class="layout">
        <form class="regist_form" method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="regist_form_inner">
                <p class="regist_form_line">変更するパスワードを入力してください。</p>
                <p>対象のメールアドレス</p>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" class="input_length_full" placeholder="メールアドレス" required autofocus>
                @if ($errors->has('email'))
                    <p class="alert">
                        {{ $errors->first('email') }}
                    </p>
                @endif
                <p>新しいパスワードを入力</p>
                <input type="password" name="password" class="input_length_full" placeholder="パスワード" required>
                <p>パスワードを再度入力</p>
                <input type="password" name="password_confirmation" class="input_length_full" placeholder="パスワード(確認用)" required>
                @if ($errors->has('password'))
                    <p class="alert">
                        {{ $errors->first('password') }}
                    </p>
                @endif
            </div>
            <button class="content_button" type="submit">更新する</button>
        </form>
    </div>
</div>
@include('parts.template_auth_links')
@endsection
