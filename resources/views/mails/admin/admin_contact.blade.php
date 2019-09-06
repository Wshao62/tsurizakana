@extends('mails.layouts.mail')

@section('content')
# お問い合わせ


{{ $data['name'] }}様から、以下の内容でお問い合わせを受けております。<br>

@include('mails.parts.template_contact', $data)

@endsection
