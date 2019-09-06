@extends('mails.layouts.mail')

@section('content')
# 釣魚商店がリリースされました。

以下のURLからプロフィールのご登録をお願いいたします。
ご登録が完了しますと、釣魚の取引が可能となります。

@component('mail::button', ['url' => url('/register/profile/'.$token.'/step/1')])
プロフィール登録へ
@endcomponent

@endsection