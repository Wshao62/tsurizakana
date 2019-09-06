@extends('layouts.app')

@section('title', '評価一覧')
@section('page_id', 'page_grade')
@section('css', 'mypage.css')

@section('content')
    @include('parts/template_blog_header', ['need_introduction' => false, 'need_shop' => false])


      <p class="title_band">評価一覧</p>
      @if ($user->rate->count() > 0)
      <div class="tab">
        <div class="tab_baloon">
            <a class=" tab_baloon_button {{ ($dataInfo['current'] === 2 ? "current" : "") }}" href="/user/{{$user->id}}/grade">すべて</a>
            <a class=" tab_baloon_button {{ ($dataInfo['current'] === 1 ? "current" : "") }}" href="/user/{{$user->id}}/grade/good">良い</a>
            <a class=" tab_baloon_button {{ ($dataInfo['current'] === 0 ? "current" : "") }}" href="/user/{{$user->id}}/grade/normal">普通</a>
            <a class=" tab_baloon_button {{ ($dataInfo['current'] === -1 ? "current" : "") }}" href="/user/{{$user->id}}/grade/bad">悪い</a>
        </div>

        @if ($rateList->count() > 0)
        <div class="js_tab_baloon_inner tab_baloon_inner current">
            @foreach($rateList as $rate)
              <a class="grade" href={{url('/user/' . $rate->source_user_id )}}>
                <div>
                    <div class="grade_inner">
                      <div class="fit_image">
                          <img id="_preview" src="{{ $rate->user_photo }}">
                      </div>
                      <div class="grade_info">
                        <p class="grade_name">{{$rate->name}}</p>
                        <p class="grade_day">購入日時：<span class="font_avenirnext">{{$rate->rDate}}</span></p>
                        <div class="grade_value">
                          <p class="grade_value_icon grade_value_good {{ ($rate->rate === 1 ? "disp" : "no_disp") }}">良い</p>
                          <p class="grade_value_icon grade_value_normal {{ ($rate->rate === 0 ? "disp" : "no_disp") }}">普通</p>
                          <p class="grade_value_icon grade_value_bad {{ ($rate->rate === -1 ? "disp" : "no_disp") }}">悪い</p>
                        </div>
                        <p>【 コメント 】</p>
                        <p class="grade_comment">{!! nl2br(htmlspecialchars($rate->comment)) !!}</p>
                      </div>
                    </div>
                  </div>
              </a>
            @endforeach
        </div>
        @else
          <div class="content_default_box">
            この評価はありません。
          </div>
        @endif
      </div>
    </div>

    <div class="pager font_avenirnext">
        {{ $rateList->links('vendor.pagination.default') }}
    </div>
    @else
    <div class="content_default_box">
    まだ評価がありません。
    </div>
    @endif
@endsection