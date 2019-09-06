@extends('layouts.app')

@section('title', '新規会員登録 仮登録完了')
@section('page_id', 'page_regist')
@section('css', 'regist.css')

@section('content')
<div class="layout">
    <div class="title-simple">
        <h2>新規会員登録 仮登録完了</h2>
    </div>
</div>

<div class="regist">
    <div class="layout">
        <div class="regist_form">
            <div class="regist_form_inner">
                <p>
                    メールアドレスに確認メールを送信いたしました。<br>
                    届いたメールのリンクから会員登録を続行してください。
                </p>
            </div>
        </div>
    </div>
</div>
@include('parts.template_auth_links')
@endsection
