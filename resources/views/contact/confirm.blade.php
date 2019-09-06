@extends('layouts.app')

@section('title', 'お問い合わせ 確認')
@section('page_id', 'page_contactconfirm')
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
        <p class="current"><span>入力情報確認</span></p>
        <p><span>入力完了</span></p>
    </div>
</div>

<div class="contact">
    <div class="layout_contact">
        <form method="POST" action="{{ url('contact') }}" class="contact_form">
            <div class="contact_form_split">
                <p class="contact_form_split_title">お問い合わせ項目</p>
                <p class="contact_form_split_content">{{ $contact_type }}</p>
            </div>
            <div class="contact_form_split">
                <p class="contact_form_split_title">お名前</p>
                <p class="contact_form_split_content">{{ $name }}</p>
            </div>
            <div class="contact_form_split">
                <p class="contact_form_split_title">会社名/組織名</p>
                <p class="contact_form_split_content">{{ $form_company }}</p>
            </div>
            <div class="contact_form_split">
                <p class="contact_form_split_title">メールアドレス</p>
                <p class="contact_form_split_content">{{ $contact_email }}</p>
            </div>
            <div class="contact_form_box">
                <p class="contact_form_box_inner"><span class="contact_form_split_title">郵便番号</span><span class="contact_form_split_content">{{ $postal_code }}</span></p>
                <p class="contact_form_box_inner"><span class="contact_form_split_title">都道府県</span><span class="contact_form_split_content">{{ $prefect }}</span></p>
                <p class="contact_form_box_inner"><span class="contact_form_split_title">住所1</span><span class="contact_form_split_content">{{ $addr1 }}</span></p>
                <p class="contact_form_box_inner"><span class="contact_form_split_title">住所2</span><span class="contact_form_split_content">{{ $addr2 }}</span></p>
            </div>
            <div class="contact_form_split">
                <p class="contact_form_split_title">電話番号</p>
                <p>{{ $tel1 }}-{{ $tel2 }}-{{ $tel3 }}</p>
            </div>
            <div class="contact_form_split">
                <p class="contact_form_split_title">お問い合わせ内容</p>
                <p class="contact_form_split_content">{!! nl2br(htmlspecialchars($description)) !!}</p>
            </div>

            @csrf
            <input type="hidden" name="contact_type" value="{{ $contact_type }}">
            <input type="hidden" name="name" value="{{ $name }}">
            <input type="hidden" name="form_company" value="{{ $form_company }}">
            <input type="hidden" name="contact_email" value="{{ $contact_email }}">
            <input type="hidden" name="postal_code" value="{{ $postal_code }}">
            <input type="hidden" name="prefect" value="{{ $prefect }}">
            <input type="hidden" name="addr1" value="{{ $addr1 }}">
            <input type="hidden" name="addr2" value="{{ $addr2 }}">
            <input type="hidden" name="tel1" value="{{ $tel1 }}">
            <input type="hidden" name="tel2" value="{{ $tel2 }}">
            <input type="hidden" name="tel3" value="{{ $tel3 }}">
            <input type="hidden" name="description" value="{{ $description }}">
            <input type="hidden" name="agreement" value="1">
            <input type="hidden" name="submit" value="complete">

            <div class="contact_button">
                <a href="{{ url('/contact') }}" class="content_button">修正する</a>
                <button class="content_button" type="submit">送信する</button>
            </div>
        </form>
    </div>
</div>
@endsection