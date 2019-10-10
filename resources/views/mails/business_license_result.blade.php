@extends('mails.layouts.mail')

@section('content')
@if (empty($message))
# 営業許可証確認が完了しました
営業許可証書類の提出ありがとうございました。<br>
管理者が確認し、承認したことによりあなたの営業許可証確認が完了いたしました。

これにて本サービスにて全てのコンテンツを利用いただくことが可能となりました。<br>
引き続き、{{config('app.name')}}をよろしくお願いいたします。
@component('mail::button', ['url' => url('/')])
釣魚商店へ
@endcomponent
@else
# 営業許可証確認は拒否されました
提出された営業許可証書類は拒否されました。<br>
以下の理由を確認し、再度全書類の提出をお願いいたします。
@component('mail::panel')
    {!! nl2br($message) !!}
@endcomponent

@component('mail::button', ['url' => url('/business-license')])
営業許可証書類の提出へ
@endcomponent
@endif

@endsection
