@if (!Auth::user()->isIdentified() && Auth::user()->isWaiting4Identification())
<div class="identification_box">
    <p>
    あなたは本人確認書類の提出済みです。<br>
    運営の確認をもうしばらくお待ちください。
    </p>
</div>
@elseif (!Auth::user()->isIdentified())
<div class="identification_box">
    <p>
    あなたは本人確認が済んでいません！<br>
    本人確認を済ませないと、売魚の販売購入やリクエスト魚の登録・オファーができません。
    </p>
    <a href="{{ url('/identification') }}" class="content_button">本人確認</a>
</div>
@endif