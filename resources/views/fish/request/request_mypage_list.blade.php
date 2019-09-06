@extends('layouts.app')

@section('title', 'リクエスト魚一覧')
@section('page_id', 'page_request')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
@include('parts/template_mypage_header', ['current' => 'fish_request'])
@if (session('error'))
    <div class="content_alert_box">
        <p class="alert">{{ session('error') }}</p>
    </div>
@endif
<div class="layout mp_cont">
    <a class="content_button" onClick="location.href='{{ url('/mypage/fish/request/add') }}'">新規で魚をリクエスト</a>
</div>
</div>

<div class="layout">
    <div class="request">
        <div class="request_search">
            <form  method="GET" action="{{ url('mypage/fish/request') }}" enctype="multipart/form-data">
                <h3>絞り込み検索</h3>
                @include('parts/request/template_search',['isSearch' => 'list'])
                <button type="submit" class="content_button requestpage_btn">検索</button>
            </form>
        </div>
    </div>
    @if (count($fishrequests))
    <dl id="request_table">
        <dt class="pc_title">
            <dl>
            <dt class="req_status">ステータス</dt><dt class="req_name">商品名</dt><dt class="req_area">エリア</dt><dt class="req_date">希望日</dt>
            </dl>
        </dt>
        @foreach($fishrequests as $fishrequest)
        <dd>
            <dl class="sp_num">
                <dt></dt>
            </dl>
            <dl class="list_cont">
                <dt class="sp_title"><div>ステータス</div></dt><dd class="req_status sp_cont"><div class="{{ ($fishrequest->status == "表示中" ? "displaying" : "stop_disp") }}">{{ $fishrequest->status }}</div></dd>
                <dt class="sp_title"><div>商品名</div></dt><dd class="req_name sp_cont"><div><a href="{{ url('/mypage/fish/request/'.$fishrequest['id'].'/edit') }}"  data-toggle="tooltip" title="Edit">{{ $fishrequest->category_name }}</a></div></dd>
                <dt class="sp_title"><div>エリア</div></dt><dd class="req_area sp_cont"><div>{{ $fishrequest->public_address }}</div></dd>
                <dt class="sp_title"><div>希望日</div></dt><dd class="req_date sp_cont"><div>{{ $fishrequest->request_date }}</div></dd>
                <dt><p><a href="{{ url('/fish') }}?category_id={{ $fishrequest->category_id }}&is_open=1#list">{{ $fishrequest->category_name }}</a><br class="sp">は現在<span>{{ $fishrequest->fishcount }}</span>件出品中です</p></dt><dd><a class="content_button requestpage_btn" href="{{ url('/mypage/fish/request/'.$fishrequest->id.'/offer') }}">オファーを確認</a></dd>
            </dl>
        </dd>
        @endforeach
    </dl>
    <div class="pager font_avenirnext">
        {{ $fishrequests->fragment('request_table')->appends(request()->query())->links('vendor.pagination.default') }}
    </div>
    @else
    <div class="content_default_box">
        <p>リクエストはありません。</p>
    </div>
    @endif
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var pageCount = {{ $fishrequests->currentPage() }};
        var cnt = 0;
        const paginate = {{ $limit }};
        console.log(pageCount);
        if(pageCount > 1){
            cnt = (pageCount - 1) * paginate;
        }

        $("#page_request").css({"counter-reset": "number " + cnt});
        $(".sp_num dt").css({"color": "white"});
    });
</script>
@endsection