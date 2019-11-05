@extends('layouts.app')

@section('title', 'お問い合わせ')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のお問い合わせページです。釣魚商店サービスについて、運営について、タイアップ等のご連絡はこちらからお願いします。')
@section('page_id', 'page_contact')
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
    <p class="current"><span>お問い合わせ情報入力</span></p>
    <p><span>入力情報確認</span></p>
    <p><span>入力完了</span></p>
    </div>
</div>
<div class="contact">
    <div class="layout_contact">
    <p class="contact_info">お問い合わせは下記フォームより<br class="hide_pc">お願いいたします。<br>
        お問い合わせ内容確認後、<br class="hide_pc">追って担当者よりご連絡させていただきます。</p>
    <form method="POST" action="{{ url('contact') }}" class="contact_form">
        @csrf
        <div class="contact_form_split require">
        <p class="contact_form_split_title">お問い合わせ項目</p>
        <div class="contact_form_split_content">
            <div class="contact_radio">
                <label class="contact_radio_label"><input type="radio" name="contact_type" value="釣魚商店について" @if (old('contact_type', $contact_type) == '釣魚商店について')checked="checked" @endif><span>釣魚商店について</span></label>
                <label class="contact_radio_label"><input type="radio" name="contact_type" value="ご質問・ご要望" @if (old('contact_type', $contact_type) == 'ご質問・ご要望')checked="checked" @endif><span>ご質問・ご要望</span></label>
                <label class="contact_radio_label"><input type="radio" name="contact_type" value="その他" @if (old('contact_type', $contact_type) == 'その他')checked="checked" @endif><span>その他</span></label>
            </div>
            @if ($errors->has('contact_type'))
                <p class="alert">
                    {{ $errors->first('contact_type') }}
                </p>
            @endif
        </div>
        </div>
        <div class="contact_form_split require">
            <p class="contact_form_split_title">お名前</p>
            <div class="contact_form_split_content contact_form_split_content_name">
                <input type="text" name="name" value="{{ old('name', $name) }}" id="contact_form_family" class="wide" placeholder="（例）釣魚 太郎">
                @if ($errors->has('name'))
                    <p class="alert">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="contact_form_split">
            <p class="contact_form_split_title">会社名/組織名</p>
            <div class="contact_form_split_content">
                <input type="text" name="form_company" value="{{ old('form_company', $form_company) }}" class="wide" placeholder="株式会社自給他足">
                @if ($errors->has('form_company'))
                    <p class="alert">
                        {{ $errors->first('form_company') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="contact_form_split require">
            <p class="contact_form_split_title">メールアドレス</p>
            <div class="contact_form_split_content">
                <input type="email" name="contact_email" value="{{ old('contact_email', $contact_email) }}" class="wide" placeholder="●●●●●＠oooooo.co.jp">
                @if ($errors->has('contact_email'))
                    <p class="alert">
                        {{ $errors->first('contact_email') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="contact_form_box">
            <div class="contact_form_box_inner">
                <p class="contact_form_split_title">郵便番号</p>
                <span class="contact_form_split_content">
                    <input type="text" name="postal_code" value="{{ old('postal_code', $postal_code) }}" class="narrow" onkeyup="AjaxZip3.zip2addr(this,'','prefect','addr1');" placeholder="000-000">
                    @if ($errors->has('postal_code'))
                    <p class="alert">
                        {{ $errors->first('postal_code') }}
                    </p>
                @endif
                </span>
            </div>
            <div class="contact_form_box_inner">
                <span class="contact_form_split_title">都道府県</span>
                <span class="contact_form_split_content">
                <label class="contact_select">
                    <select name="prefect">
                        <option value="">都道府県</option>
                        @foreach (config('const.prefectures') as $_pref)
                        <option value="{{ $_pref }}"@if (old('prefect', $prefect) ==  $_pref) selected="selected" @endif>{{ $_pref }}</option>
                        @endforeach
                    </select>
                </label>
                @if ($errors->has('prefect'))
                    <p class="alert">
                        {{ $errors->first('prefect') }}
                    </p>
                @endif
                </span>
            </div>
            <div class="contact_form_box_inner">
                <span class="contact_form_split_title">住所1</span>
                <span class="contact_form_split_content">
                    <input type="text" name="addr1" value="{{ old('addr1', $addr1) }}" class="wide" placeholder="(例）神奈川県平塚市夕陽ケ丘１番">
                    @if ($errors->has('addr1'))
                        <p class="alert">
                            {{ $errors->first('addr1') }}
                        </p>
                    @endif
                </span>
            </div>
            <div class="contact_form_box_inner">
                <span class="contact_form_split_title">住所2</span>
                <span class="contact_form_split_content">
                    <input type="text" name="addr2" value="{{ old('addr2', $addr2) }}" class="wide" placeholder="(例）１６号 第１三富ビル３F">
                    @if ($errors->has('addr2'))
                        <p class="alert">
                            {{ $errors->first('addr2') }}
                        </p>
                    @endif
                </span>
            </div>
        </div>
        <div class="contact_form_split">
            <p class="contact_form_split_title">電話番号</p>
            <div class="contact_form_split_content">
                <div class="contact_form_split_content_info contact_form_phone">
                    <input type="text" name="tel1" value="{{ old('tel1', $tel1) }}" class="narrow">
                    <span>ー</span>
                    <input type="text" name="tel2" value="{{ old('tel2', $tel2) }}" class="narrow">
                    <span>ー</span>
                    <input type="text" name="tel3" value="{{ old('tel3', $tel3) }}" class="narrow">
                </div>
                @if ($errors->has('tel1'))
                    <p class="alert">
                        {{ $errors->first('tel1') }}
                    </p>
                @endif
                @if ($errors->has('tel2'))
                    <p class="alert">
                        {{ $errors->first('tel2') }}
                    </p>
                @endif
                @if ($errors->has('tel3'))
                    <p class="alert">
                        {{ $errors->first('tel3') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="contact_form_split require">
            <p class="contact_form_split_title">お問い合わせ内容</p>
            <div class="contact_form_split_content">
                <textarea name="description" class="wide">{{ old('description', $description) }}</textarea>
                @if ($errors->has('description'))
                    <p class="alert">
                        {{ $errors->first('description') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="contact_privacy">
            <p class="contact_privacy_title">個人情報の取り扱いについて</p>
            <div class="contact_privacy_box">
                <p class="contact_privacy_box_title">利用目的</p>
                <p class="contact_privacy_box_text contact_privacy_box_text_small">
                お預かりする個人情報は、本人からお問い合わせいただいたご質問等の内容に回答させていただくことを目的として収集し、
                それ以外に利用することはありません。<br>また、いただいた個人情報を第三者に提供することはありません。
                </p>
                <p class="contact_privacy_box_title">その他</p>
                <p class="contact_privacy_box_text">その他の個人情報取扱い方針につきましては、<a href="/term/privacy.html" class="point">個人情報保護方針で開く</a>をご覧下さい。</p>
            </div>
            <div class="contact_privacy_check js_checkbox">
                <label><input type="checkbox" name="agreement" value="1"><span>個人情報の取り扱いに同意する</span></label>
            </div>
        </div>
        @if ($errors->has('agreement'))
            <p class="alert">
                {{ $errors->first('agreement') }}
            </p>
        @endif
        <input type="hidden" name="submit" value="{{ "contact" }}">
        <button class="content_button_arrow js_checkbox_area" type="submit" disabled>入力内容の確認画面へ</button>
    </form>
    </div>
</div>
@endsection

@section('before_end')
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
@endsection
