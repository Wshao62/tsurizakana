@extends('mails.layouts.mail')

@section('content')
# 希望していた売魚の購入者があなたに決まりました。

以下の魚について購入が確定しました。<br>
この後は、マイページから魚の決済手続きを行なってください。<br>
決済を行うまではあなたの住所は販売者に通知されません。<br>
@component('mail::panel')
    {{ $fish->fish_category_name }}( ￥{{ number_format($fish->price) }} )<br>
    <img src="{{ $fish->onePhoto->file_name }}" width="200" style="margin:0 auto;">
@endcomponent

@component('mail::button', ['url' => url('/mypage/fish/'.$fish->id)])
    売魚詳細へ
@endcomponent
@endsection