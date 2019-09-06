@extends('layouts.app')

@section('title', $title)
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」の売魚一覧では出品されている魚を閲覧できます。商品画像・商品名・値段・釣れた場所が表示されておりご希望の魚を購入できます。')
@section('page_id', 'page_fish')
@section('css', 'fish.css')

@section('content')
<div class="layout">
    <div class="title">
        <h2>{{ $title }}</h2>
        <p class="font_avenirnext">FISH LISTS</p>
    </div>
</div>

<div class="list_area">
    <form id="search_form" method="GET" action="#list">
        <div class="layout">
            @if ($errors->count())
            <div class="content_alert_box">
                <p class="alert">不正な検索パラメータです、再度検索してください。</p>
            </div>
            @endif
            <div class="search_area">
                <label>
                    <p class="icon_before icon_before_location">キーワード</p>
                    <input type="text" name="keyword" value="{{ $attributes['keyword'] }}" class="search_keyword" placeholder="キーワードを入力してください「真鯛、タラ」">
                </label>
                <label>
                <p class="icon_before icon_before_location">エリア</p>
                <input type="text" name="area" value="{{ $attributes['area'] }}" class="search_keyword" placeholder="エリアを入力してください「大田区、光町」">
                </label>
            </div>
            <div class="">
            @if (!empty($user))
                <input type="hidden" name="user_id" value="{{$user->id}}">
            @endif
            @if (!empty($category))
                <input type="hidden" name="category_id" value="{{$category->id}}">
            @endif
            </div>
            <button type="submit" class="content_button search_submit">条件を変更して検索</button>
        </div>
        <div class="list_area_top layout">
                <div id="list" class="list_area_narrow">
                    <p class="list_area_result">商品は<span class="font_avenirnext">{{ $fish->total() }}</span>件あります</p>
                    <div class="list_area_sort">
                        <div class="list_area_sort_area">
                            <p>件数</p>
                            <label>
                            <select name="limit" class="font_avenirnext">
                                <option value="20" @if ($attributes['limit'] == 20) selected @endif>20</option>
                                <option value="40" @if ($attributes['limit'] == 40) selected @endif>40</option>
                            </select>
                            </label>
                        </div>
                        <div class="list_area_sort_area">
                            <p>表示並び替え</p>
                            <label>
                            <select name="order">
                                <option value="new" @if ($attributes['order'] == 'new') selected @endif>新着順</option>
                                <option value="low_price" @if ($attributes['order'] == 'low_price') selected @endif>価格が安い順</option>
                                <option value="heigh_price" @if ($attributes['order'] == 'heigh_price') selected @endif>価格が高い順</option>
                                <option value="name" @if ($attributes['order'] == 'name') selected @endif>名前順</option>
                            </select>
                            </label>
                        </div>
                        <div>
                            <label><input type="checkbox" name="is_open" value="1" @if ($attributes['is_open']) checked @endif>販売中の商品のみ表示</label>
                        </div>
                    </div>
                </div>

                <div class="list_area_display">
                    <p>({{ $fish->count() }}件表示)</p>
                </div>
        </div>
    </form>

    <div class="list_area_bottom layout">
    <div class="pickup">
        <div class="pickup_inner">
            @if ($fish->count())
                @foreach ($fish as $_f)
                <div class="pickup_card">
                    <a href="{{ url('fish',$_f['id']) }}">
                    <div class="fit_image"><img src="{{ $_f->onePhoto['file_name'] }}" alt="{{ $_f['fish_category_name'] }}"></div>
                    <div class="pickup_textarea @if (!$_f->isPublish()) bg_lightgray @endif">
                        <p class="pickup_title_middle">{{ $_f['fish_category_name'] }}</p>
                        <p class="pickup_price font_avenirnext">¥{{ number_format($_f['price']) }}<span class="pickup_tax">（税込）</span></p>
                        <span class="content_fish_tag @if ($_f->isPublish()) tag_1 @else tag_99 @endif">{{ $_f->getPublicStatus() }}</span>
                        <p class="pickup_location"><span class="icon_before icon_before_location"></span>{{ $_f['destination'] }}</p>
                        <p class="pickup_time font_avenirnext"><span class="icon_before icon_before_clock"></span>{{ $_f->getFormatedCreatedAt() }}</p>
                    </div>
                    </a>
                </div>
                @endforeach
            @else
            <div class="content_default_box">
                <p>売魚の登録はありません。</p>
            </div>
            @endif
        </div>
        <div class="pager font_avenirnext">
            {{ $fish->fragment('list')->appends(request()->query())->links('vendor.pagination.default') }}
        </div>
    </div>
    </div>
</div>
@endsection

@section('before_end')
<script>
$(function(){
    $('select[name="limit"], select[name="order"], input[name="is_open"]').on('change', function (){
        $('#search_form').submit();
    });
});
</script>
@endsection