@extends('layouts.app')

@section('meta_description', mb_substr($fish['description'], 0, 300))
@section('meta_img', $photo[0]['file_name'])
@section('title', $fish['fish_category_name'].'の詳細')
@section('page_id', 'page_fishdetail')
@section('css', 'fish.css')

@section('content')
<div class="layout">
    <div class="title">
    <h2>売魚詳細</h2>
    <p class="font_avenirnext">DETAILS</p>
    </div>
</div>

<div class="layout">
    <div class="fish_detail">
        @if (session('error'))
        <div class="content_alert_box">
            <p class="alert">次のエラーが発生しました。再度お試しいただくか、お問い合わせください。<br>「{{ session('error') }}」</span>
        </div>
        @endif
        @if (session('status'))
        <div class="content_success_box">
            <p class="success">{{ session('status') }}</span>
        </div>
        @endif

        @auth('user')
        @if ($fish->isOwner() && $fish->isPublish() &&  $fish->hasWisher())
        <div class="layout others">
            <p>購入希望者の方がいます！</p>
            <a class="content_button_arrow" href="{{ url('/mypage/fish/'.$fish->id.'/wisher') }}">購入希望者一覧</a>
        </div>
        @endif
        @endauth
        <div class="fish_detail_explain">
            <div class="fish_detail_left">
                <div class="js_fish_detail_slider fish_detail_slider">
                    @foreach ($photo as $_p)
                    <div class="fit_image">
                        <img src="{{ $_p['file_name']}}">
                    </div>
                    @endforeach
                </div>

                <div class="js_fish_detail_thumb fish_detail_thumb">
                @foreach ($photo as $_p)
                    <div class="fit_image">
                        <img src="{{ $_p['file_name']}}">
                    </div>
                @endforeach
                </div>
            </div>

            <div class="fish_detail_right">
                <p class="fish_detail_title"><span class="content_fish_tag @if ($fish->isPublish()) tag_1 @else tag_99 @endif">{{ $fish->getPublicStatus() }}</span>{{ $fish['fish_category_name'] }}</p>
                <table class="fish_detail_table">
                <tr>
                    <th>出品者</th>
                    <td>
                    <div class="fish_detail_profile">
                        <p>{{ $seller['name'] }}</p>
                        <a href="{{ url('/user',$seller['id']) }}">このユーザーのプロフィールを見る</a>
                        <div class="fish_detail_value">
                        <p class="fish_detail_value_good">良い：{{ number_format($seller_rates['good']) }}</p>
                        <p class="fish_detail_value_normal">普通：{{ number_format($seller_rates['normal']) }}</p>
                        <p class="fish_detail_value_bad">悪い：{{ number_format($seller_rates['bad']) }}</p>
                        </div>
                    </div>
                    </td>
                </tr>
                <tr><th>数量</th><td><div>{{ $fish['amount'] }} 匹</div></td></tr>
                <tr><th>サイズ</th><td><div>{{ $fish['size_cm'] }} cm / {{ $fish['size_kg'] }} kg</div></td></tr>
                <tr><th>締め方</th><td><div>{{ $fish['how_to_tighten'] }}</div></td></tr>
                <tr><th>釣れた場所</th><td><div>{{ $fish['prefecture'] }} / {{ $fish['location'] }}</div></td></tr>
                <tr><th>お届け可能地域</th><td><div>{{ $fish['destination'] }}</div></td></tr>
                <tr><th>配達方法</th><td><div>{{ $fish['delivery_method'] }}</div></td></tr>
                <tr><th>登録時間</th><td><div class="font_avenirnext">{{ $fish->getFormatedCreatedAt('H:i:s') }}</div></td></tr>
                <tr><th>配送元地域</th><td><div>東京都</div></td></tr>
                </table>
                <p class="fish_detail_price">価格：<span class="fish_detail_price_value">¥{{ number_format($fish['price']) }}</span><span class="fish_detail_price_tax">（税込）</span></p>
                @if ($fish->isPublish())
                    @auth('user')
                        @if ($fish->isOwner())
                            <a href="{{ url('/mypage/fish/'.$fish['id'].'/edit') }}" class="content_button_arrow">編集する</a>
                        @elseif (!\Auth::user()->isIdentified())
                            @if (!\Auth::user()->isWaiting4Identification())
                            <a href="{{ url('/identification')}}" class="content_button_arrow content_button_gray">本人確認を済ませる</a>
                            @endif
                            <p>本人確認を済ませていないため、購入できません。</p>
                        @elseif ($fish->hasOffer4User())
                            <a href="" class="content_button_arrow content_button_gray js_wish_btn">購入する</a>
                            <p>※オファーをもらっているので直接購入可能です</p>
                            <form id="wish-form" action="{{ url('/fish/'.$fish['id'].'/wish') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @elseif (!$fish->isWisher())
                            <a href="" class="content_button_arrow js_wish_btn">購入を希望する</a>
                            <form id="wish-form" action="{{ url('/fish/'.$fish['id'].'/wish') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a href="" class="content_button_arrow content_button_gray js_cancel_btn">購入希望をキャンセル</a>
                            <form id="cancel-form" action="{{ url('/fish/'.$fish['id'].'/wish/cancel') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endif
                    @else
                    <a href="{{ url('/fish/'.$fish['id'].'/buy') }}" class="content_button_arrow">ログインして購入する</a>
                    @endauth
                @endif
            </div>
        </div>

        <div class="fish_detail_text">
            <p>商品情報</p>
            <p>{!! nl2br(htmlspecialchars($fish['description'])) !!}</p>
        </div>

        <div class="user_comment">
            <p>書き込み</p>
            <p class="text-center">書き込みはまだありません。</p>

            <div class="usrcmmnt_list_container">
                <div class="usrcmmnt_list">
                    @foreach($comments as $comment)
                    <div class="usrcmmnt flex_box">
                        <div class="usrcmmnt_pic">
                            @if ($comment->user->photo->getProfile())
                            <img src="{{ $comment->user->photo->getProfile() }}">
                            @else
                            <img src="{{ url(config('const.profile_img_default_icon')) }}">
                            @endif
                        </div>
                        <div class="usrcmmnt_area">
                            <p class="usrcmmnt_name">{{ $comment->user['name'] }}</p>
                            <div class="usrcmmnt_box">
                                <p class="usrcmmnt_text">{!! nl2br(e($comment['content'])) !!}</p>
                                <p class="usrcmmnt_time"><img src="{{ url('/img/icon/icon_time_2.png') }}">{{ date("m/d H:i", strtotime($comment->created_at)) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @if ($fish->status === 1)
            <div class="comment_write">
                {{-- -trans- --}}
                <textarea placeholder="{{ !Auth::user() ? 'コメントするにはログインが必要です。' : 'コメントを入力してください。' }}" name="comment" id="comment" maxLength="255" {{ !Auth::user() ? 'disabled' : '' }}></textarea>
                <p class="usrcmmnt_text" id="textarea_warning"></p>
                <span class="alert"></span>
                <button class="content_button_arrow" id="saveComment" type="submit" {{ !Auth::user() ? 'disabled' : '' }}>書き込む</button>
            </div>
            @endif
        </div><!-- END user_comment -->
    </div>
</div>
<div class="layout layout_pickup">
    <div class="pickup">
    @if ($other_fish->count() > 0)
        <p class="pickup_recommend hide_sp">最新のお魚をチェック</p>
        <p class="pickup_recommend hide_pc">最新情報</p>
        <div class="pickup_inner">
            @foreach ( $other_fish as $_of )
            <div class="pickup_card">
                <a href="{{ url('/fish', $_of->id) }}">
                <div class="fit_image"><img src="{{ $_of->onePhoto->file_name }}" alt="{{ $_of->fish_category_name }}"></div>
                <div class="pickup_textarea">
                    <p class="pickup_title_middle">{{ $_of->fish_category_name }}</p>
                    <p class="pickup_price font_avenirnext">¥{{ number_format($_of->price) }}<span class="pickup_tax">（税込）</span></p>
                    <p class="pickup_location"><span class="icon_before icon_before_location"></span>{{ $_of->destination }}</p>
                    <p class="pickup_time font_avenirnext"><span class="icon_before icon_before_clock"></span>{{ $_of->getFormatedCreatedAt('H:i:s') }}</p>
                </div>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection

@section('before_end')
<script>
    $(function(){
        $('.js_wish_btn').on('click', function(event){
            event.preventDefault();
            if (!confirm('購入希望を出します。購入者として選択されると、決済をする必要があります。また購入希望を出すと、販売者へと通知送られます。')) {
                return false;
            }
            $('#wish-form').submit();
        });

        $('.js_cancel_btn').on('click', function(event){
            event.preventDefault();
            if (!confirm('購入希望を取り下げます。再度購入希望を出す場合も販売者へ通知が送られるのでご注意ください。')) {
                return false;
            }
            $('#cancel-form').submit();
        });
    });

    //save comment to db
    $(document).on("click", "#saveComment", function(){
        $comment = $('[name=comment]').val();

        if($comment.trim() != ''){
            $.ajax({
                type: "post",
                url: '/fish/{{ $fish->id }}/saveComment',
                data: {
                    comment: $comment,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response){
                    if(response == 'success'){
                        $('[name=comment]').val('');
                        $('.alert').html('');
                        $(".usrcmmnt_list_container").load(
                            "{{route('fish.detail', $fish->id)}} .usrcmmnt_list_container>.usrcmmnt_list",
                            function() {
                                if (($('.usrcmmnt').length)) {
                                    $('.text-center').html('');
                                }
                                scrollMessagesDown();
                            }
                        );
                    }else{
                        $('.alert').html('システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。');
                    }
                },
                error: function(){
                    $('.alert').html('システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。');
                }
            });
        }else{
            $('.alert').html('送信内容を入力してください。');
        }
    });

    /**
    * Scroll messages down to some height or bottom.
    */
    $(document).ready(function(){
        if (($('.usrcmmnt').length)) {
            $('.text-center').html('');
        }
        scrollMessagesDown();
    });
    var scrollMessagesDown = function (height = 0) {
        var $messenger  = $('.usrcmmnt_list_container');
        var scrollTo = height || $messenger.prop('scrollHeight');
        $messenger.scrollTop(scrollTo);
    }
</script>
@endsection
