@extends('layouts.app')

@section('content')
決済処理中にエラーが発生しました。<br>
決済実行後だった場合は対象の商品のステータスが変更されているか、支払い完了のメールが届いているか件名：「商品代金のお支払いありがとうございます。」をご確認ください。<br>
確認できなかった場合、運営へお問い合わせくださいませ。
@if (session('error'))
<p>{{ session('error') }}</p>
@endif
@endsection
