@extends('layouts.app')

@section('title', 'オファーが完了しました。')
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
        <div class="content_success_box">
            <p class="success">オファーが完了しました。</p>
        </div>
        <a class="content_button" href="{{ url('/fish/request') }}">リクエスト魚一覧へ戻る</a>
    </div>
</div>
@endsection