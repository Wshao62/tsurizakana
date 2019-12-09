{{--@if (!Auth::user()->isIdentified() && Auth::user()->isWaiting4Identification()--}}
{{--    && !Auth::user()->isBusinessIdentified() && Auth::user()->isWaiting4BusinessIdentification())--}}
{{--<div class="identification_box">--}}
{{--    <p>--}}
{{--        あなたは本人確認書類・営業許可証書類の提出済みです。<br>--}}
{{--        運営の確認をもうしばらくお待ちください。<br>--}}
{{--    </p>--}}
{{--</div>--}}
{{--@elseif (!Auth::user()->isIdentified() && Auth::user()->isWaiting4Identification()--}}
{{--    && !Auth::user()->isBusinessIdentified() && !Auth::user()->isWaiting4BusinessIdentification())--}}
{{--    <div class="identification_box">--}}
{{--        <p>--}}
{{--            あなたは本人確認書類書類の提出済みです。<br>--}}
{{--            運営の確認をもうしばらくお待ちください。<br>--}}
{{--            また、売魚を購入するには店舗登録が必要です。--}}
{{--        </p>--}}
{{--        <a href="{{ url('/business-license') }}" class="content_button business">店舗登録</a>--}}
{{--    </div>--}}
{{--@elseif (!Auth::user()->isIdentified() && !Auth::user()->isWaiting4Identification()--}}
{{--    && !Auth::user()->isBusinessIdentified() && Auth::user()->isWaiting4BusinessIdentification())--}}
{{--    <div class="identification_box">--}}
{{--        <p>--}}
{{--            あなたは営業許可証書類の提出済みです。<br>--}}
{{--            運営の確認をもうしばらくお待ちください。<br>--}}
{{--            本人確認が済んでいません！<br>--}}
{{--            本人確認を済ませないと、売魚の出品やリクエスト魚の登録・オファーができません。<br>--}}
{{--        </p>--}}
{{--        <a href="{{ url('/identification') }}" class="content_button">本人確認</a>--}}
{{--    </div>--}}
{{--@elseif (!Auth::user()->isIdentified() && !Auth::user()->isWaiting4Identification()--}}
{{--    && !Auth::user()->isBusinessIdentified() && !Auth::user()->isWaiting4BusinessIdentification())--}}
{{--<div class="identification_box">--}}
{{--    <p>--}}
{{--        あなたは本人確認が済んでいません！<br>--}}
{{--        本人確認を済ませないと、売魚の出品やリクエスト魚の登録・オファーができません。<br>--}}
{{--        また、売魚を購入するには店舗登録が必要です。--}}
{{--    </p>--}}
{{--    <a href="{{ url('/identification') }}" class="content_button">本人確認</a>--}}
{{--    <a href="{{ url('/business-license') }}" class="content_button business">店舗登録</a>--}}
{{--</div>--}}
{{--@elseif (Auth::user()->isIdentified()--}}
{{--    && !Auth::user()->isBusinessIdentified() && !Auth::user()->isWaiting4BusinessIdentification())--}}
{{--    <div class="identification_box">--}}
{{--        <p>--}}
{{--            売魚を購入するには店舗登録が必要です。--}}
{{--        </p>--}}
{{--        <a href="{{ url('/business-license') }}" class="content_button business">店舗登録</a>--}}
{{--    </div>--}}
{{--@elseif (!Auth::user()->isIdentified() && !Auth::user()->isWaiting4Identification()--}}
{{--    && Auth::user()->isBusinessIdentified())--}}
{{--    <div class="identification_box">--}}
{{--        <p>--}}
{{--            あなたは本人確認が済んでいません！<br>--}}
{{--            本人確認を済ませないと、売魚の出品やリクエスト魚の登録・オファーができません。<br>--}}
{{--        </p>--}}
{{--        <a href="{{ url('/identification') }}" class="content_button">本人確認</a>--}}
{{--    </div>--}}
{{--@elseif (!Auth::user()->isIdentified() && Auth::user()->isWaiting4Identification())--}}
{{--    <div class="identification_box">--}}
{{--        <p>--}}
{{--            あなたは本人確認書類書類の提出済みです。<br>--}}
{{--            運営の確認をもうしばらくお待ちください。<br>--}}
{{--        </p>--}}
{{--    </div>--}}
{{--@elseif (!Auth::user()->isBusinessIdentified() && Auth::user()->isWaiting4BusinessIdentification())--}}
{{--    <div class="identification_box">--}}
{{--        <p>--}}
{{--            あなたは営業許可証書類の提出済みです。<br>--}}
{{--            運営の確認をもうしばらくお待ちください。<br>--}}
{{--        </p>--}}
{{--    </div>--}}
{{--@endif--}}

@if (!Auth::user()->isIdentified() && !Auth::user()->isWaiting4Identification())
    <div class="identification_box">
        <p>
            本人確認が済んでいません！<br>
            本人確認を済ませないと、売魚の出品やリクエスト魚の登録・オファーができません。<br>
        </p>
        <a href="{{ url('/identification') }}" class="content_button">本人確認</a>
    </div>
@elseif (!Auth::user()->isIdentified() && Auth::user()->isWaiting4Identification())
    <div class="identification_box">
        <p>
            あなたは本人確認書類書類の提出済みです。<br>
            運営の確認をもうしばらくお待ちください。<br>
        </p>
    </div>
@elseif (!Auth::user()->isIdentified() && Auth::user()->isWaiting4Identification())
    <div class="identification_box">
        <p>
            あなたは本人確認書類書類の提出済みです。<br>
            運営の確認をもうしばらくお待ちください。<br>
        </p>
    </div>
@endif
