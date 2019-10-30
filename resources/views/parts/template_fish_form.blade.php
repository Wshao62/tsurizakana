@if (session('error'))
<p class="content_alert_box alert">{{ session('error') }}</p>
@endif
@if (empty(\Auth::user()->bank_name))
<p class="bank_box">
    口座情報が未登録です。<br>口座情報登録をしていただかないと、購入希望者が現れても購入者を確定できません。
    <a href="{{ url('/mypage/profile/edit') }}" class="content_button">プロフィール編集へ</a>
</p>
@endif
<div class="up_wrap">
    <form class="up_form" method="POST" action="{{ $action_url }}" onsubmit="return doSubmit(this);" enctype="multipart/form-data">
        @csrf
        <div class="drop_area pc js_img_drop_area">
            <img src="{{ url('/') }}/img/mypage/image.png">
            <p>
                こちらにファイルをドロップ<br>
                写真は最大3枚までとなります。
            </p>
        </div>
        <dl class="up_forms">
            <dt>画像ファイル</dt>
            <dd>
                <div class="form_pic">
                    <label>
                        <button type="button" class="js_add_img_btn">選択</button>
                        <input type="file" name="dummy_file" class="hide" accept="image/*" multiple>
                    </label>
                    @if ($errors->has('photo'))
                        <p class="alert content_alert_box img_error">
                            {{ $errors->first('photo') }}
                        </p>
                    @endif
                    @if ($errors->has('photo.*'))
                        <span class="alert content_alert_box img_error">
                            @foreach ($errors->get('photo.*') as $photo_errors)
                                @foreach ($photo_errors as $_e)
                                    {{ $_e }}<br>
                                @endforeach
                            @endforeach
                        </span>
                    @endif
                    @if ($errors->has('photo_id.*'))
                        <span class="alert content_alert_box img_error">
                            @foreach ($errors->get('photo_id.*') as $photo_id_errors)
                                @foreach ($photo_id_errors as $_e)
                                    {{ $_e }}<br>
                                @endforeach
                            @endforeach
                        </span>
                    @endif
                    <div class="uped_pic">
                        @php ($showed_ids = [])
                        @for ($idx = 0; $idx < 3; $idx++)
                        <div class="uppi_box">
                            @php ($old_photo = '')
                            @php ($old_photo_id = '')
                            @if (empty($id) && (!$errors->has('photo.'.$idx)))
                                {{-- 新規登録時のphoto初期値 --}}
                                    @php ($old_photo = old('photo.'.$idx, $photo[$idx]))
                            @elseif (!empty($id))
                                {{-- 編集時のphoto初期値 --}}

                                @if (!$errors->has('photo_id.'.$idx))
                                    {{-- 不正なIDが入力された場合は空とするが、エラーがない場合はそのまま表示 --}}
                                    @php ($old_photo_id = old('photo_id.'.$idx, $photo_id[$idx]))

                                    @if (!in_array(old('photo_id.'.$idx), $showed_ids) && $old_photo_id == $photo_id[$idx])
                                        @php ($old_photo = old('photo.'.$idx, $photo[$idx]))
                                    @else
                                        @php ($old_photo = old('photo.'.$idx))
                                    @endif

                                @endif

                                @php ($showed_ids[] = $old_photo_id)
                            @endif
                            <div class="fit_image">
                                <img src="{{ $old_photo }}" class="preview">
                                <input name="photo[]" value="{{ $old_photo }}" type="hidden">
                                @if (!empty($id))
                                <input type="hidden" name="photo_id[]" value="{{ $old_photo_id }}">
                                @endif
                            </div>
                            <input type="button" name="" value=" " class="js_reset_file @if (empty($old_photo))hide @endif">
                        </div>
                        @endfor
                        <div class="clear hide"></div>
                    </div>
                    <p>※最大アップロードサイズは10MBまでです。</p>
                </div>
            </dd>
            <dl class="up_forms">
            <dt>商品名<span class="up_ess">必須</span></dt>
            <dd>
                <div class="form_item">
                <label>
                    <input type="text" id="category" name="fish_category_name" value="{{ old('fish_category_name', $fish_category_name) }}" placeholder="商品名を入れてください。（例：鯛）">
                    @if ($errors->has('fish_category_name'))
                        <span class="alert">
                            {{ $errors->first('fish_category_name') }}
                        </span>
                    @endif
                </label>
                </div>
            </dd>
            <dt>数量<span class="up_ess">必須</span></dt>
            <dd>
                <div class="form_item">
                    <label class="inline_flex text">
                        <input class="input_length_short" type="text" id="amount" name="amount"
                               value="{{ old('amount', $amount) }}"
                               placeholder=""><span>匹</span>
                    </label>
                    @if ($errors->has('amount'))
                        <span class="alert">
                            {{ $errors->first('amount') }}
                        </span>
                    @endif
                </div>
            </dd>
            <dt>サイズ</dt>
            <dd>
                <div class="form_item">
                    <label class="inline_flex text">
                        <input class="input_length_short" type="text" id="size_cm" name="size_cm"
                               value="{{ old('size_cm', $size_cm) }}"
                               placeholder=""><span>cm</span>
                        <input class="input_length_short" type="text" id="size_kg" name="size_kg"
                               value="{{ old('size_kg', $size_kg) }}"
                               placeholder=""><span>kg</span>
                    </label>
                    @if ($errors->has('size_cm'))
                        <span class="alert">
                            {{ $errors->first('size_cm') }}
                        </span>
                    @endif
                    @if ($errors->has('size_kg'))
                        <span class="alert">
                            {{ $errors->first('size_kg') }}
                        </span>
                    @endif
                </div>
            </dd>
            <dt>締め方<span class="up_ess">必須</span></dt>
            <dd>
                <div class="form_item">
                    <div class="form_select input_length_short">
                        <select name="how_to_tighten">
                            <option value="">-----</option>
                            <option value="血抜き" {{ old('how_to_tighten', $how_to_tighten) === '血抜き' ? 'selected' : '' }}>
                                血抜き
                            </option>
                            <option value="氷締め" {{ old('how_to_tighten', $how_to_tighten) === '氷締め' ? 'selected' : '' }}>
                                氷締め
                            </option>
                            <option value="神経締め" {{ old('how_to_tighten', $how_to_tighten) === '神経締め' ? 'selected' : '' }}>
                                神経締め
                            </option>
                            <option value="その他" {{ old('how_to_tighten', $how_to_tighten) === 'その他' ? 'selected' : '' }}>
                                その他
                            </option>
                            <option value="応相談" {{ old('how_to_tighten', $how_to_tighten) === '応相談' ? 'selected' : '' }}>
                                応相談
                            </option>
                        </select>
                    </div>
                    @if ($errors->has('how_to_tighten'))
                        <span class="alert">
                            {{ $errors->first('how_to_tighten') }}
                        </span>
                    @endif
                </div>
            </dd>
            <dt>商品詳細<span class="up_ess">必須</span></dt>
            <dd>
                <div class="form_detail">
                    @if ($errors->has('description'))
                        <span class="alert">
                    {{ $errors->first('description') }}
                </span>
                    @endif
                    <textarea name="description" placeholder="魚の詳細情報を入力してください。">{{ old('description', $description) }}</textarea>
                </div>
            </dd>

            <hr><br>

            <dt>魚が釣れた場所<span class="up_ess">必須</span></dt>
            <dd>
                <div class="form_area inline_flex">
                    <div class="form_select">
                        <select name="prefecture">
                            <option value="">都道府県</option>
                            @foreach (config('const.prefectures') as $_pref)
                                <option value="{{ $_pref }}"@if (old('prefecture', $prefecture) ==  $_pref) selected="selected" @endif>{{ $_pref }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label>
                        <input type="text" name="location" value="{{ old('location', $location) }}" placeholder="場所の名前を入れてください。（例：東京湾 久里浜沖）">
                    </label>
                </div>
                @if ($errors->has('prefecture'))
                    <span class="alert">
                        {{ $errors->first('prefecture') }}
                    </span>
                @endif
                @if ($errors->has('location'))
                    <span class="alert">
                        {{ $errors->first('location') }}
                    </span>
                @endif
            </dd>
            <dt>お届け可能地域<span class="up_ess">必須</span></dt>
            <dd>
                <div class="form_area">
                <label>
                    <input type="text" name="destination" value="{{ old('destination', $destination) }}" placeholder="地域の名前を入れてください。（例：東京都 杉並区付近、東京２３区内）">
                    @if ($errors->has('destination'))
                        <span class="alert">
                            {{ $errors->first('destination') }}
                        </span>
                    @endif
                </label>
                </div>
            </dd>

            <dt>配達方法<span class="up_ess">必須</span></dt>
            <dd>
                <div class="form_area">
                    <div class="form_select input_length_short">
                        <select name="delivery_method">
                            <option value="">-----</option>
                            <option value="手渡し" {{ old('delivery_method', $delivery_method) === '手渡し' ? 'selected' : '' }}>
                                手渡し
                            </option>
                            <option value="クール宅急便" {{ old('delivery_method', $delivery_method) === 'クール宅急便' ? 'selected' : '' }}>
                                クール宅急便
                            </option>
                        </select>
                    </div>
                    @if ($errors->has('delivery_method'))
                        <span class="alert">
                            {{ $errors->first('delivery_method') }}
                        </span>
                    @endif
                </div>
            </dd>

            <hr><br>

            <dt>金額<span class="up_ess">必須</span></dt>
            <dd>
                <div class="form_price">
                <label>
                    <input type="number" name="price" value="{{ old('price', $price) }}">
                </label>
                <p>円</p>
                <div class="clear"></div>
                @if ($errors->has('price'))
                    <span class="alert">
                        {{ $errors->first('price') }}
                    </span>
                @endif
                </div>
            </dd>
        </dl>
        <div class="up_btns">
        @if (!$is_edit)
        <input class="content_button" type="submit" name="" value="確認する">
        @else
        <input class="content_button" type="submit" name="" value="変更する">
        @endif
        <div class="clear"></div>
        </div>
    </form>
    </div>
    @include('parts/template_auth_links')
</div>
<div class="content_cover">
    <img class="loader" src="{{ url('/img/common/loading.gif') }}" alt="loading...">
</div>
@section('before_end')
<link rel="stylesheet" href="{{ url('/css/jquery-ui/jquery-ui.min.css') }}">
<script src="{{ url('/js/libs/jquery.min.js') }}"></script>
<script src="{{ url('/js/libs/jquery-ui.min.js') }}"></script>
<script type="text/javascript">
$(function(){
    let categories = [];
    $("#category").autocomplete({
        source: function( req, res ) {
            $.ajax({
                url: "{{ url('/fish/category') }}",
                method: "POST",
                dataType: "json",
                data: {
                    keyword: req.term,
                    _token: "{{ csrf_token() }}"
                },
                success: function( data ) {
                    categories = data;
                    res(data);
                },
                fail: function( jqXHR, textStatus, errorThrown ) {
                    console.log('error');
                }
            });
        },
        select: function (event, ui) {
            $("input[name='location']").focus();
        },
        autoFocus: true,
        delay: 500,
        minLength: 1
    });
});

let url = "{{ url('/mypage/fish/image/upload') }}";
let token = "{{ csrf_token() }}";
</script>
<script src="{{ url('/js/images.js') }}"></script>
@endsection
