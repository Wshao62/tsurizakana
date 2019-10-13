@extends('layouts.app')

@section('title', '釣魚アップロード 完了')
@section('page_id', 'page_uploadcompleted')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')

@include('parts/template_mypage_header', ['current' => 'fish_add'])
<p>
    釣魚の出品が完了しました。<br>
    購入されるのを待ちましょう！
</p>
<a class="content_button" href="{{ url('/fish', $fish_data['id']) }}">売魚詳細へ</a>
</div>
@endsection
