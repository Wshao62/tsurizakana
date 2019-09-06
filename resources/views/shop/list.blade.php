@extends('layouts.app')

@section('title', 'お店一覧')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」に登録されているお店の一覧です。')
@section('page_id', 'page_shop')
@section('css', 'shop.css')
@section('not_need_header_img', true)

@section('content')
<div class="layout">
    <div class="title">
        <h2>お店一覧</h2>
        <p class="font_avenirnext">SHOP LIST</p>
    </div>
    <div class="shopli_head">
      <p class="shop_num">店舗は<span class="font_avenirnext">{{ $shop->total() }}</span>件あります</p>
      <form class="filter_shop" action="" method="post">
        {{-- <div class="area_filter">
          <p>エリアで絞り込む</p>
          <label>
            <select class="" name="">
              <option value="">東京</option>
              <option value="">大阪</option>
              <option value="">名古屋</option>
              <option value="">札幌</option>
            </select>
          </label>
        </div>
        <div class="shop_sort">
          <p>表示並び替え</p>
          <label>
            <select class="" name="">
              <option value="">並び替え</option>
            </select>
          </label>
        </div> --}}
      </form>
    </div>
    @php ($from_count = $shop->currentPage() == 1 ? 1 : ($shop->currentPage()-1) * $shop->perPage() + 1)
    @php ($to_count = ($shop->currentPage()-1) * $shop->perPage() + $shop->count())
    @if ($shop->count())
    <p class="displayed_shop">(全{{ $shop->total() }}件中) {{ $from_count }}～{{ $to_count }}件表示</p>
    @endif
    <div class="shop_lists" id="list">
    @if ($shop->count())
      @foreach ($shop as $_s)
      <a class="shop_list" href="{{ url('/user/'.$_s->user->id)}}">
        <div class="fit_image">
          <img src="{{ $_s->user->photo->getProfile() }}">
        </div>
        <div class="shopli_text">
          <p class="shop_name">{{ $_s->name }}</p>
          <p class="shop_area"><span><img src="{{ url('/') }}/img/icon/icon_location.png"></span>{{ $_s->full_address }}</p>
        </div>
      </a>
      @endforeach
      @else
        <div class="content_default_box">
            <p>お店の登録はありません。</p>
        </div>
      @endif
    </div>
    <div class="pager font_avenirnext">
        {{ $shop->fragment('list')->appends(request()->query())->links('vendor.pagination.default') }}
    </div>
</div>

@endsection
