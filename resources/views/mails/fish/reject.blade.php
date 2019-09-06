@extends('mails.layouts.mail')

@section('content')
# お取引が中止となりました。

以下の商品が取引中止となりました。<br>
問題、ご不明点がある場合は運営へお問い合わせくださいませ。
@component('mail::table')
    | | |
    |-|-|
    | 商品 | {{ $fish->fish_category_name }}( ￥{{ number_format($fish->price) }} ) |
    | 中止者 | <img src="{{ $user->photo->getProfile() }}" width="100">{{ $user->name }} |
    | 理由 | {!! nl2br(htmlspecialchars($reject->reason)) !!} |
@endcomponent

@endsection