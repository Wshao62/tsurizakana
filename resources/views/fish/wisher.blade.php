@extends('layouts.app')

@section('title', '購入希望者一覧')
@section('page_id', 'page_applicant')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
@include('parts/template_mypage_header', ['current' => 'fish'])
    @if ($errors->has('wisher_id'))
        <div class="content_alert_box">
            <p class="alert">
                {{ $errors->first('wisher_id') }}
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
    @if (empty($is_registerd_bank))
        <div class="bank_box">
            <p class="alert">
                口座情報が未登録です。<br>口座情報を登録していただくことで購入希望者を確定できます。
                <a href="{{ url('/mypage/profile/edit') }}" class="content_button">プロフィール編集へ</a>
            </p>
        </div>
    @endif
    <div class="list_area">
        <div id="page_items">
            <div class="my_fish">
                <div class="item_box">
                    <div class="it_cont">
                        <div class="fit_image">
                        <img src="{{ $fish->onePhoto->file_name }}">
                        </div>
                        <table>
                        <colgroup>
                            <col class="it_l">
                            <col class="it_r">
                        </colgroup>
                        <tr><th colspan="2"><p class="tdd_title">{{$fish->fish_category_name}}</p></th></tr>
                        <tr><td><span><img class="price" src="{{ url('/') }}/img/fish/detail_price.png"></span>商品代金：</td><td>{{ number_format($fish->price)}}円</td></tr>
                        <tr><td><span><img class="location" src="{{ url('/') }}/img/icon/icon_location.png"></span>釣れた場所：</td><td>{{ $fish->location }}</td></tr>
                        <tr><td><span><img class="clock" src="{{ url('/') }}/img/icon/icon_clock.png"></span>購入日時：</td><td>{{ $fish->getFormatedCreatedAt() }}</td></tr>
                        </table>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="list" class="layout">
            @if (count($wishers) !== 0)
            <dl class="applicant_list">
                <dt class="pc_title">
                <dl>
                    <dt class="appl_name">ユーザー名</dt><dt class="appl_area">場所</dt><dt class="appl_rate">評価</dt><dt class="appl_btn"></dt>
                </dl>
                </dt>
                @foreach ($wishers as $wisher)
                <dd class="applicant_list_item">
                    <dl class="sp_num">
                        <dt></dt>
                    </dl>
                    <dl class="list_cont">
                        <dt class="sp_title"><div>ユーザー名</div> </dt>
                        <dd class="appl_name sp_cont">
                            <a href="{{ url('/user/'.$wisher->user_id) }}">
                                <div class="fit_image">
                                    <img src="{{ $wisher->user->photo->getProfile() }}">
                                </div>
                                <p>{{ $wisher->user->name }}</p>
                            </a>
                        </dd>
                        <dt class="sp_title"><div>場所</div></dt>
                        <dd class="appl_area sp_cont">
                            <div>{{ $wisher->user->getPublicAddress() }}</div>
                        </dd>
                        <dt class="sp_title">
                            <div>評価</div>
                        </dt>
                        <dd class="appl_rate sp_cont">
                            <p><a href="{{ url('/user/'. $wisher->user_id .'/grade/good') }}">良い：{{ number_format($rates[$wisher->user_id]['good']) }}</a></p>
                            <p><a href="{{ url('/user/'. $wisher->user_id .'/grade/normal') }}">普通：{{ number_format($rates[$wisher->user_id]['normal']) }}</a></p>
                            <p><a href="{{ url('/user/'. $wisher->user_id .'/grade/bad') }}">悪い：{{ number_format($rates[$wisher->user_id]['bad']) }}</a></p>
                        </dd>
                        @if (!$fish->isTransaction())
                        <dt class="sp_title">
                            &nbsp;
                        </dt>
                        <dd class="appl_btn sp_cont applicant_dd">
                            @if ($fish->isPublish() && $is_registerd_bank)
                            <button class="content_button js_choose_btn">この人に販売</button>
                            <form method="POST" action="{{ url('/mypage/fish/'.$fish->id.'/wisher/choose')}}" style="display: none;">
                                @csrf
                                <input type="hidden" name="wisher_id" value="{{ $wisher->user_id }}" readonly/>
                            </form>
                            @endif
                        </dd>
                        @endif
                    </dl>
                </dd>
                @endforeach
            </dl>
            <div class="pager font_avenirnext">
                {{ $wishers->fragment('list')->links('vendor.pagination.default') }}
            </div>
            @else
            <div class="content_default_box">
                <p>まだ購入希望者はいません。</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('before_end')
<script>
    $(function(){
        $('.js_choose_btn').on('click', function(event){
            event.preventDefault();
            if (!confirm('決定すると、このユーザの住所までの配達義務が生じます。お間違いない場合、そのまま操作を続けてください。')) {
                return false;
            }
            $(this).next('form').submit();
        });
    });

    $(document).ready(function() {
        var pageCount = {{ $wishers->currentPage() }};
        var cnt = 0;
        const paginate = {{ $limit }};
        console.log(pageCount);
        if(pageCount > 1){
            cnt = (pageCount - 1) * paginate;
        }

        $("#page_applicant").css({"counter-reset": "number " + cnt});
        $(".sp_num dt").css({"color": "white"});
    });
</script>
@endsection