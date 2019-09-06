@extends('layouts.app')

@section('title', 'ブログ管理')
@section('page_id', 'page_blog')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
@include('parts/template_mypage_header', ['current' => 'blog'])

@if (session('error'))
    <div class="content_alert_box">
        <p class="alert">{{ session('error') }}</p>
    </div>
@endif
@if (session('status'))
<div class="content_success_box">
    <p class="success">{{ session('status') }}</p>
</div>
@endif

<a class="content_button blogpage_btn" href="{{ url('mypage/blog/add') }}">記事を投稿する</a>
<div class="clear"></div>
@if ($blogs->count() !== 0)
<table class="sp">
    <tr>
        <th colspan="3">ブログ一覧</th>
    </tr>
    @foreach ($blogs as $blog)
    <tr>
        <td colspan="2" class="b_title"><a href="{{ url('mypage/blog/'. $blog->id) . '/edit' }}">{{ $blog->title }}</a></td>
    </tr>
    <tr>
        <td class="b_date">{{ $blog->getFormatedCreatedAt() }}</td>
        <td class="b_stt">{{ $blog->getStatus()}}</td>
    </tr>
    @endforeach

</table>
<table class="pc">
    <tr>
        <th class="b_title">タイトル</th>
        <th class="b_date">公開日時</th>
        <th>状態</th>
    </tr>
    @foreach ($blogs as $blog)
    <tr>
        <td>
            <a href="{{ url('mypage/blog/'. $blog->id) . '/edit' }}">{{ $blog->title }}</a>
        </td>
        <td>{{ $blog->getFormatedCreatedAt() }}</td>
        <td>{{ $blog->getStatus()}}</td>
    </tr>
    @endforeach

</table>
</div>
<div class="pager font_avenirnext">
    {{ $blogs->links('vendor.pagination.default') }}
</div>


@else
<div class="content_default_box">
    <p>ブログはまだありません。</p>
</div>
@endif
</div>

@endsection
