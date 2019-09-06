@extends('layouts.app')

@section('title', '')
@section('page_id', 'page_uploadcompleted')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')

@include('parts/template_mypage_header', ['current' => 'fish_request'])

<div class="content_success_box">
    <p class="success">登録しました</p>
</div>
    <a class="content_button" href="{{ url('/mypage/fish/request') }}">リクエスト魚一覧</a>
</div>
@endsection