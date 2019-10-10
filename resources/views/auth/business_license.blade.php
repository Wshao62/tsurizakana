@extends('layouts.app')

@section('title', '営業許可証')
@section('page_id', 'page_identification')
@section('css', 'identification.css')

@section('content')
<div class="layout">
    <div class="title">
    <h2>営業許可証</h2>
    <p class="font_avenirnext">BUSINESS LICENSE</p>
    </div>
    <p class="updoc_desc">
    アップロードする書類を選択してください。<br>
    氏名、住所が、<br class="sp">釣魚商店アカウントにご登録いただいた<br class="sp">内容と<br class="pc">一致していることを確認してください。
    </p>
    <form method="POST" action="{{ url('/business-license') }}" onsubmit="return doSubmit(this);" enctype="multipart/form-data">
        @csrf
        <div class="updoc_box">
        @if ($errors->count() > 0)
        <p class="content_alert_box alert">
            @foreach ($errors->all() as $_e)
            {{ $_e }}<br>
            @endforeach
        </p>
        @endif
        <p class="upbx_medium upmed1">営業許可証書類<span>必須</span></p>
        <div class="clear"></div>
        <div class="drop_area pc">
            <img src="{{url('/')}}/img/mypage/image.png">
            <p>
            こちらにファイルを１つずつドロップ
            </p>
        </div>

        <div class="form_pic">
            <label for="file_path1">
            <input id="fake_box1" type="text" name="dummy1" value="" class="js_select_file" placeholder="画像ファイルを選択" readonly>
            </label>
            <label for="file_path1">
            <a href="" id="select_btn1" class="js_select_file">選択</a>
            <input id="file_path1" type="file" name="file_path1" value="" accept="image/*" multiple class="hide">
            </label>
            <div class="clear"></div>
            <label>

            <input id="fake_box2" type="text" name="dummy2" value="" class="js_select_file" placeholder="画像ファイルを選択" readonly>
            </label>
            <label for="file_path2">
            <a href="" id="select_btn2" class="js_select_file">選択</a>
            <input id="file_path2" type="file" name="file_path2" value="" accept="image/*" class="hide">
            </label>
            <div class="clear"></div>
        </div>
        <p class="upbx_medium">書類をアップロードする前に、以下の内容をご確認ください。</p>
        <ul class="updoc_notes">
            <li>・アップロード合計サイズが10MBを超えないようにしてください。</li>
            <li>・書類に記載されている氏名、住所が釣魚商店アカウントに登録いただいているものと<br class="pc">一致していること。</li>
            <li>・書類は表面だけでなく、住所変更の記載がない場合でも裏面もアップロードしてください。</li>
            <li>・JPG、GIF、PNGなどの画像ファイルであること。</li>
            <li>・最新の内容であり、書類の情報がはっきりと読み取れる状態であること。</li>
        </ul>
        <input type="submit" class="docup_btn content_button" name="" value="書類のアップロード">
    </form>
    </div>
</div>
@endsection

@section('before_end')
<script>
    let $dropArea = $(".drop_area");

    $(function() {
        $('.js_select_file').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();

            let target = "#file_path" + $(this).attr('id').slice(-1);
            $(target).click();
            return false;
        });

        // ドラッグ&ドロップ ////////////////////////////////////
        $dropArea.on('dragenter', function (e) {
            e.stopPropagation();
            e.preventDefault();
            changeCss(true);
        });
        $dropArea.on('dragover', function (e) {
            e.stopPropagation();
            e.preventDefault();
            changeCss(true);
        });
        $dropArea.on('drop', function (e) {
            changeCss(false);
            e.preventDefault();

            var files = e.originalEvent.dataTransfer.files;
            setImage(files);
        });
        $(document).on('dragenter', function (e) {
            e.stopPropagation();
            e.preventDefault();
        });
        $(document).on('dragover', function (e) {
            e.stopPropagation();
            e.preventDefault();
            changeCss(false);
        });
        $(document).on('drop', function (e) {
            e.stopPropagation();
            e.preventDefault();
        });
        function changeCss(is_on = false) {
            if (is_on) {
                $dropArea.css('border', '1px dotted #000');
                $dropArea.css('background-color', '#ccc');
            } else {
                $dropArea.css('border', '1px dotted #383838');
                $dropArea.css('background-color', '#f5f5f5');
            }
        }
        function setImage(files) {
            let inputFile = 'input:not(.notuse)[type="file"][name^="file_path"]',
                emptyFileCnt = $(inputFile).length,
                $target = "";
            $(inputFile).each(function (idx, elm) {
                if ($(elm).val() == "") {
                    $target = $(elm);
                    return false;
                }
            });
            if ($target === "") {
                alert("アップロードできるファイルは2つまでです。")
                return false;
            }
            if (files.length > 1) {
                alert("ファイルは1つずつドラッグしてください。");
                return false;
            }

            $target.prop('files', files);
        }

        $('input[name^="file_path"]').on('change', function () {
            let value = "",
                {{-- $dummyText = $("input[name^='dummy']"), --}}
                targetText = "input[name='dummy"+$(this).attr('id').slice(-1)+"']",
                files = $(this).prop('files');

                $(targetText).prop('readonly', false);
                if (files.length > 0) {
                    $(targetText).val(files[0].name);
                } else {
                    $(targetText).val("");
                }
                $(targetText).prop('readonly', true);
        });
        //////////////////////////////////////////////////////
    });

    function doSubmit(form) {
        if (!confirm('この内容で送信します、よろしいですか？')) {
            return false;
        }
        return true;
    }
</script>
@endsection
