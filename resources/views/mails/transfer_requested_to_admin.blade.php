@extends('mails.layouts.mail')

@section('content')
振込予定日：{{ $transfer_at_ja }}<br>
振込申請日：{{ $requested_at_ja }}<br>
ユーザーID：{{ $transfer_request->user_id }}<br>
振込申請番号：{{ $transfer_request->application_number }}<br>
ユーザー名：{{ $transfer_request->user->name }}<br>
実際の振込額：{{ number_format($transfer_request->transfer_price) }}円
@endsection
