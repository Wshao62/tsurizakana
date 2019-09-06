@extends('mails.layouts.mail')

@section('content')
# パスワードリセットするためのリンクを送付いたします。

本メールはご登録パスワードをリセットする
リンクを通知する為のメールです。<br>
パスワードをリセットする場合は下記リンクへアクセスして、手続きを進めてください。
@component('mail::button', ['url' => $reset_url])
パスワードをリセットする
@endcomponent

@endsection