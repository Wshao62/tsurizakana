@extends('layouts.app')

@section('title', '釣魚アップロード')
@section('page_id', 'page_upload')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')

@include('parts/template_mypage_header', ['current' => 'fish_add'])
@include('parts/template_fish_form', ['action_url' => url('/mypage/fish/confirm'), 'is_edit' => false])

@endsection
