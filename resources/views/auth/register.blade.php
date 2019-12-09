@extends('layouts.app')

@section('title', '新規会員登録')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」の新規会員登録はこちら。メールアドレスを記入頂き仮登録が出来ます。')
@section('page_id', 'page_regist')
@section('css', 'regist.css')
@section('not_need_head_img', true)

@section('content')
<div class="layout">
    <div class="title-simple">
        <h2>新規会員登録</h2>
    </div>
</div>

<div class="regist">
    <div class="layout">
        <form class="regist_form" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="regist_form_inner">
                <p>SNSで新規登録</p>
                <a class="sns_button fb" href="{{ url('/login/facebook') }}"><span><img src="{{ url('/') }}/img/common/fb.png"></span>Facebookでログイン</a>
            </div>
            <hr>
            <div class="regist_form_inner">
                <p>メールアドレスで新規登録</p>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス" required>
                @if ($errors->has('email'))
                    <p class="alert">
                        {{ $errors->first('email') }}
                    </p>
                @endif
                <p class="notice">※tsurizakana-shoten.comの受信許可をお願いします。<br>※「仮登録」ボタンをクリックすると、メールが届きます。</p>
                <div class="term_check js_checkbox">
                    <label>
                        <input type="checkbox" name="agreement" value="1">
                        <span><a href="{{ url('/term') }}" target="_blank">ご利用規約</a>へ同意する</span>
                    </label>
                </div>
            </div>
            <button class="content_button" type="submit" disabled>仮登録</button>
        </form>
    </div>
</div>
<script>
    $('[name=agreement]').change (function() {
        if ($('[name=agreement]').prop('checked')) {
            $('.content_button').prop('disabled', false);
        } else {
            $('.content_button').prop('disabled', true);
        }
    })
</script>
@include('parts.template_auth_links')
@endsection
