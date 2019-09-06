@extends('layouts.app')

@section('title', '釣魚編集')
@section('page_id', 'page_upload')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
@include('parts/template_mypage_header', ['current' => 'fish_add'])
@if (session('status'))
    <p class="content_success_box success">{{ session('status') }}</p>
@endif
@include('parts/template_fish_form', ['action_url' => url('/mypage/fish/'.$id.'/edit'), 'is_edit' => true])
@endsection
