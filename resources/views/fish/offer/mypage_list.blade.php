@extends('layouts.app')

@section('title', 'オファー一覧')
@section('page_id', 'page_requestfish')
@section('css', 'request.css')
{{-- @section('not_need_head_img', true) --}}

@section('content')
<div class="layout">
    <div class="title">
    <h2>オファー魚一覧</h2>
    <p class="font_avenirnext">OFFER FISH LISTS</p>
    </div>
</div>
<div class="list_area">
    <div class="layout">
        @if (count($offers))
        <div class="pickup">
            <div class="pickup_inner">
                @foreach ($offers as $_off)
                <div class="pickup_card">
                    <a href="{{ url('/fish', $_off->fish_id) }}">
                    <p class="pickup_band">{{ $_off->offerUser->name }}が出品</p>
                    <div class="fit_image">
                        <img src="{{ $_off->fish->onePhoto->file_name }}" alt="{{ $_off->fish->fish_category_name}}">
                        @if(!$_off->fish->isPublish())
                            <div class="over_wrap"><p>売却済</p></div>
                        @endif
                    </div>
                    <div class="pickup_textarea @if(!$_off->fish->isPublish()) bg_lightgray @endif">
                        <p class="pickup_title_middle">{{ $_off->fish->fish_category_name}}</p>
                        <p class="pickup_price font_avenirnext">¥{{ number_format($_off->fish->price) }}<span class="pickup_tax">（税込）</span></p>
                        <p class="pickup_location"><span class="icon_before icon_before_location"></span>{{ $_off->fish->destination }}</p>
                        <p class="pickup_time font_avenirnext"><span class="icon_before icon_before_clock"></span>{{ $_off->fish->getFormatedCreatedAt('H:i:s') }}</p>
                    </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="pager font_avenirnext">
            {{ $offers->links('vendor.pagination.default') }}
            </div>
        </div>
        @else
        <div class="content_default_box">
            <p>オファーはありません。</p>
        </div>
        @endif
    </div>
</div>
@endsection