
<div class="user_bg" style="background-image: url({{Auth::user()->photo->getCover()}});"></div>
<a class="link_profile" href="{{ url('/mypage/profile/edit')}}">プロフィールを編集</a>
<div class="layout">
    <div class="user_info">
        <div class="fit_image">
            <img src="{{ Auth::user()->photo->getProfile() }}">
        </div>
        <p class="user_info_name">{{ Auth::user()->name }}</p>
    </div>
    @include('parts/template_identification_notify_box')
</div>
<div class="layout mp_cont">
    <div class="tab">
    <div class="tab_baloon">
        @if (\Auth::user()->isIdentified())
        <div class="tab_baloon_button @if($current == 'fish_add') current @endif"><a href="{{ url('mypage/fish/add') }}">売魚アップロード</a></div>
        <div class="tab_baloon_button @if($current == 'fish') current @endif"><a href="{{ url('mypage/fish') }}">売魚一覧</a></div>
        <div class="tab_baloon_button @if($current == 'fish_request') current @endif"><a href="{{ url('mypage/fish/request') }}">リクエスト魚一覧</a></div>
        <div class="tab_baloon_button @if($current == 'receipt') current @endif"><a href="{{ url('mypage/receipt') }}">領収証</a></div>
        @else
        <div class="tab_baloon_button not_active"><p class="not_active">売魚アップロード</p></div>
        <div class="tab_baloon_button not_active"><p class="not_active">売魚一覧</p></div>
        <div class="tab_baloon_button not_active"><p class="not_active">リクエスト魚一覧</p></div>
        <div class="tab_baloon_button not_active"><p class="not_active">領収証</p></div>
        @endif
        <div class="tab_baloon_button @if($current == 'blog') current @endif"><a href="{{ url('mypage/blog')}}">ブログ管理</a></div>
    </div>
    <div class="tab_select">
        <p class="hide-pc tab_select_label">
        @if ($current == 'fish_add')
            売魚アップロード
        @elseif($current == 'fish')
            売魚一覧
        @elseif($current == 'fish_request')
            リクエスト魚一覧
        @elseif($current == 'receipt')
            領収証
        @else
            ブログ管理
        @endif
        </p>
        <select onChange="location.href=value;">
        @if (\Auth::user()->isIdentified())
        <option class="" value="{{ url('mypage/fish/add') }}" @if($current == 'fish_add') selected @endif>売魚アップロード</option>
        <option class="" value="{{ url('mypage/fish') }}" @if($current == 'fish') selected @endif>売魚一覧</option>
        <option class="" value="{{ url('mypage/fish/request') }}" @if($current == 'fish_request') selected @endif>リクエスト魚一覧</option>
        <option class="" value="{{ url('mypage/receipt') }}" @if($current == 'receipt') selected @endif>領収証</option>
        @endif
        <option class="" value="{{ url('mypage/blog')}}" @if($current == 'blog') selected @endif>ブログ管理</option>
        </select>
    </div>
</div>