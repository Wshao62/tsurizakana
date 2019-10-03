@extends('layouts.app')

@section('title', $fish->fish_category_name.'の取引詳細')
@section('page_id', 'page_messagedetail')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
<div class="layout mp_cont">
    @if (session('status'))
        <div class="content_success_box">
            <p class="success">
                {{ session('status') }}
            </p>
        </div>
    @endif
    @if (session('error'))
        <div class="content_alert_box">
            <p class="alert">
                {{ session('error') }}
            </p>
        </div>
    @endif
    <div class="mede_fishname">
    <p>
        <span class="content_fish_tag tag_{{ $fish->status }}">{{ $fish->getStatus() }}</span>
        {{ $fish->fish_category_name }}
    </p>
    <div class="clear"></div>
    </div>
    <div class="fit_image">
    <img src="{{ $fish->onePhoto->file_name }}">
    </div>
    <table class="mess_table1">
        <tr>
            <th>釣れた場所</th><td>{{ $fish->location }}</td>
        </tr>
        <tr>
            <th>釣れた時間</th><td>{{ $fish->getFormatedCreatedAt('H:i:s') }}</td>
        </tr>
        <tr>
            <th>@if ($fish->isBuyer()) 出品者 @else 購入者 @endif</th>
            <td>
            <p>{{ $partner->name }}</p>
            <a href="{{ url('/user', $partner->id) }}"><img src="{{ url('/') }}/img/mypage/message_arrow.png">このユーザーのプロフィールを見る</a>
            <div class="clear"></div>
            <p class="mess_eval">
                <span><img src="{{ url('/') }}/img/mypage/message_good.png"></span>
                良い：@if ($fish->isBuyer()) {{ number_format($seller_rates['good']) }} @else {{ number_format($buyer_rates['good']) }} @endif
            </p>
            <p class="mess_eval">
                <span><img src="{{ url('/') }}/img/mypage/message_medium.png"></span>
                普通：@if ($fish->isBuyer()) {{ number_format($seller_rates['normal']) }} @else {{ number_format($buyer_rates['normal']) }} @endif

            </p>
            <p class="mess_eval">
                <span><img src="{{ url('/') }}/img/mypage/message_bad.png"></span>
                悪い：@if ($fish->isBuyer()) {{ number_format($seller_rates['bad']) }} @else {{ number_format($buyer_rates['bad']) }} @endif
            </p>
            <div class="clear"></div>
            </td>
        </tr>
    </table>
    <div class="clear"></div>
    <div class="message_cont">
        <div class="chat_box">
            @include('parts/message/template_message_form')
        </div>
        <form class="messanger">
            @if (!$fish->isFinish())
            <input type="hidden" name="fish_id" value="{{$fish->id}}">
            <input type="hidden" name="receiver_id" value="{{$partner->id}}">
            <textarea class="message" name="message" rows="4"></textarea>
            <label class="browse">
                <p><span><img src="{{ url('/') }}/img/mypage/image.png"></span><span class="upload_desc"> 画像を添付する  (対応形式：png/gif/jpg ※1枚まで添付可能です。)</span> </p>
                <input type="file" class="photo" id="photo" name="photo">
            </label>
            <span class="msg_error alert"></span>
            <span class="photo_error alert"></span>
            <input class="send_msg content_button" type="button" name="" value="メッセージを送る">
            @endif
            @if ($fish->status == \App\Models\Fish::STATUS_EVALUATE)
            <div class="deal_finished">
                <p>
                    取引完了しました。<br>
                    ユーザーの評価をお願いします。
                </p>
            </div>
            @endif
        </form>
    </div>

    @if ($fish->isOwner() && $fish->status == \App\Models\Fish::STATUS_DELIVERY)
    <div class="mesbtm_sell">
    <p>
        決済の完了を確認したので、<br>
        商品を配達しましょう！
    </p>
    <table>
        <tr>
        <th>お名前</th><td>{{ $partner->name }} 様</td>
        </tr>
        <tr>
        <th>お届け先</th><td>〒{{ $partner->zipcode }}<br>{{ $partner->public_address }}{{ $partner->private_address }}</td>
        </tr>
    </table>
    </div>
    @endif

    @if ($fish->isBuyer() && $fish->status <= \App\Models\Fish::STATUS_DELIVERY)
    <div class="mesbtm_buy">
        <p>合計 <span>¥{{ number_format($fish->price) }}</span>（送料込）</p>
        @if ($fish->status == \App\Models\Fish::STATUS_PAYING)
        <a href="{{ url('/fish/'.$fish['id'].'/buy') }}" class="content_button">購入画面に進む</a>
        @elseif ($fish->status == \App\Models\Fish::STATUS_DELIVERY)
        <a class="content_button mess_finish js_received_btn" href="">受け取り完了</a>
        <form id="receive_form" method="POST" action="{{ url('/mypage/fish/'.$fish->id.'/received') }}">
            @csrf
        </form>
        @endif
    </div>
    @endif

    @if ($fish->isEvaluate())
    @if (!$fish->isRated())
    <form action="{{ url('/mypage/fish/'.$fish->id.'/rate') }}" method="POST" id="rate_box">
    @csrf
    <p>取引評価</p>
    <div class="fit_image">
        <img src="{{ $partner->photo->getProfile() }}">
    </div>
    <p>{{ $partner->name }} 様</p>
    <p><a href="{{ url('/user/'. $partner->id. '/grade') }}">［　評価：{{ number_format($seller_rates['good']+$seller_rates['normal']+$seller_rates['bad'])}}　］</a></p>
    @if ($errors->count() > 0)
    <p class="content_alert_box alert">
        @foreach ($errors->all() as $_e)
        {{ $_e }}<br>
        @endforeach
    </p>
    @endif
    <div>
        <label><input name="rate" type="radio" value="{{ \App\Models\UserRating::GOOD }}" @if (old('rate', \App\Models\UserRating::GOOD) == \App\Models\UserRating::GOOD) checked @endif><span></span><p><img src="{{ url('/') }}/img/mypage/message_good.png">良い</p><div class="clear"></div></label>
        <label><input name="rate" type="radio" value="{{ \App\Models\UserRating::NORMAL }}"@if (old('rate') === (string) \App\Models\UserRating::NORMAL) checked @endif><span></span><p><img src="{{ url('/') }}/img/mypage/message_medium.png">普通</p><div class="clear"></div></label>
        <label><input name="rate" type="radio" value="{{ \App\Models\UserRating::BAD }}"@if (old('rate') == \App\Models\UserRating::BAD) checked @endif><span></span><p><img src="{{ url('/') }}/img/mypage/message_bad.png">悪い</p><div class="clear"></div></label>
        <div class="clear"></div>
    </div>
    <textarea name="rate_message">{{ old('rate_message') }}</textarea>
    <p>取引メッセージの内容は、必要に応じて事務局で確認しています。</p>
    <input class="content_button" type="submit" value="コメントを書く">
    </form>
    @else
    <div class="mesbtm_sell">
        <p>評価は完了しています。ありがとうございました！</p>
    </div>
    @endif
    @endif

    @if ($fish->canCancelTransaction())
    <div id="mess_stop">
        <p id="stop_dealing">×このユーザーとの取引を中止する</p>
        <div id="stop_dealing_box" @if ($errors->has('reason'))class="stop_dealing_open" @endif>
            @if ($errors->has('reason'))
            <span class="content_alert_box alert">
                {{ $errors->first('reason') }}
            </span>
            @endif
            <form action="{{ url('/mypage/fish/'.$fish->id.'/reject') }}" method="POST" onsubmit="return onReject(this);">
            @csrf
            <input type="text" name="reason" placeholder="中止理由を記入してください。" required>
            <input class="hover" type="submit" name="submit" value="送信">
            </form>
            <div class="clear"></div>
            <p>
            注意<br>
            ・一度中止された魚は再度購入する<br class="sp">ことができません。<br>
            ・正当な理由を記載してください。
            </p>
        </div>
    </div>
    @endif
</div>
@endsection

@section('before_end')
    <script type="text/javascript">
        var $messagesCount = "{{ $messagesCount }}";
            $fish_id  = "{{$fish->id}}",
            $partner_id = "{{$partner->id}}";
    </script>
    <script type="text/javascript">
        $(function() {
            $('.js_received_btn').on('click', function(event){
                event.preventDefault();
                if (!confirm('受け取り処理を行います。この処理一度行うとを処理を取り消したり、返品・返金などはできなくなります。よろしいですか？')) {
                    return false;
                }
                $('#receive_form').submit();
            });
        });
        function onReject(form) {
            if (!confirm("取引の中止は一度行うと取り消すことはできません。\n中止してよろしいですか？")) {
                return false;
            }
            return true;
        }
    </script>
    <script src="{{ url('js/message.js') }}"></script>
@endsection
