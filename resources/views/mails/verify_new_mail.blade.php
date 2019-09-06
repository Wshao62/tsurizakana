@extends('mails.layouts.mail')

@section('content')
# {{config('app.name')}}にご登録のメールアドレス変更について


{{ $user->name }}様、本メールはご登録いただいていたメールアドレスから
こちらのメールアドレスに変更されることを確認するためのメールです。<br>

メールアドレスの変更を完了するために、下記リンクへアクセスしてください。
@component('mail::button', ['url' => url('/mypage/verify/email', $token)])
確認する
@endcomponent
@endsection
