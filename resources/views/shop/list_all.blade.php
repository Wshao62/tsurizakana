@extends('layouts.app')

@section('title', '店舗一覧')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」に登録されているお店の一覧です。')
@section('page_id', 'page_shop')
@section('css', 'list.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>店舗一覧</h2>
            <p class="font_avenirnext">SHOP LIST</p>
        </div>
    </div>
    <div class="list_area">
        <form id="search_form">
            <div class="layout">
                <div class="search_area">
                    <label>
                        <p class="icon_before icon_before_location">キーワード</p>
                        <input type="text" name="search[keyword]" class="search_keyword"
                               value="{{ !empty($search['keyword']) ? $search['keyword'] : '' }}"
                               id="keyword_input"
                               placeholder="キーワードを入力してください「真鯛、タラ」">
                    </label>
                    <label>
                        <p class="icon_before icon_before_location">エリア</p>
                        <input type="text" name="search[area]" class="search_keyword"
                               value="{{ !empty($search['area']) ? $search['area'] : '' }}"
                               id="area_input"
                               placeholder="エリアを入力してください「大田区、光町」">
                    </label>
                </div>
                <button type="submit" class="content_button search_submit">条件を変更して検索</button>
            </div>
            <div class="list_setting layout">
                <div class="list_area_narrow">
                    <p class="list_area_result">ブログは<span class="font_avenirnext">{{ $total_count }}</span>件あります</p>
                    <div class="list_area_sort">
                        <div class="list_area_sort_area">
                            <p>件数</p>
                            <label>
                                <select class="font_avenirnext count_select">
                                    <option value="20" {{ $count == 20 ? 'selected' : '' }}>20</option>
                                    <option value="40" {{ $count == 40 ? 'selected' : '' }}>40</option>
                                </select>
                            </label>
                        </div>
{{--                        <div class="list_area_sort_area">--}}
{{--                            <p>表示並び替え</p>--}}
{{--                            <label>--}}
{{--                                <select class="sort_select">--}}
{{--                                    <option value="">並び替え</option>--}}
{{--                                    <option value="1" {{ $sort == 1 ? 'selected' : '' }}>おすすめ順</option>--}}
{{--                                    <option value="2" {{ $sort == 2 ? 'selected' : '' }}>価格順</option>--}}
{{--                                </select>--}}
{{--                            </label>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="list_area_display">
                    <p>(全{{ $total_count }}件中) {{ $shops->firstItem() }}〜{{ $shops->lastItem() }}件表示</p>
                </div>
            </div>
        </form>

        <div class="list_area_main layout">
            <div class="pickup">
                <div class="pickup_inner">
                    @if (!empty($shops->total()))
                        @foreach ($shops as $shop)
                            <div class="pickup_card">
                                <a href="../blog/index.html">
                                    <div class="fit_image"><img src="{{ $shop->photo->file_name }}" alt=""></div>
                                    <div class="pickup_textarea">
                                        <p class="pickup_title_middle">{{ $shop->name }}</p>
                                        <p class="card_info crdinf_shop">店舗種別：<span>{{ $shop->shop_type }}</span></p>
                                        <p class="card_info crdinf_sales">販売数：<span>{{ $shop->user->sale()->count() }}</span></p>
                                        <p class="card_info crdinf_area">住所：<span>{{ $shop->full_address }}</span></p>
                                        <div class="fish_detail_value">
                                            <p class="fish_detail_value_good">良い：{{ number_format($shop->user->rate_counts['good']) }}</p>
                                            <p class="fish_detail_value_normal">普通：{{ number_format($shop->user->rate_counts['normal']) }}</p>
                                            <p class="fish_detail_value_bad">悪い：{{ number_format($shop->user->rate_counts['bad']) }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="content_default_box"><p>店舗はまだありません。</p></div>
                    @endif
                </div>
                <div class="pager font_avenirnext">
                    {{ $shops->appends($params)->links('vendor.pagination.list') }}
                </div><!-- END pager -->
            </div>
        </div>
    </div>
@endsection

@section('before_end')
    <script>
        $(function() {
            $('.count_select').change (function() {
                location.href = '/shop/list' + getParameter();
            });
            // $('.sort_select').change (function() {
            //     location.href = '/shop/list' + getParameter();
            // });
        });

        function getParameter() {
            let res = '';
            let query = '';
            if ($('.count_select').val() !== "") {
                query = (res === '') ? '?' : '&';
                res += query + 'count=' + $('.count_select').val();
            }
            // if ($('.sort_select').val() !== "") {
            //     query = (res === '') ? '?' : '&';
            //     res += query + 'sort=' + $('.sort_select').val();
            // }
            if ($('#keyword_input').val() !== "") {
                query = (res === '') ? '?' : '&';
                res += query + 'search[keyword]=' + $('#keyword_input').val();
            }
            if ($('#area_input').val() !== "") {
                query = (res === '') ? '?' : '&';
                res += query + 'search[area]=' + $('#area_input').val();
            }
            return res;
        }
    </script>
@endsection
