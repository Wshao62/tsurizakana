@extends('layouts.app')

@section('title', 'オファーページ')
@section('page_id', 'page_requestdetail')
@section('css', 'offer.css')
@section('not_need_head_img', true)

@section('content')
<div  class="lower_bg">
    <div class="layout">
        <div class="title">
        <h2>オファー魚</h2>
        <p class="font_avenirnext">OFFER FISH</p>
        </div>
        @if (!empty(session('error')))
        <div class="content_alert_box">
        <p class="alert">{{ session('error') }}</p>
        </div>
        @endif
        <div class="rd_list">
        <div class="rd_table">
            <table>
            <colgroup>
                <col class="it_l">
                <col class="it_r">
            </colgroup>
            <tr>
                <th colspan="2"><p class="tdd_title">{{$fish_request['category_name']}}</p></th>
            </tr>
            <tr>
                <td><span><img class="location" src="/img/icon/icon_location.png"></span>エリア：</td><td>{{$buyer->getPublicAddress()}}</td>
            </tr>
            <tr>
                <td><span><img class="clock" src="/img/icon/icon_clock.png"></span>希望日：</td><td>{{ date('Y/m/d', strtotime($fish_request['request_date'])) }}</td>
            </tr>
            </table>
        </div>
        <div class="clear"></div>
        </div>
        <div class="rd_user">
        <h3>この商品をリクエスト<br class="sp">しているユーザー</h3>
        <div class="fit_image">
            <img id="profile_preview" src="{{ $buyer->photo->getProfile() }}">
        </div>
        <div>
            <p><a href="{{ url('/user',$buyer['id']) }}">{{$buyer['name']}}</a></p>
            <p>{{$buyer->getPublicAddress()}}</p>
            <div class="rde_cont">
            <a href="{{ url('user/'. $buyer['id']. '/grade/good') }}"><p class="rd_eval"><span><img src="/img/mypage/message_good.png"></span>良い：{{ number_format($buyer_rate['good']) }}</p></a>
            <a href="{{ url('user/'. $buyer['id']. '/grade/normal') }}"><p class="rd_eval"><span><img src="/img/mypage/message_medium.png"></span>普通：{{ number_format($buyer_rate['normal']) }}</p></a>
            <a href="{{ url('user/'. $buyer['id']. '/grade/bad') }}"><p class="rd_eval"><span><img src="/img/mypage/message_bad.png"></span>悪い：{{ number_format($buyer_rate['bad']) }}</p></a>
            </div>
        </div>
        </div>
        <form class="rd_form" action="{{url('/request/'.$fish_request['id'].'/offer/complete')}}" method="POST">
            @csrf
            <h3>あなたが出品している魚一覧</h3>
            <p>ユーザーに勧める魚を選択してください。</p>
            <ul>
                @foreach ($fish as $_f)
                <li>
                    <label class="rdc_label">
                        <input type="checkbox" name="fish_id[]" value="{{ $_f['id'] }}" @if (in_array($_f['id'], old('fish_id', []))) checked @endif>
                        <div class="rd_check">
                        <div class="fit_image">
                            <img src="{{ $_f['onePhoto']['file_name'] }}">
                        </div>
                        <div>
                            <p>{{ $_f['fish_category_name'] }}</p>
                            <p>¥{{ $_f['price']}}<span>（税込）</span></p>
                            <p><span><img class="location" src="/img/icon/icon_location.png"></span>エリア：{{ $_f['location'] }}</p>
                        </div>
                        <div class="rd_checked @if (!in_array($_f['id'], old('fish_id', [])))hide @endif">
                            <div>
                            <p>ユーザーに勧める</p>
                            </div>
                        </div>
                        </div>
                    </label>
                </li>
                @endforeach
            </ul>
            @if ($errors->has('fish_id'))
                <p class="alert">{{ $errors->first('fish_id') }}</p>
            @endif
            @if ($errors->has('fish_id.*'))
                <p class="alert">{{ $errors->first('fish_id.*') }}</p>
            @endif
            <h3>ユーザーへのメッセージ</h3>
            <p>メッセージの内容は、必要に応じて事務局で確認しています。</p>
            <input type="hidden" name="request_id" value="{{$fish_request['id']}}">
            <textarea name="message" placeholder="こちらにメッセージをご入力ください。" required>{{ old('message') }}</textarea>
            @if ($errors->has('message'))
                <p class="alert">{{ $errors->first('message') }}</p>
            @endif
            <input class="content_button" type="submit" value="送信">
        </form>
    </div>
</div>
@endsection