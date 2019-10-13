@extends('layouts.app')

@section('title', 'プロフィール編集')
@section('page_id', 'page_profileconfirm')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
@if (!empty($data['cover_photo']['mime']) && !empty($data['cover_photo']['tmp_path']))
    <div class="user_bg" style="background-image: url(data:{{ $data['cover_photo']['mime'] }};base64,{{ base64_encode(file_get_contents($data['cover_photo']['tmp_path'])) }});"></div>
@else
    <div class="user_bg" style="background-image: url({{ $data['photo']->getCover() }});"></div>
@endif
<div class="layout">
    <div class="user_info">
        <div class="fit_image">
            @if (!empty($data['profile_photo']['mime']) && !empty($data['profile_photo']['tmp_path']))
                <img src="data:{{ $data['profile_photo']['mime'] }};base64,{{ base64_encode(file_get_contents($data['profile_photo']['tmp_path'])) }}">
            @else
                <img  src="{{ $data['photo']->getProfile() }}">
            @endif
        </div>
        <div class="user_info_change">
            <button class="js_modal_open content_button hide_pc">カバー写真を変更</button>
        </div>
    </div>
    @if (session('error'))
        <span class="alert">{{ session('error') }}</span>
    @endif
    <form class="edit_form" action="{{ url('/mypage/profile/update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <span class="edit_form_inner up_form">
            <div class="edit_form_split">メールアドレス</div>
            <p>
                {{ $data['email'] }}<br>
                @if (\Auth::user()->email !== trim($data['email']))
                ※メールアドレスを変更した場合、確認メールが送付されます。<br>
                ※クレジットカード情報を登録していた場合、情報はリセットされます。
                @endif
            </p>
            <div class="edit_form_split">現住所</div>
            <label>
            <span>郵便番号</span>
            <p>{{ $data['zipcode'] }}</p>
            </label>
            <label>
            <span>都道府県</span>
            <p>{{ $data['prefecture'] }}</p>
            </label>
            <label>
            <span>住所1</span>
            <p>{{ $data['public_address'] }}</p>
            </label>
            <label>
            <span>住所2</span>
            <p>{{ $data['private_address'] }}</p>
            </label>
            <div class="edit_form_split">携帯番号</div>
            <p>{{ $data['mobile_tel'] }}</p>
            <div class="edit_form_split">電話番号</div>
            <p>{{ $data['tel'] }}</p>

            <br>
            <hr>

            <div class="edit_form_split">釣行エリア</div>
            <p>{{ $data['fishing_area'] }}</p>

            <div class="edit_form_split">得意な釣魚</div>
            <p>{{ $data['good_fishing_fish'] }}</p>

            <div class="edit_form_split">釣り歴</div>
            <p>{{ $data['fishing_history'] }}</p>

            <div class="edit_form_split">釣りに行く曜日</div>
            <p>{{ !empty($data['day_of_week_fishing']) ? implode(',', $data['day_of_week_fishing']) : '' }}</p>

            <div class="edit_form_split">自己紹介</div>
            <p>{!! nl2br(htmlspecialchars($data['introduction'])) !!}</p>

            <br>
            <hr>

            <div class="edit_form_split">お店の名前</div>
            <p>{{ $data['shop_name'] }}</p>

            <div>画像ファイル</div>
            <ul class="up_form_slider sp">
                @foreach ($data['shop_photo'] as $_p)
                     <li><div class="fit_image"><img src="{{ $_p }}"></div></li>
                 @endforeach
            </ul>
            <div class="up_form_image">
                @foreach ($data['shop_photo'] as $_p)
                    <div class="fit_image">
                    <img src="{{ $_p }}">
                </div>
                @endforeach
            </div>

            <div class="edit_form_split">店舗種別</div>
            <p>{{ $data['shop_type'] }}</p>

            <div class="edit_form_split">お店の住所</div>
            <label>
            <span>郵便番号</span>
            <p>{{ $data['shop_zipcode'] }}</p>
            </label>
            <label>
            <span>都道府県</span>
            <p>{{ $data['shop_prefecture'] }}</p>
            </label>
            <label>
            <span>住所1</span>
            <p>{{ $data['shop_address1'] }}</p>
            </label>
            <label>
            <span>住所2</span>
            <p>{{ $data['shop_address2'] }}</p>
            </label>

            <div class="edit_form_split">店舗HP</div>
            <p>{{ $data['shop_home_page_url'] }}</p>

            <br>
            <hr>

            <div class="edit_form_split">口座情報</div>
            <label>
                <span>銀行名</span>
                <p>{{ $data['bank_name'] }}</p>
            </label>
            <label>
                <span>支店コード</span>
                <p>{{ $data['bank_branch_code'] }}</p>
            </label>
            <label>
                <span>口座種別</span>
                @if (!empty($data['bank_type']))
                <p>{{ \App\Models\User::BANK_TYPE_NAME[$data['bank_type']] }}</p>
                @else
                <p></p>
                @endif
            </label>
            <label>
                <span>口座番号</span>
                <p>{{ $data['bank_number'] }}</p>
            </label>
            <label>
                <span>口座名義</span>
                <p>{{ $data['bank_user_name'] }}</p>
            </label>
            <div class="up_btns">
                <input class="content_button" type="submit" value="変更する">
                <input class="content_button" type="button" value="戻る" onClick="location.href='{{ url('/mypage/profile/edit') }}'">
            </div>
        </div>
    </form>
</div>
@endsection

