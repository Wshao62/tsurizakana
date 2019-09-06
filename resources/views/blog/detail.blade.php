@extends('layouts.app')

@section('meta_description', mb_substr($blog->description, 0, 300))
@section('meta_img', $blog->onePhoto->file_name)
@section('title', $blog->title)
@section('page_id', 'page_blogdetail')
@section('css', 'blog.css')

@section('content')
    @include('parts/template_blog_header', ['need_introduction' => false, 'need_shop' => false])
    <div class="blog">
        <div class="blog_title">
            <h2>{{ $blog->title }}</h2>
            <p class="font_avenirnext">{{ $blog->getFormatedCreatedAt('Y-m-d') }}</p>
        </div>
        @if (!empty($blog->photos))
        @foreach ($blog->photos as $photo)
        <img src="{{ $photo->file_name}}" class="js_modal_open @if ($loop->first)blog_eyecatch @endif" alt="{{ $blog->title }}の写真{{ $loop->index }}">
        @endforeach
        @endif
        {!! nl2br($blog->description) !!}
    </div>

    @if (!empty($user->shop))
    <div class="shop_info">
      <p class="shpinf_p">店舗情報</p>
      <table>
        <tr>
          <th>
            <p>店舗名</p>
          </th>
          <td>
            <div>
              <p>{{ $user->shop->name }}</p>
            </div>
          </td>
        </tr>
        <tr>
          <th>
            <p>住所</p>
          </th>
          <td>
            <div>
              <p class="shop_adress">
                {{ $user->shop->zipcode }}<br>
                    {{ $user->shop->full_address }}
              </p>
              <a href="https://maps.google.co.jp/maps/search/{{ $user->shop->full_address }}" target="_blank">>Google mapで地図を見る</a>
            </div>
          </td>
        </tr>
      </table>
    </div>
    @endif

    <div class="button_wrap">
        @if (!empty($previous))
        <a href="{{ url('blog/'. $previous->id) }}" class="content_button_arrow content_button_back">前の記事へ</a>
        @endif
        @if (!empty($next))
        <a href="{{ url('blog/'. $next->id) }}" class="content_button_arrow content_button_next">次の記事へ</a>
        @endif
    </div>

</div>
<div class="modal">
    <div class="modal_layout">
        <div class="modal_inner">
            <button class="js_modal_close modal_close"></button>
            <img src="" class="modal_image">
        </div>
    </div>
</div>
@endsection
