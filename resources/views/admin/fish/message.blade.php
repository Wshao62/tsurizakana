@extends('layouts.admin_app')

@section('page_name', 'メッセージ一覧')
@section('page_id', 'page_messagedetail')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
<div class="layout">
    <div class="message_cont">
        <div class="row">
            <div class="col-md-10" style="margin-left: 10%;">
                <div class="row" style="font-size: 1.4rem;">
                    <div class="col-sm-6 user-name">
                        <p style="font-weight: 700;">販売者:</p>
                        {{$user_name}}
                    </div>
                    <div class="col-sm-6 receiver-name" style="text-align: right;">
                        <p style="font-weight: 700;">購入者:</p>
                        {{$receiver_name}}
                    </div>
                </div>
                <div class="chat_box">
                    @if(isset($message))
                        @foreach ($message as $day => $chats)
                            <p class="chat_date">{{ $day }}</p>
                            @foreach ($chats as $msg)
                            <div class="chat_cont">
                                    @if($id == $msg['user_id'])
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
                                        <p class="chat_time">{{ date('h:i',strtotime($msg['created_at'])) }}</p>
                                    </div>
                                    @else
                                    <div class="chat_partner">
                                        <div class="chpa_img">
                                            <img src="">
                                        </div>
                                        <div class="chpa_bll">
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
                                            <p class="chat_time">{{ date('h:i',strtotime($msg['created_at'])) }}</p>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="clear"></div>
                                </div>
                            @endforeach
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection