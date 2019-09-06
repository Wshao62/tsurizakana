@extends('layouts.app')

@section('title', 'リクエスト魚一覧')
@section('page_id', 'page_request')
@section('css', 'request.css')

@section('content')
<div class="layout mp_cont">
    <div class="title">
    <h2>リクエスト魚一覧</h2>
    <p class="font_avenirnext">REQUEST FISH LISTS</p>
    </div>
    <div class="request">
        <div class="request_search">
            <form  method="GET" action="{{ url('/fish/request') }}" enctype="multipart/form-data">
                <h3>絞り込み検索</h3>
                @include('parts/request/template_search',['isSearch' => 'confirm'])
                <button type="submit" class="content_button">検索</button>
            </form>
        </div>
        @if (count($fishrequests))
        @php ($from_count = $fishrequests->currentPage() == 1 ? 1 : ($fishrequests->currentPage()-1) * $fishrequests->perPage() + 1)
        @php ($to_count = ($fishrequests->currentPage()-1) * $fishrequests->perPage() + $fishrequests->count())
        <p id="req_count">
        (全{{ $fishrequests->total() }}件中) {{ $from_count }}～{{ $to_count }}件表示</p>
        <table class="request_table">
            <thead>
            <tr><th>商品名</th><th>エリア</th><th>ユーザー名</th><th>締切日</th>@if (\Auth::user()->isIdentified())<th></th>@endif</tr>
            </thead>
            <tbody>
            @foreach($fishrequests as $fishrequest)
            <tr>
                <th class="request_table_number hide_pc"><div class="font_avenirnext"></div></th>
                <th class="request_table_item"><div>商品名</div></th><td><div>{{ $fishrequest->category_name }}</div></td>
                <th class="request_table_area"><div>エリア</div></th><td><div>{{ $fishrequest->public_address }}</div></td>
                <th class="request_table_name"><div>ユーザー名</div></th><td><div><a href="{{ url('/user', $fishrequest->user_id) }}">{{ $fishrequest->name }}</a></div></td>
                <th class="request_table_date"><div>締切日</div></th><td><div>{{ $fishrequest->request_date }}</div></td>
                <th class="hide_pc"></th>
                @if (\Auth::user()->isIdentified())
                <td>
                    <div>
                        <a href="{{ url('/request/'.$fishrequest->id. '/offer') }}" class="content_button {{ ($fishrequest->offer_count > 0 ? "disable_disp" : ($fishrequest->isOwner > 0 ? "hide_disp" : "displaying")) }}">
                            {{ ($fishrequest->offer_count > 0 ? "オファー済" : "オファー") }}
                        </a>
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pager font_avenirnext">
            {{ $fishrequests->fragment('req_count')->appends(request()->query())->links('vendor.pagination.default') }}
        </div>
        @else
        <div class="content_default_box">
            <p>リクエストはありません。</p>
        </div>
        @endif
    </div>
</div>
@endsection

@section('before_end')

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