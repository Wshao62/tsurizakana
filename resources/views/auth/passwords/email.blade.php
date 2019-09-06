@extends('layouts.app')

@section('title', 'パスワードを忘れた方はこちら')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」の会員登録済の方でパスワードを忘れた方はこちらからメールアドレスを入力頂きますとパスワード再設定URLが送信されます。')
@section('page_id', 'page_password1')
@section('css', 'regist.css')

@section('content')
<div class="layout">
    <div class="title-simple">
    <h2>パスワードを<br class="hide_pc">忘れた方はこちら</h2>
    </div>
</div>

<div class="regist">
    <div class="layout">
    <form class="regist_form" method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="regist_form_inner">
            <p>登録時のメールアドレスをご入力ください。<br>パスワード再設定URLが送信されます。</p>
            @if (session('status'))
                <div class="alert success">
                    {{ session('status') }}
                </div>
            @endif
            <input name="email" value="{{ old('email') }}" placeholder="メールアドレス" required>
            @if ($errors->has('email'))
                <span class="alert">
                    {{ $errors->first('email') }}
                </span>
            @endif
            <p>※tsurizakana-shoten.comの受信許可をお願いします。<br>※「登録」ボタンをクリックすると、メールが届きます。</p>
        </div>
        <button class="content_button" type="submit">送信する</button>
    </form>
    </div>
</div>
@include('parts.template_auth_links')
@endsection
