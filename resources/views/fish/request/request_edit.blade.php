@extends('layouts.app')

@section('title', '釣魚アップロード')
@section('page_id', 'page_upload')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
@include('parts/template_mypage_header', ['current' => 'fish_request'])
    @if (session('status'))
        <div class="content_success_box">
            <p class="success">{{ session('status') }}</p>
        </div>
    @endif
    @include('parts/request/template_add_request', ['action_url' => url('/mypage/fish/request/'.$id.'/edit')])
@endsection