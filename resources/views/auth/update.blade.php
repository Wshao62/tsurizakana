@extends('layouts.app')

@section('title', 'プロフィール編集')
@section('page_id', 'page_profileedit')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')

<div id="cover_preview" class="user_bg" style="background-image: url({{ $user['photo']->getCover() }});"></div>
<input class="js_modal_open link_profile" type="button" data-id="cover_preview" value="カバー写真を変更"/>
<div class="layout">
    <div class="user_info">
        <div class="fit_image">
            <img id="profile_preview" src="{{ $user['photo']->getProfile() }}">
        </div>
        <div class="user_info_change">
            <input class="js_modal_open content_button change_img_btn" type="button" data-id="profile_preview"  value="プロフィール写真を変更"/>
            <input class="js_modal_open content_button change_img_btn hide_pc" type="button" data-id="cover_preview" value="カバー写真を変更">
        </div>
    </div>
    @include('parts/template_identification_notify_box')

    @if ($errors->has('profile_photo'))
        <p class="img_error content_alert_box alert">
            {{ $errors->first('profile_photo') }}
        </p>
    @endif
    @if ($errors->has('cover_photo'))
        <p class="img_error content_alert_box alert">
            {{ $errors->first('cover_photo') }}
        </p>
    @endif
    @if (session('status'))
        <div class="content_success_box">
            <p class="success">{{ session('status') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="content_alert_box">
            <p class="alert">{{ session('error') }}</p>
        </div>
    @endif
    <form class="edit_form" method="POST" action="{{ url('/mypage/profile/confirm')  }}" enctype="multipart/form-data">
        @csrf
        <div class="edit_form_inner">
            <div class="edit_form_split">お名前</div>
            {{ $user['name'] }}
            <div class="edit_form_split">フリガナ</div>
            {{ $user['furigana'] }}
            <div class="edit_form_split">メールアドレス</div>
            <input class="input_length_full" type="text" name="email" value="{{ old('email', $user['email']) }}" placeholder="例）turizakana@test.xxx">
            @if ($errors->has('email'))
                <p class="alert">
                    {{ $errors->first('email') }}
                </p>
            @endif
            <div class="edit_form_split">届け先住所</div>
            <label>
                <span>郵便番号</span>
                <input class="input_length_short" type="text" name="zipcode" value="{{ old('zipcode', $user['zipcode']) }}" onkeyup="AjaxZip3.zip2addr(this,'','prefecture','public_address');" placeholder="〒000-000">
            </label>
            @if ($errors->has('zipcode'))
                <p class="alert">{{ $errors->first('zipcode') }}</p>
            @endif
            <label>
                <span>都道府県</span>
                <div class="edit_form_select input_length_short">
                    <select name="prefecture">
                        <option value="">都道府県</option>
                        @foreach (config('const.prefectures') as $_pref)
                        <option value="{{ $_pref }}"@if (old('prefecture', $user['prefecture']) ==  $_pref) selected="selected" @endif>{{ $_pref }}</option>
                        @endforeach
                    </select>
                </div>
            </label>
            @if ($errors->has('prefecture'))
                <p class="alert">{{ $errors->first('prefecture') }}</p>
            @endif
            <label>
                <span>公開住所</span>
                <input type="text" name="public_address" value="{{ old('public_address', $user['public_address']) }}"
                       placeholder="(例）神奈川県平塚市夕陽ケ丘">
            </label>
            @if ($errors->has('public_address'))
                <p class="alert">{{ $errors->first('public_address') }}</p>
            @endif
            <label>
                <span>非公開住所</span>
                <input type="text" name="private_address" value="{{ old('private_address', $user['private_address']) }}"
                       placeholder="(例）１番 １６号 第１三富ビル３０２号">
            </label>
            @if ($errors->has('private_address'))
                <p class="alert">{{ $errors->first('private_address') }}</p>
            @endif
            <div class="edit_form_split">携帯番号</div>
            <input class="input_length_full" type="text" name="mobile_tel" value="{{ old('mobile_tel', $user['mobile_tel']) }}" placeholder="0000000000">
            @if ($errors->has('mobile_tel'))
                <p class="alert">{{ $errors->first('mobile_tel') }}</p>
            @endif
            <div class="edit_form_split">電話番号</div>
            <input class="input_length_full" type="text" name="tel" value="{{ old('tel', $user['tel']) }}" placeholder="00-0000-0000">
            @if ($errors->has('tel'))
                <p class="alert">{{ $errors->first('tel') }}</p>
            @endif
            <div class="edit_form_split">自己紹介</div>
            <textarea class="input_length_full" name="introduction">{{ old('introduction', $user['introduction']) }}</textarea>
            @if ($errors->has('introduction'))
                <p class="alert">{{ $errors->first('introduction') }}</p>
            @endif

            <hr>

            <div class="edit_form_split">お店の名前</div>
            <input class="input_length_full" type="text" name="shop_name" value="{{ old('shop_name', $user['shop_name']) }}" placeholder="（例）釣魚商店">
            @if ($errors->has('shop_name'))
                <p class="alert">{{ $errors->first('shop_name') }}</p>
            @endif
            <div class="edit_form_split">お店の住所</div>
            <label>
                <span>郵便番号</span>
                <input class="input_length_short" type="text" name="shop_zipcode" value="{{ old('shop_zipcode', $user['shop_zipcode']) }}" onkeyup="AjaxZip3.zip2addr(this,'','shop_prefecture','shop_address1');" placeholder="〒000-000">
            </label>
            @if ($errors->has('shop_zipcode'))
                <p class="alert">{{ $errors->first('shop_zipcode') }}</p>
            @endif
            <label>
                <span>都道府県</span>
                <div class="edit_form_select input_length_short">
                    <select name="shop_prefecture">
                        <option value="">都道府県</option>
                        @foreach (config('const.prefectures') as $_pref)
                        <option value="{{ $_pref }}"@if (old('shop_prefecture', $user['shop_prefecture']) ==  $_pref) selected="selected" @endif>{{ $_pref }}</option>
                        @endforeach
                    </select>
                </div>
            </label>
            @if ($errors->has('shop_prefecture'))
                <p class="alert">{{ $errors->first('shop_prefecture') }}</p>
            @endif
            <label>
                <span>住所１</span>
                <input type="text" name="shop_address1" value="{{ old('shop_address1', $user['shop_address1']) }}"
                       placeholder="(例）神奈川県平塚市夕陽ケ丘">
            </label>
            @if ($errors->has('shop_address1'))
                <p class="alert">{{ $errors->first('shop_address1') }}</p>
            @endif
            <label>
                <span>住所２</span>
                <input type="text" name="shop_address2" value="{{ old('shop_address2', $user['shop_address2']) }}"
                       placeholder="(例）１番 １６号 第１三富ビル３０２号">
            </label>
            @if ($errors->has('shop_address2'))
                <p class="alert">{{ $errors->first('shop_address2') }}</p>
            @endif

            <hr>

            <div class="edit_form_split">口座番号</div>
            <label>
                <span>銀行名</span>
                <input type="text" name="bank_name" value="{{ old('bank_name', $user['bank_name']) }}" placeholder="（例）釣魚銀行">
            </label>
            @if ($errors->has('bank_name'))
                <p class="alert">{{ $errors->first('bank_name') }}</p>
            @endif
            <label>
                <span>支店コード</span>
                <input class="input_length_short" type="text" name="bank_branch_code" value="{{ old('bank_branch_code', $user['bank_branch_code']) }}" placeholder="半角英数３桁">
            </label>
            @if ($errors->has('bank_branch_code'))
                <p class="alert">{{ $errors->first('bank_branch_code') }}</p>
            @endif
            <label>
                <span>口座種別</span>
                <div class="edit_form_select input_length_short">
                    <select name="bank_type">
                        <option value="">-----</option>
                        @foreach (\App\Models\User::BANK_TYPE_NAME as $_k => $_v)
                            <option value="{{ $_k }}" @if (old('bank_type', $user['bank_type']) ==  $_k) selected="selected" @endif>{{ $_v }}</option>
                        @endforeach
                    </select>
                </div>
            </label>
            @if ($errors->has('bank_type'))
                <p class="alert">{{ $errors->first('bank_type') }}</p>
            @endif
            <label>
                <span>口座番号</span>
                <input type="text" name="bank_number" value="{{ old('bank_number', $user['bank_number']) }}" placeholder="半角英数４〜７桁">
            </label>
            @if ($errors->has('bank_number'))
                <p class="alert">{{ $errors->first('bank_number') }}</p>
            @endif
            <label>
                <span>口座名義<br>（カナ）</span>
                <input type="text" name="bank_user_name" value="{{ old('bank_user_name', $user['bank_user_name']) }}" placeholder="タナカタロウ">
            </label>
            @if ($errors->has('bank_user_name'))
                <p class="alert">{{ $errors->first('bank_user_name') }}</p>
            @endif
            <button type="submit" class="content_button">変更する</button>
        </div>
        <div class="modal" id="modal">
            <div class="modal_layout">
                <div class="modal_inner modal_image">
                    <div class="upload">
                        <div class="upload_drag">
                            <p>画像アップロード</p>
                            <div class="js_upload_drag_area upload_drag_area"><div class="black_cover hide"></div></div>
                        </div>
                        <div class="upload_input">
                            <p>画像ファイル</p>
                            <label id="cover">
                            <p>画像ファイルを選択</p>
                                <input class="preview_image" accept="image/*" type="file" id="preview_image_cover" value="" name="cover_photo"/>
                            </label>
                            <label id="profile">
                            <p>画像ファイルを選択</p>
                                <input class="preview_image" accept="image/*" type="file" id="preview_image_profile" value="" name="profile_photo"/>
                            </label>
                            <span>
                                ※最大アップロードサイズは5MBまでです。<br>
                                ※プロフィールの編集を終えるまで変更は完了しません。
                            </span>
                        </div>
                    </div>
                    <img src="" class="modal_image">
                </div>
            </div>
        </div>
    </form>
</div>
<!-- ↓完了ダイアログ -->
@if (!empty(session('isCompleted')))
    <div class="edit_finish">
        <div class="edit_finish_inner">
            <p>プロフィール編集が完了しました！</p>
            <img src="/img/mypage/profile_check.png">
        </div>
    </div>

<script>
    $(function(){
        $('.edit_finish').on('click', function(){
            $(this).hide();
        });
        setTimeout(function () {
            $('.edit_finish').hide();
        }, 3000);
    });
</script>
@endif

@endsection
@section('before_end')
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<script type="text/javascript">
    $(function(){
        var isCover = false;
        var isProfile = false;
        $('.preview_image').on('change', function(evt){

            var PreviewCover = document.getElementById('cover_preview');
            var PreviewProfile = document.getElementById('profile_preview');

            evt.stopPropagation();
            if($(evt.target).closest(".modal_image").length){
                $(".modal").removeClass('open');
            }

            if(isCover){
                var UploadPhoto = document.getElementById('preview_image_cover').files[0];
            }else{
                var UploadPhoto = document.getElementById('preview_image_profile').files[0];
            }
            var ReaderObj = new FileReader();
            ReaderObj.onloadend = function () {
                if(isCover){
                    PreviewCover.style.backgroundImage  = "url("+ ReaderObj.result+")";
                }else if(isProfile){
                    PreviewProfile.src = ReaderObj.result;
                }
            }
            if (UploadPhoto) {
                ReaderObj.readAsDataURL(UploadPhoto);
            }

        });
        $("input:button").click(function() {
            isProfile = false;
            isCover = false;
            clickButton(this) // this is the button element, same as alert(this.id)
        });

        function clickButton(button) {
            document.getElementById('profile').style.display = 'none';
            document.getElementById('cover').style.display = 'none';

            if(button.dataset.id === "cover_preview"){
                document.getElementById('cover').style.display = 'block';
                isCover = true;
            }else if(button.dataset.id === "profile_preview"){
                document.getElementById('profile').style.display = 'block';
                isProfile = true;
            }
        }

        // ドラッグ&ドロップ ////////////////////////////////////
        let $dropArea = $('.js_upload_drag_area');
        $dropArea.on('dragenter', function (e) {
            e.stopPropagation();
            e.preventDefault();
            changeDesign(true);
        });
        $dropArea.on('dragover', function (e) {
            e.stopPropagation();
            e.preventDefault();
            changeDesign(true);
        });
        $dropArea.on('drop', function (e) {
            changeDesign(false);
            e.preventDefault();
            $('.img_error').remove();
            var files = e.originalEvent.dataTransfer.files;
            if (files.length > 1)
            {
                $('<span></span>').appendTo('.upload_input span')
                    .addClass('img_error content_alert_box alert')
                    .text('画像は１枚のみ設定できます。');
                    console.log('aaaaa');
                return;
            }

            if(isCover){
                $('#preview_image_cover').prop('files', files);
            }else{
                $('#preview_image_profile').prop('files', files);
            }
        });
        $(document).on('dragenter', function (e) {
            e.stopPropagation();
            e.preventDefault();
        });
        $(document).on('dragover', function (e) {
            e.stopPropagation();
            e.preventDefault();
            changeDesign(false);
        });
        $(document).on('drop', function (e) {
            e.stopPropagation();
            e.preventDefault();
        });
        function changeDesign(is_on = false) {
            if (is_on) {
                $dropArea.find('.black_cover').removeClass('hide');
            } else {
                $dropArea.find('.black_cover').addClass('hide');
            }
        }
        //////////////////////////////////////////////////////
    });
</script>
@endsection
