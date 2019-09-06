@extends('layouts.admin_app')

@section('page_name', 'ユーザー管理')
@section('page_id', 'page_messagedetail')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
<div class="layout">
    <div class="message_cont">
        <div class="row">
            <div class="col-md-2">
                <div class="list-chat">
                   @foreach ($user as $users)
                    <a href="/admin/user/message/fetch/{{ $id.'&'.$users['receiver_id'] }}">
                        @if(isset($receiver_id))
                        <div class="list-chats {{ $users['receiver_id'] == $receiver_id ? 'new' : '' }}">
                        @else
                        <div class="list-chats">
                        @endif
                            <div class="list-chats-image-wrapper">
                                <div class="list-chats-image">
                                    <img src="{{ !empty($users['user']['photo']) ? $users['user']['photo'] : url(config('const.profile_img_default_icon')) }}" width="40">
                                </div>
                            </div>
                            <div class="list-chats-text">
                                <span class="highlight">{{ $users['user']['name'] }}</span><br/>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-10">
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
                                            <p>{{ $msg['name'] }}</p>
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