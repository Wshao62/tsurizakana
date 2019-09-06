<form method="POST" action="{{ $url }}" onsubmit="return doSubmit(this);" enctype="multipart/form-data">
    @csrf
    <dl>
        <dt>記事タイトル</dt>
        @if ($errors->has('title'))
        <p class="alert">{{ $errors->first('title')}}</p>
        @endif
        <dd>
        <input type="text" name="title" value="{{ old('title', $blog['title']) }}" placeholder="タイトルを入力してください">

        </dd>
        <dt>画像アップロード</dt>
        <dd>
            <div class="drop_area pc js_img_drop_area">
                <img src="{{ url('/') }}/img/mypage/image.png">
                <p>
                    こちらにファイルをドロップ<br>
                    写真は最大3枚までとなります。
                </p>
            </div>
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
                    @for ($idx = 0; $idx < 5; $idx++)
                    <div class="uppi_box">
                        @php ($old_photo = '')
                        @php ($old_photo_id = '')
                        @if (empty($blog['id']) && (!$errors->has('photo.'.$idx)))
                            {{-- 新規登録時のphoto初期値 --}}
                                @php ($old_photo = old('photo.'.$idx, $blog['photo'][$idx]))
                        @elseif (!empty($blog['id']))
                            {{-- 編集時のphoto初期値 --}}

                            @if (!$errors->has('photo_id.'.$idx))
                                {{-- 不正なIDが入力された場合は空とするが、エラーがない場合はそのまま表示 --}}
                                @php ($old_photo_id = old('photo_id.'.$idx, $blog['photo_id'][$idx]))

                                @if (!in_array(old('photo_id.'.$idx), $showed_ids) && $old_photo_id == $blog['photo_id'][$idx])
                                    @php ($old_photo = old('photo.'.$idx, $blog['photo'][$idx]))
                                @else
                                    @php ($old_photo = old('photo.'.$idx))
                                @endif

                            @endif

                            @php ($showed_ids[] = $old_photo_id)
                        @endif
                        <div class="fit_image">
                            <img src="{{ $old_photo }}" class="preview">
                            <input name="photo[]" value="{{ $old_photo }}" type="hidden">
                            @if (!empty($blog['id']))
                            <input type="hidden" name="photo_id[]" value="{{ $old_photo_id }}">
                            @endif
                        </div>
                        <input type="button" name="" value=" " class="js_reset_file @if (empty($old_photo))hide @endif">
                    </div>
                    @endfor
                    <div class="clear hide"></div>
                </div>
                <p>※最大アップロードサイズは5MBまでです。</p>
            </div>
        </dd>
        <dt>記事詳細</dt>
        <dd>
        <input type="button" class="js_btn_add_tag" value="見出し１" data-tag="h1">
        <input type="button" class="js_btn_add_tag" value="見出し２" data-tag="h2">
        <input type="button" class="js_btn_add_tag" value="見出し３" data-tag="h3">
        <input type="button" class="js_btn_add_tag" value="見出し４" data-tag="h4">
        <input type="button" class="js_btn_add_tag" value="見出し５" data-tag="h5">
        @if ($errors->has('description'))
            <p class="alert">{{ $errors->first('description')}}</p>
        @endif
        <textarea name="description" placeholder="記事内容を入力してください。">{!! old('description', $blog['description']) !!}</textarea>
        </dd>
        <dt>ステータス</dt>
        <dd>
        <label>
            <input type="radio" name="status" value="{{ App\Models\Blog::STATUS_PUBLISH }}" @if (old('status', $blog['status'])==App\Models\Blog::STATUS_PUBLISH) checked @endif>
            <span class="radio"></span>
            <p>{{ App\Models\Blog::STATUS_NAMES[App\Models\Blog::STATUS_PUBLISH] }}</p>
        </label>
        <label>
            <input type="radio" name="status" value="{{ App\Models\Blog::STATUS_PRIVATE }}" @if (old('status', $blog['status'])==App\Models\Blog::STATUS_PRIVATE) checked @endif>
            <span class="radio"></span>
            <p>{{ App\Models\Blog::STATUS_NAMES[App\Models\Blog::STATUS_PRIVATE] }}</p>
        </label>
        <div class="clear"></div>
        @if ($errors->has('status'))
            <p class="alert">{{ $errors->first('status')}}</p>
        @endif
        </dd>
    </dl>
    <input class="content_button" type="submit" name="" value="投稿する">
    @if (!empty($blog->id))
    <a id="delete_btn" >削除する</a>
    @endif
    </form>

    @if (!empty($blog->id))
    <form id="delete-form" action="{{ url('mypage/blog/'. $blog->id.'/delete') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @endif
</div>
<div class="content_cover">
    <img class="loader" src="{{ url('/img/common/loading.gif') }}" alt="loading...">
</div>

@section('before_end')
<script src="{{ url('/js/libs/jquery-ui.min.js') }}"></script>
<script>
    $(function(){
        $('.js_btn_add_tag').on('click', function(){
            var textarea = document.querySelector('textarea');

            var sentence = textarea.value;
            var len = sentence.length;
            var pos_start = textarea.selectionStart;
            var pos_end = textarea.selectionEnd;

            var before = sentence.substr(0, pos_start);
            var after = sentence.substr(pos_end, len);
            var middle = sentence.substr(pos_start, (pos_end - pos_start));
            if (!middle || middle.length === 0) middle = '【こちらにご入力ください】';

            var tag = $(this).data('tag');
            var first_word = "<" + tag + ">";
            var end_word = "</" + tag + ">";
            sentence = before + first_word + middle + end_word + after;

            textarea.value = sentence;
        });

        @if (!empty($blog->id))
        $('#delete_btn').on('click', function(event){
            event.preventDefault();
            if (confirm("記事を削除すると元には戻せません\n削除してよろしいですか？")) {
                document.getElementById('delete-form').submit();
            } else {
                return false;
            }
        });
        @endif
    });

    let url = "{{ url('/mypage/blog/image/upload') }}";
    let token = "{{ csrf_token() }}";
</script>
<script src="{{ url('/js/images.js') }}"></script>
@endsection