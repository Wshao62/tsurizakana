@extends('layouts.app')

@section('title', '売魚一覧')
@section('page_id', 'page_items')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
@include('parts/template_mypage_header', ['current' => 'fish'])
@if (session('status'))
<div class="content_success_box">
    <p class="success">
        {{ session('status') }}
    </p>
</div>
@endif
@if (session('error'))
<div class="content_alert_box">
    <p class="alert">
        {{ session('error') }}
    </p>
</div>
@endif
<div class="type_tab">
    <a href="?type=" @if (empty($type))class="current" onclick="return false;"@endif>出品した魚</a>
    <a href="?type={{\App\Models\Fish::LIST_BUY }}" @if ($type == \App\Models\Fish::LIST_BUY)class="current" onclick="return false;"@endif>購入した魚</a>
    <a href="?type={{ \App\Models\Fish::LIST_TRANSACTION }}" @if ($type == \App\Models\Fish::LIST_TRANSACTION)class="current" onclick="return false;"@endif>取引中の魚</a>
</div>
<div id="list" class="my_fish_wrap">
    @if ($fish->count() != 0)
    @foreach ($fish as $_f)
    <div class="my_fish" href="{{ url('/mypage/fish/') }}">
        <div class="item_box">
            <div class="it_cont">
                <div class="it_cont_l">
                    <div class="fit_image">
                    <img src="{{ $_f->onePhoto->file_name }}">
                    </div>
                    <span class="content_fish_tag tag_{{ $_f->status }}">{{ $_f->getStatus() }}</span>
                </div>
                <table>
                <colgroup>
                    <col class="it_l">
                    <col class="it_r">
                </colgroup>
                <tr>
                    <th colspan="2"><p class="tdd_title">{{ $_f->fish_category_name }}</p></th>
                </tr>
                <tr>
                    <td><span><img class="price" src="../img/fish/detail_price.png"></span>商品代金：</td><td>{{ number_format($_f->price) }}円</td>
                </tr>
                <tr>
                    <td><span><img class="location" src="../img/icon/icon_location.png"></span>釣った場所：</td><td>{{ $_f->location }}</td>
                </tr>
                <tr>
                    <td><span><img class="clock" src="../img/icon/icon_clock.png"></span>登録日時：</td><td>{{ $_f->getFormatedCreatedAt() }}</td>
                </tr>
                </table>
                <div class="clear"></div>
            </div>
            @if ($_f->isFinish())
            <div class="finish_cover">
                <p>{{ $_f->getStatus() }}</p>
            </div>
            @endif
        </div>
        <div class="links">
            @if ($_f->canEdit())
            <a href="{{ url('/mypage/fish/'.$_f->id.'/edit') }}" class="content_button btn_lg">編集する</a>
            @endif
            @if ($_f->isTransaction())
            <a href="{{ url('/mypage/fish',$_f->id) }}" class="content_button">取引詳細画面</a>
            @elseif ($_f->hasWisher())
            <a href="{{ url('/mypage/fish/'.$_f->id.'/wisher') }}" class="content_button btn_g">購入希望者一覧</a>
            @endif
        </div>
        @if ($_f->canDelete())
            <a href="" class="delete_link js_delete fit_image"><img src="@if ($_f->isPublish()){{ url('/') }}/img/icon/icon_trash.png @else {{ url('/') }}/img/icon/icon_trash_white.png @endif" alt="削除する"></a>
            <form method="POST"action="{{ url('/mypage/fish/'.$_f->id.'/delete') }}">
                @csrf
            </form>
        @endif
    </div>
    @endforeach
    </div>
    <div class="pager font_avenirnext">
        {{ $fish->fragment('list')->appends(request()->query())->links('vendor.pagination.default') }}
    </div>
    @else
    <div class="content_default_box"><p>売魚はまだありません。</p></div>
    @endif
</div>
</div>
<a class="sell_btn" href="{{ url('/mypage/fish/add') }}"><img src="{{ url('/') }}/img/mypage/sell.png"></a>
@endsection

@section('before_end')
<script>
    $(function(){
        $('.js_delete').on('click', function(){
            event.preventDefault();
            if (!confirm('この操作後は売魚は元に戻せません。削除してよろしいですか？')) {
                return false;
            }
            $(this).next('form').submit();
        });
    });
</script>
@endsection