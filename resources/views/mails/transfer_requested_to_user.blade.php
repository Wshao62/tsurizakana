@extends('mails.layouts.mail')

@section('content')
以下の内容で振込申請を受け付けました。<br>
振込申請番号：{{ $transfer_request->application_number }}<br>
振込申請額：{{ number_format($transfer_request->price) }}円<br>
振込手数料：{{ number_format($transfer_request->fee) }}円<br>
実際の振込額：{{ number_format($transfer_request->transfer_price) }}円
@endsection
