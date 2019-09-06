@extends('mails.layouts.mail')

@section('content')
# ご出品の商品についてお支払いが確認できました。

以下のご出品の商品の支払いが確認できました。<br>
現在、「{{ $data->getStatus() }}」となっています、ご対応をお願いします。
@component('mail::table')
    | 配達待ち商品名 | 金額 |
    |-|-|
    | 【{{ $data['id'] }}】{{ $data['fish_category_name'] }} | {{ number_format($data['price']) }} |
@endcomponent

@component('mail::button', ['url' => url('/mypage/fish/'.$data['id'])])
取引詳細へ
@endcomponent
@endsection