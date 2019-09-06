@extends('layouts.app')

@section('title', '釣魚アッフロード 確認')
@section('page_id', 'page_uploadconfirm')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')

@include('parts/template_mypage_header', ['current' => 'fish_add'])
<div class="up_wrap">
    <div class="up_form">
        <ul class="up_form_slider sp">
        @foreach ($fish_data['photo'] as $_p)
            <li><div class="fit_image"><img src="{{ $_p }}"></div></li>
        @endforeach
        </ul>
        <div class="up_form_image">
            @foreach ($fish_data['photo'] as $_p)
            <div class="fit_image">
                <img src="{{ $_p }}">
            </div>
            @endforeach
        </div>
        <div class="upconf_tt">商品名<span class="up_ess">必須</span></div>
        <p>{{ $fish_data['fish_category_name'] }}</p>
        <div class="upconf_tt">魚が釣れた場所<span class="up_ess">必須</span></div>
        <p>{{ $fish_data['location'] }}</p>
        <div class="upconf_tt">金額<span class="up_ess">必須</span></div>
        <p>{{ $fish_data['price'] }}</p>
        <div class="upconf_tt">商品詳細<span class="up_ess">必須</span></div>
        <p>
            {!! nl2br(htmlspecialchars($fish_data['description'])) !!}
        </p>

        <form class="up_btns" method="POST" action="{{ url('/mypage/fish/complete') }}">
            <input class="content_button" name="" type="submit" value="出品する">
            <input class="content_button" name="" type="button" value="戻る" onClick="location.href='{{ url('/mypage/fish/add') }}'">
            <div class="clear"></div>
            @csrf
        </form>
    </div>
    </div>
</div>
@endsection