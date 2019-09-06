@extends('mails.layouts.mail')

@section('content')
# 以下の取引に未読メッセージがあります。<br>

@component('mail::panel')
    @foreach ($message as $_f)
        <a href="{{ url('/mypage/fish', $_f['fish_id']) }}">
            {{ App\Models\Message::fish($_f['fish_id'])->fish_category_name }}
            ( ￥{{ number_format(App\Models\Message::fish($_f['fish_id'])->price) }} )
        </a><br>
    @endforeach
@endcomponent

@endsection