@extends('layouts.app')


@section('title', '会員情報入力 ステップ２')
@section('page_id', 'page_step2')
@section('css', 'regist.css')
@section('not_need_head_img', true)

@section('content')
<div class="layout">
    <div class="title-simple">
        <h2>新規会員登録</h2>
    </div>
    <div class="flow">
    <p><a href="step1.html"><span>会員情報入力</span></a></p>
    <p class="current"><span>個人情報入力</span></p>
    <p><span>確認画面</span></p>
    <p><span>登録完了</span></p>
    </div>
</div>

<div class="regist">
    <div class="regist_layout">
    <form method="POST" action="{{ url('/register/profile/'. $user['token'].'/confirm') }}" class="regist_form">
        @csrf
        <div class="regist_form_inner">
            <div class="regist_form_split require">届け先住所</div>
            <label>
                <span>郵便番号</span>
                <input type="tel" name="zipcode" value="{{ old('zipcode', $old_data['zipcode']) }}" onkeyup="AjaxZip3.zip2addr(this,'','prefecture','public_address');" class="input_lengthort" placeholder="〒000-000">
            </label>
            @if ($errors->has('zipcode'))
                <p class="alert">{{ $errors->first('zipcode') }}</p>
            @endif
            <label>
                <span>都道府県</span>
                <div class="regist_form_select_wrap">
                <select class="input_length_short" name="prefecture">
                    <option value="">都道府県</option>
                    @foreach (config('const.prefectures') as $_pref)
                    <option value="{{ $_pref }}"@if (old('prefecture', $old_data['prefecture']) ==  $_pref) selected="selected" @endif>{{ $_pref }}</option>
                    @endforeach
                </select>
                </div>
            </label>
            @if ($errors->has('prefecture'))
                <p class="alert">{{ $errors->first('prefecture') }}</p>
            @endif
            <label>
                <span>公開住所</span>
                <input type="text" name="public_address" value="{{ old('public_address', $old_data['public_address']) }}" class="input_length_long" placeholder="（例）神奈川県平塚市夕陽ケ丘１番">
            </label>
            @if ($errors->has('public_address'))
                <p class="alert">{{ $errors->first('public_address') }}</p>
            @endif
            <label>
                <span>非公開住所</span>
                <input type="text" name="private_address" value="{{ old('private_address', $old_data['private_address']) }}" class="input_length_long" placeholder="（例）１６号 第１三富ビル３０２号">
            </label>
            @if ($errors->has('private_address'))
                <p class="alert">{{ $errors->first('private_address') }}</p>
            @endif
            <div class="regist_form_split require">携帯番号</div>
            <input type="tel" name="mobile_tel" value="{{ old('mobile_tel', $old_data['mobile_tel']) }}" class="input_length_full" placeholder="00-0000-0000">
            @if ($errors->has('mobile_tel'))
                <p class="alert">{{ $errors->first('mobile_tel') }}</p>
            @endif
            <div class="regist_form_split">電話番号</div>
            <input type="tel" name="tel" value="{{ old('tel', $old_data['tel']) }}" class="input_length_full" placeholder="00-0000-0000">
            @if ($errors->has('tel'))
                {{ $errors->first('tel') }}
            @endif

            <hr>
            <p class="shop_notice">
                お店でご登録の方は下記、情報の入力もお願いいたします。<br>
                お店は全ユーザが検索ができ、<br class="pc">プロフィールにも表示されるようになっております。
            </p>

            <div class="regist_form_split">お店名</div>
            <input type="tel" name="shop_name" value="{{ old('shop_name', $old_data['shop_name']) }}" class="input_length_full" placeholder="（例）釣魚商店">
            @if ($errors->has('shop_name'))
                <p class="alert">{{ $errors->first('shop_name') }}</p>
            @endif
            <div class="regist_form_split">お店住所</div>
            <label>
                <input type="tel" name="shop_zipcode" value="{{ old('shop_zipcode', $old_data['shop_zipcode']) }}" onkeyup="AjaxZip3.zip2addr(this,'','shop_prefecture','shop_address1');" class="input_lengthort" placeholder="〒000-000">
            </label>
            <label>
                <div class="regist_form_select_wrap">
                    <select class="input_length_short" name="shop_prefecture">
                        <option value="">都道府県</option>
                        @foreach (config('const.prefectures') as $_pref)
                        <option value="{{ $_pref }}"@if (old('shop_prefecture', $old_data['shop_prefecture']) ==  $_pref) selected="selected" @endif>{{ $_pref }}</option>
                        @endforeach
                    </select>
                </div>
            </label>
            <label>
                <input type="text" name="shop_address1" value="{{ old('shop_address1', $old_data['shop_address1']) }}" class="input_length_long" placeholder="（例）神奈川県平塚市夕陽ケ丘１番">
            </label>
            <label>
                <input type="text" name="shop_address2" value="{{ old('shop_address2', $old_data['shop_address2']) }}" class="input_length_long" placeholder="（例）１６号 第１三富ビル３０２号">
            </label>
            @if ($errors->has('shop_zipcode'))
                <p class="alert">{{ $errors->first('shop_zipcode') }}</p>
            @endif
            @if ($errors->has('shop_prefecture'))
                <p class="alert">{{ $errors->first('shop_prefecture') }}</p>
            @endif
            @if ($errors->has('shop_address1'))
                <p class="alert">{{ $errors->first('shop_address1') }}</p>
            @endif
            @if ($errors->has('shop_address2'))
                <p class="alert">{{ $errors->first('shop_address2') }}</p>
            @endif
        </div>

        <button class="content_button_arrow" type="submit">次へ進む</button>
    </form>
    </div>
</div>
@include('parts.template_auth_links')
@endsection

@section('before_end')
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
@endsection