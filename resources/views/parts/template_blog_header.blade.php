@section('before_end')
<style>
.lower_bg::before {
    background-image: url({{ url($user->photo->getCover()) }});
}
</style>
@endsection

@if ($user->id == \Auth::id() )
<a class="link_profile" href="{{ url('/mypage/profile/edit') }}">プロフィールを編集</a>
@endif
<div class="layout">
    <div class="user_info">
        <div class="fit_image">
            <img src="{{ $user->photo->getProfile() }}">
        </div>
        <p class="user_info_name">{{ $user->name }}</p>
        <p class="user_info_number">［　<a href="{{ url('/user/'.$user->id.'/grade') }}">評価：{{ number_format($user->rate->count()) }}</a>　/　<a href="{{ url('/fish') }}?user_id={{ $user->id }}">販売数：{{ number_format($user->sale()->count()) }}</a>　］</p>

        @if ($need_introduction)
        <div class="user_info_balloon">
            <p>
            @if (!empty($user->introduction))
            {!! nl2br(e($user->introduction)) !!}
            @else
            --自己紹介はありません--
            @endif
            </p>
        </div>
        @endif

        @if ($need_shop && !empty($user->shop))
        <div class="shop_info">
          <p class="shpinf_p">店舗情報</p>
          <table>
            <tr>
              <th>
                <p>店舗名</p>
              </th>
              <td>
                <div>
                  <p>{{ $user->shop->name }}</p>
                </div>
              </td>
            </tr>
            <tr>
              <th>
                <p>住所</p>
              </th>
              <td>
                <div>
                  <p class="shop_adress">
                    {{ $user->shop->zipcode }}<br>
                    {{ $user->shop->full_address }}
                  </p>
                  <a href="https://maps.google.co.jp/maps/search/{{ $user->shop->full_address }}" target="_blank">>Google mapで地図を見る</a>
                </div>
              </td>
            </tr>
          </table>
        </div>
        @endif
    </div>
