@extends('mails.layouts.mail')

@section('content')
# リクエストにオファーがありました。

あなたの[{{ $request->category_name }}]のリクエストにオファーがありました。<br>
下記リンクよりオファーの詳細を確認してください。<br>
@component('mail::panel')
@component('mail::button', ['url' => url('/mypage/fish/request/'.$request->id.'/offer')])
オファーの一覧へ
@endcomponent

{!! nl2br(e($message)) !!}

---

@foreach ($fish as $_f)
【{{$_f->fish_category_name}}】については<a href="{{ url('/fish', $_f->id) }}">こちら</a><br>
@endforeach
<br>
@endcomponent



@endsection