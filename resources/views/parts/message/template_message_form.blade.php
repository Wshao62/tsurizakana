
@foreach ($message as $day => $chats)
    <p class="chat_date">{{ $day }}</p>
    @foreach ($chats as $msg)
    <div class="chat_cont">
            @if((Auth::user()->id) == $msg['user_id'])
            <div class="chat_me">
                @if (!empty($msg['img_url']))
                <div class="chat_balloon chat_img">
                    <img src="{{ $msg['img_url'] }}">
                </div>
                @endif
                @if (!empty($msg['message']))
                <div class="chat_balloon">
                    <p>{!! nl2br(e($msg['message'])) !!}</p>
                </div>
                @endif
                <p class="chat_time">{{ date('h:i',strtotime($msg['created_at']['date'])) }}</p>
            </div>
            @else
            <div class="chat_partner">
                <div class="chpa_img">
                    <img src="{{ $msg['user']['photo'] }}">
                </div>
                <div class="chpa_bll">
                    <p>{{ $msg['user']['name'] }}</p>
                    @if (!empty($msg['img_url']))
                    <div class="chat_balloon chat_img">
                        <img src="{{ $msg['img_url'] }}">
                    </div>
                    @endif
                    @if (!empty($msg['message']))
                    <div class="chat_balloon">
                        <p>{!! nl2br(e($msg['message'])) !!} </p>
                    </div>
                    @endif
                    <p class="chat_time">{{ date('h:i',strtotime($msg['created_at']['date'])) }}</p>
                </div>
            </div>
            @endif
            <div class="clear"></div>
        </div>
    @endforeach
@endforeach