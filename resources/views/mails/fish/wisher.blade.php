@extends('mails.layouts.mail')

@section('content')
# ご出品の魚について購入希望を出している方がいます

以下から希望者を確認し、購入者を選択してください！
@component('mail::table')
    | | |
    |-|-|
    | 商品 | <img src="{{ $fish->onePhoto->file_name }}" width="100"> {{ $fish->fish_category_name }}( ￥{{ number_format($fish->price) }} ) |
    | 希望者 | <img src="{{ $wisher->photo->getProfile() }}" width="100">{{ $wisher->name }} |
@endcomponent

@component('mail::button', ['url' => url('/mypage/fish/'.$fish->id.'/wisher')])
購入希望者一覧へ
@endcomponent
@endsection