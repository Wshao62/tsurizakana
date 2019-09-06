@component('mail::layout')
@slot('header')
    @component('mail::header', ['url' => config('app.url')])
    {{-- TODO: teaserではなく本サービスのlogoに変更 --}}
        <img src="{{ url('/teaser/img/common/logo.png') }}" alt="{{config('app.name')}}" style="width:auto;height:7vh;">
    @endcomponent
@endslot

# @yield('title')

@yield('content')


<br>
<br>

---

このメールは自動で送信されています。<br>
送信専用メールアドレスから送っておりますので、<br>
直接ご返信いただいてもお返事ができません。あらかじめご了承ください。<br>

{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
        © {{config('app.name')}}. All rights reserved.
    @endcomponent
@endslot
@endcomponent