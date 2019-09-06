@extends('mails.layouts.mail')

@section('content')
# ご注文の商品代金のお支払いありがとうございました。

以下のご出品の商品のお支払いが確認できました。<br>
※ご請求はこの商品の受け取り後となります。<br>
<br>
この後は出品者の{{$data->seller->name}}さんの配達を待ちましょう。
@component('mail::table')
    | お支払い商品名 | お支払い金額 |
    |-|-|
    | 【{{ $data['id'] }}】{{ $data['fish_category_name'] }} | {{ number_format($data['price']) }} |
@endcomponent

@component('mail::button', ['url' => url('/mypage/fish/'.$data['id'])])
取引詳細へ
@endcomponent

@endsection