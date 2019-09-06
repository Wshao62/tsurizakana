@extends('mails.layouts.mail')

@section('content')
# ユーザから本人確認依頼が届いています。


{{ $user['name'] }}様から、本人確認依頼が届いています。<br>
管理画面からご確認ください。

@component('mail::button', ['url' => url('/admin/user/'.$user['id'].'/identification')])
本人確認へ
@endcomponent



@endsection
