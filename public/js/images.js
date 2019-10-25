// You must set variable "url" and "token" before read this Javascript
// example) let url = "https://tsurizakana-shoten.com/fish/image/upload";

let formData = new FormData(),
    $dropArea = $('.js_img_drop_area'),
    parentDiv = 'div.uppi_box',
    addFileBtn = '.js_add_img_btn',
    inputFile = 'input[name="photo[]"]',
    preview = '.preview',
    resetBtn = '.js_reset_file',
    submitBtn = 'input[name="submit_btn"]'
    dummyInputFile = 'input[name="dummy_file"]',
    inputPhotoId = 'input[name="photo_id[]"]',
    areaDeletePhoto = '#delete_photos';


$(function(){
    $(inputFile).prop('disabled', false);

    // 並び替え
    $('.uped_pic').sortable({
        axis: 'x',
        cursor: 'pointer',
        opacity: 0.8,
        forceHelperSize: true,
        helper: "clone",
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
        setImages(files);
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
    //////////////////////////////////////////////////////

    //画像追加ボタン押下時
    $(document).on('click', addFileBtn, function (e) {
        e.stopPropagation();

        $(inputFile).each(function (idx, elm) {
            if ($(elm).val() == "") {
                $(dummyInputFile).trigger('click');
                return false;
            }
        });
    });
    $(dummyInputFile).on('change', function(e) {
        e.stopPropagation();
        setImages($(this)[0].files);
        $(this).val(null);
        $(this).prop('files', null);
    });

    //画像のリセット
    $(resetBtn).on('click', function () {
        let parent = $(this).parents(parentDiv),
            target = parent.find(inputFile),
            photoId = parent.find(inputPhotoId);
        target.replaceWith(target = target.val('').clone(true));
        parent.find(preview).attr('src', '').addClass('hide');
        $(this).addClass('hide');

        //左に要素があるときは右に寄せる
        $(parent).before($(parentDiv));

        //登録済みの画像をリセットするときはphoto_idもリセット
        if(photoId.length != 0 && photoId.val() != "") {
            photoId.val('');
        }
    });
});

// functions ////////////////////////////////////////////////

// 画像アップロード
function setImages(files) {
    // fileが空の場合、無視する
    if (files === undefined || files === null) {
        return false;
    }
    for (var i = 0; i < files.length; i++) {
        let t = null;
        $(inputFile).each(function (idx, elm) {
            if ($(elm).val() == "") {
                t = elm;
                return false;
            }
        });

        if (t === null) {
            $(addFileBtn).parent().after($('<p>').addClass("alert content_alert_box img_error").text('アップロードできるファイルは'+$(inputFile).length+'件までです。'));
            return false;
        }
        $(t).val('doing');
        let parent = $(t).parents(parentDiv)
            file = files[i];

        $('.img_error').remove();
        let validate = ValidateFile(file);
        if (validate.result === false) {
            $(addFileBtn).parent().after($('<p>').addClass("alert content_alert_box img_error").text(validate.message));
            $(t).val('');
            continue;
        }

        // 画像をアップロード
        var formData = new FormData();
        formData.append('photo', file);
        formData.append('_token', token);

        showLoading();
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            timeout: 15000,
            async: true,
        })
        .done(function(data) {
            // アップロード OK
            //URL値をhiddenに挿入
            $(t).val(data.url);
            //プレビュー表示
            parent.find(preview).attr('src', data.url).removeClass('hide');
            //リセットボタン表示
            parent.find(resetBtn).removeClass('hide');
        })
        .fail(function(jqXHR, status, errorThrown){
            if (jqXHR.status == 422) {
                let data = $.parseJSON(jqXHR.responseText),
                    key = Object.keys(data.errors)[0];
                $(addFileBtn).parent().after($('<p>').addClass("alert content_alert_box img_error").html(data.errors[key].join('<br>')));
            } else {
                let msg = "エラーが発生しました。しばらく時間をおいてから再度お試しください。<br>それでも解決しない場合はお問い合わせください。";
                $(addFileBtn).parent().after($('<p>').addClass("alert content_alert_box img_error").html(msg));
            }
            $(t).val('');
        })
        .always(function(data){
            hideLoading();
        });
    }
}

function ValidateFile(file) {
    if (file.type.indexOf("image") < 0) {
        return {
            result: false,
            message: '写真には画像ファイルを指定してください。'
        };
    }
    else if (file.size >= 10240000) {

        return {
            result: false,
            message: '写真には10000 KB以下のファイルを指定してください。'
        };
    }

    return {
        result: true
    }
}

function showLoading(){
    $('.content_cover').show();
}

function hideLoading(){
    $('.content_cover').hide();
}

function doSubmit(form) {
    $(inputFile).filter(function() {
        return !this.value;
    }).prop('disabled', true);

    return true;
}
