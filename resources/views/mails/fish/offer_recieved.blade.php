@extends('mails.layouts.mail')

@section('content')
# あなたが出したオファーにより、商品が売れました

@component('mail::table')
    | | |
    |-|-|
    | 商品 | {{ $fish->fish_category_name }}( ￥{{ number_format($fish->price) }} ) |
    | 購入者 | <img src="{{ $user->photo->getProfile() }}" width="100">{{ $user->name }} |
@endcomponent


@component('mail::button', ['url' => url('/mypage/fish/'.$fish->id)])
    取引詳細画面へ
@endcomponent
@endsection