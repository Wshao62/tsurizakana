@extends('layouts.app')

@section('title', $user->name.'のブログ一覧')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」に登録している'.$user->name.'さんのプロフィールページです。'.$user->name.'運営しているブログ記事の詳細を閲覧する事が出来ます。')
@section('page_id', 'page_bloglist')
@section('css', 'blog.css')

@section('content')
@include('parts/template_blog_header', ['need_introduction' => true, 'need_shop' => true])
@if (session('status'))
    <div class="content_success_box">
        <p class="success">{{  session('status') }}</p>
    </div>
@endif
@if (!empty($blogs->total()))
    @foreach ($blogs as $blog)
    <div class="user_post">
        <div class="blog">
            <div class="blog_title">
            <h2>{{ $blog->title }}</h2>
            <p class="font_avenirnext">{{ $blog->getFormatedCreatedAt('Y/m/d') }}</p>
            </div>
            <img src="{{ $blog->onePhoto->file_name }}" class="js_modal_open blog_eyecatch" alt="">
            <p>{{ $blog->getExcerpt() }}</p>
        </div>
        <a href="{{ url('blog', $blog->id) }}" class="content_button_arrow">続きを読む</a>
        </div>
    @endforeach
    </div>
    <div class="pager font_avenirnext">
        {{ $blogs->links('vendor.pagination.default') }}
    </div>
    <div class="modal">
        <div class="modal_layout">
            <div class="modal_inner">
                <button class="js_modal_close modal_close"></button>
                <img src="" class="modal_image">
            </div>
        </div>
    </div>
@else
    <div class="content_default_box"><p>ブログはまだありません。</p></div>
    </div>
@endif
@endsection
