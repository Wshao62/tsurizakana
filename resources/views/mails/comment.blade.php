@extends('mails.layouts.mail')

@section('content')
# あなたの売魚「{{ $fish->fish_category_name }}」に書き込みがありました。
詳しくは下記からご確認ください。
@component('mail::button', ['url' => route('fish.detail', $comment->fish_id)])
売魚詳細へ
@endcomponent

@endsection