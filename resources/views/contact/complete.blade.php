@extends('layouts.app')

@section('title', 'お問い合わせ 完了')
@section('page_id', 'page_contactcomplete')
@section('css', 'contact.css')

@section('content')
<div class="layout">
    <div class="title">
        <h2>お問い合わせ</h2>
        <p class="font_avenirnext">CONTACT</p>
    </div>
</div>
<div class="layout_contact">
    <div class="flow">
        <p><span>お問い合わせ情報入力</span></p>
        <p><span>入力情報確認</span></p>
        <p class="current"><span>入力完了</span></p>
    </div>
</div>

<div class="contact">
    <div class="layout_contact">
        <div class="contact_form">
            <h3>お問い合わせが<br class="hide_pc">完了しました</h3>
            <p>お問い合わせいただき<br class="hide_pc">ありがとうございました。<br>お問い合わせを受け付けました。</p>
            <p>折り返し、担当者より<br class="hide_pc">ご連絡いたしますので、<br class="hide_sp">恐れ入りますが、しばらくお待ちください。</p>
            <p>
            なお、ご入力いただいた<br class="hide_pc">メールアドレス宛に受付完了メールを配信しております。<br>
            完了メールが届かない場合、<br class="hide_pc">処理が正常に行われていない<br class="hide_pc">可能性があります。<br>
            大変お手数ですが、再度お問い合わせの<br class="hide_pc">手続きをお願い致します。
            </p>
            <a href="{{ url('/') }}" class="content_button">トップページに戻る</a>
        </div>
    </div>
</div>
@endsection