@extends('mails.layouts.mail')

@section('content')
# ユーザから営業許可証確認依頼が届いています。


{{ $user['name'] }}様から、営業許可証確認依頼が届いています。<br>
管理画面からご確認ください。

@component('mail::button', ['url' => url('/admin/user/'.$user['id'].'/business-license')])
営業許可証確認確認へ
@endcomponent



@endsection
