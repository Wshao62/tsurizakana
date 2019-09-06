@extends('mails.layouts.mail')

@section('content')
@if (empty($message))
# 本人確認が完了しました
本人確認書類の提出ありがとうございました。<br>
管理者が確認し、承認したことによりあなたの本人確認が完了いたしました。

これにて本サービスにて全てのコンテンツを利用いただくことが可能となりました。<br>
引き続き、{{config('app.name')}}をよろしくお願いいたします。
@component('mail::button', ['url' => url('/')])
釣魚商店へ
@endcomponent
@else
# 本人確認は拒否されました
提出された本人確認書類は拒否されました。<br>
以下の理由を確認し、再度全書類の提出をお願いいたします。
@component('mail::panel')
    {!! nl2br($message) !!}
@endcomponent

@component('mail::button', ['url' => url('/identification')])
本人確認書類の提出へ
@endcomponent
@endif

@endsection