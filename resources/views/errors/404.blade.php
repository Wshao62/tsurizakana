@extends('layouts.app')

@section('title', 'ページが見つかりません')
@section('page_id', 'page_404')
@section('not_need_head_img')

@section('content')
    <div class="layout">
      <div class="title">
        <h2>ページが見つかりません。</h2>
        <p class="font_avenirnext">NOT FOUND</p>
      </div>
      <div class="layout maintext">
        <p>
          指定されたページは表示できません。権限がないかURLが存在しません。
        </p>
        <a href="{{ url('/') }}" class="content_button">トップページへ</a>
      </div>
    </div>
@endsection