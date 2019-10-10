/**
 * This JS file applies only for message page.
 */
;
(function () {
    // Global class variables
    var $take       = ($messagesCount < 10) ? 0 : 10, // represents the number of messages to be displayed
        $chats      = $(".messanger"),
        $messenger  = $('.chat_box'),
        $message    = $('.message'),
        $photo      = $('.photo'),
        $msg_error  = $('.msg_error'),
        $photo_error= $('.photo_error'),
        $img_browse = $('.browse');

    /**
     * Do action when a message event is triggered.
     */
    window.Echo.channel('my-channel')
    .listen('MessageEvent', (response) => {
        if($authId != response.message.user_id && $fish_id == response.message.fish_id){
            sendPartner(response.user, response.photo, response.message);
            makeSeen();
        }
        // scrollMessagesDown();
    });

    /**
     * Scroll messages down to some height or bottom.
     */
    var scrollMessagesDown = function (height = 0) {
        var scrollTo = height || $messenger.prop('scrollHeight');
        $messenger.scrollTop(scrollTo);
    }

    /**
     * Append a new message to receiver.
     */
    var sendPartner = function (user, photo, response) {
        var element = '<div class="chat_cont">';
        element = element + '<div class="chat_partner">';
        element = element + '<div class="chpa_img"><img src="' + photo + '"></div>';
        element = element + '<div class="chpa_bll"><p>' + user.name + '</p>';
        if (response.message) {
            element = element + '<div class="chat_balloon"><p>' + nl2br(response.message) + '</p></div>';
        }
        if (response.img_url) {
            element = element + '<div class="chat_balloon chat_img"><img src="' + response.img_url + '"></div>';
        }
        element = element + '<p class="chat_time">' + timeParse(response.created_at) + '</p></div></div>';
        element = element + '<div class="clear"></div></div>';

        $messenger.prepend(element);
    }

    /**
     * Insert line breaks
     */
    var nl2br = function (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

    /**
     * Convert time format.
     */
    var timeParse = function (date) {
        var time = new Date(date);
        var hours =   time.getHours() < 10 ? "0" + time.getHours() : time.getHours();
        var minutes = time.getMinutes() < 10 ? "0" + time.getMinutes() : time.getMinutes();

        return hours + ":" + minutes;
    }

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // scrollMessagesDown();

        /**
         * Send message to backend and handle responses.
         */
        $(document).on('click', '.send_msg', function () {
            if($message.val().replace(/^[\s|　]+|[\s|　]+$/g,'') || $photo.val()) {
                $.ajax({
                    url: "/mypage/message/send",
                    method: "POST",
                    data: new FormData($chats[0]),
                    processData: false,
                    contentType: false,
                    async: false,
                    success: function () {
                       $message.val("");
                       $photo.val("");
                       $msg_error.hide();
                       $photo_error.hide();
                       $img_browse.find('.upload_desc').text("画像を添付する  (対応形式：png/gif/jpg ※1枚まで添付可能です。)");
                       loadMessages();
                    },
                    error: function (data) {
                       if(data.status === 401) {
                           location.reload();
                       }else {
                           var error = data.responseJSON.errors;
                           if (error.message) { $msg_error.html(error.message).show(); }
                           if (error.photo)   { $photo_error.html(error.photo).show(); }
                       }
                    }
                });
            }else {
                $msg_error.html("メッセージやアップロード画像は空にしないでください。").show();
            }
        });
    });


    /**
     * Display filename on change.
     */
    $photo.change(function () {
        var fileName = $(this).val().replace(/\\/g, '/').replace(/.*\//, '');
        $('.browse').find('.upload_desc').text(fileName);
    });

    /**
     * Load more messages when scroll to top.
     */
    $messenger.on('scroll', function () {
        if (!$messenger.scrollTop() && $take) {
            $take += 10;
            moreMessages();
        }
    });

    /**
     * Load more messages.
     */
    var moreMessages = function () {
        $.ajax({
            url: '/mypage/message/more',
            method: 'GET',
            data: {
                fish_id: $fish_id,
                take: $take
            }
        }).done(function (res) {
            var prevHeight = $messenger.prop('scrollHeight');
            $messenger.html(res.view);
            var newHeight = $messenger.prop('scrollHeight');
            // scrollMessagesDown(newHeight - prevHeight); // stop at the current height.
            if (res.messagesCount < $take) { // load no more messages.
                $take = 0;
            }
        });
    }

    /**
     * Reload messages.
     */
    var loadMessages = function() {
        $.ajax({
            url: '/mypage/message/fetch',
            method: 'GET',
            data: {
                fish_id: $fish_id,
                take: 10
            }
        }).done(function (res) {
            $messenger.html(res.view);
            $take = (res.messagesCount < 10) ? 0 : 10
        });
    }

    /**
     * Seen messages.
     */
    var makeSeen = function() {
        $.ajax({
            url: '/mypage/message/seen',
            method: 'POST',
            data: {
                fish_id: $fish_id
            }
        })
    }


}());
