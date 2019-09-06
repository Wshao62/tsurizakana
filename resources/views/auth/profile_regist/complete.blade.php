@extends('layouts.app')


@section('title', '会員登録完了')
@section('page_id', 'page_registcompleted')
@section('css', 'regist.css')
@section('not_need_head_img', true)

@section('content')
<div class="layout">
    <div class="title-simple">
        <h2>新規会員登録完了</h2>
    </div>
    <div class="flow">
    <p><a href="step1.html"><span>会員情報入力</span></a></p>
    <p><a href="step2.html"><span>個人情報入力</span></a></p>
    <p><a href="confirm.html"><span>確認画面</span></a></p>
    <p class="current"><span>登録完了</span></p>
    </div>
</div>

<div class="regist">
    <div class="regist_layout">
    <div class="regist_form">
        <div class="regist_form_inner">
        <p>ご登録ありがとうございます。<br class="pc">これでブログ機能がご利用いただけます！<br><br class="pc">
            売魚の取引やリクエスト魚の登録をする場合は<br class="pc">引き続き本人確認をお願いいたします。</p>
        </div>
        <a href="{{ url('/identification') }}" class="content_button">本人確認をする</a>
        <a href="{{ url('/mypage/blog') }}" class="later_link">あとで</a>
    </div>
    </div>
</div>
@include('parts.template_auth_links')
@endsection