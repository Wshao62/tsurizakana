@extends('layouts.app')

@section('title', 'ブログ作成')
@section('page_id', 'page_add')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
@include('parts/template_mypage_header', ['current' => 'blog'])

    @if (session('status'))
        <div class="content_success_box">
            <p class="success">{{  session('status') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="content_alert_box">
            <p class="alert">{{  session('error') }}</p>
        </div>
    @endif
    @include('parts.template_blog_form', ['url' => url('mypage/blog/create')])
@endsection
