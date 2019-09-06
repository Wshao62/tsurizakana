@extends('mails.layouts.mail')

@section('content')
# お問い合わせありがとうございます。


{{ $data['name'] }}様から、以下の内容でお問い合わせを受け付けました。<br>
後ほど、弊社担当者からご返信させていただきます。<br>

@include('mails.parts.template_contact', $data)

@endsection
