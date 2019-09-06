$(document).ready(function () {
    // Global class variables
    var $notificationsWrapper   = $('.dropdown-body');
    var $notificationsToggle    = $('.badge');
    var $notificationsCountElem = $('.count');
    var $notificationsCount     = parseInt($notificationsCountElem.text());

    if ($notificationsCount <= 0) {
        $notificationsToggle.hide();
    }

    /**
     * Do action when a message event is triggered.
     */
    window.Echo.channel('my-channel')
        .listen('MessageEvent', (response) => {
            if(response.message.receiver_id == $authId && (typeof $fish_id != "undefined" ? (response.message.fish_id != $fish_id) : true)){
                var $newNotificationHtml = `
                    <a href="/mypage/fish/`+response.message.fish_id+`">
                        <div class="notification new">
                            <div class="notification-image-wrapper">
                                <div class="notification-image">
                                    <img src="`+response.photo+`" width="32">
                                </div>
                            </div>
                            <div class="notification-text">
                                <span class="highlight">`+response.user.name+`</span>さんからメッセージが届いています。<br/>
                                <p>たった今</p>
                            </div>
                        </div>
                    </a>
                `;
                $notificationsWrapper.prepend($newNotificationHtml);
                $notificationsCount += 1;
                $notificationsToggle.text($notificationsCount);
                $notificationsCountElem.text($notificationsCount);
                $notificationsToggle.show();
                $notificationsCountElem.show();
            }
        });

    /**
     * Mark all as read
     */
    $('.btn-mark').on('click', function () {
        $.ajax({
            url: '/mypage/message/mark',
            method: 'GET',
        }).done(function () {
             $notificationsCount = 0;
             $notificationsWrapper.empty();
             $notificationsToggle.hide();
             $notificationsCountElem.text(0);
        });
    });

});