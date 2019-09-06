@extends('layouts.app')

@section('title', '')
@section('page_id', 'page_uploadconfirm')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')

@include('parts/template_mypage_header', ['current' => 'fish_request'])

<div class="up_wrap">
    <div class="up_form">
        <div class="upconf_tt">魚名<span class="up_ess">必須</span></div>
        <p>{{ $fish_data['category_name'] }}</p>
        <div class="upconf_tt">希望日<span class="up_ess">必須</span></div>
        <p>{{ $fish_data['request_date'] }}</p>
        <form class="up_btns" method="POST" action="{{ url('/mypage/fish/request/add') }}">
            <input class="content_button" name="" type="submit" value="登録">
            <input class="content_button" name="" type="button" value="戻る" onClick="location.href='{{ url('/mypage/fish/request/add') }}'">
            <div class="clear"></div>
            @csrf
        </form>
    </div>
    </div>
</div>
@endsection