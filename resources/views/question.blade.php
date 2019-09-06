@extends('layouts.app')

@section('title', 'よくある質問')
{{-- TODO: questionを売主、買主でページ分ける --}}
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のよくある質問をまとめて答えているページです。全体のサービスについての質問と回答をご覧頂けます。')
@section('page_id', 'page_question')
@section('css', 'question.css')
@section('not_need_header_img', true)

@section('content')
<div class="layout">
    <div class="title">
    <h2>よくある質問</h2>
    <p class="font_avenirnext">QUESTION</p>
    </div>
</div>
<div class="faq">
    <div class="layout tab">
    <div class="tab_baloon">
        <div class="js_tab_baloon tab_baloon_button current">全体のサービスについて</div>
        <div class="js_tab_baloon tab_baloon_button">釣り人でご登録の方</div>
        <div class="js_tab_baloon tab_baloon_button">店舗でご登録の方</div>
    </div>
    <div class="tab_select">
        <p class="hide-pc tab_select_label">全体のサービスについて</p>
        <select class="js_tab_select">
        <option class="" value="#">全体のサービスについて</option>
        <option class="" value="#">釣り人でご登録の方</option>
        <option class="" value="#">店舗でご登録の方</option>
        </select>
    </div>

    <div class="js_tab_baloon_inner tab_baloon_inner current">
        <div class="js_faq_line faq_line">
        <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>サービスの利用にはお金がかかりますか？</span></p>
        <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>サービスの利用にお金はかかりません。魚を購入する時に魚の値段分の支払いが発生します。</span></p>
        </div>
        <div class="js_faq_line faq_line">
        <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>どのようなサービスですか？</span></p>
        <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚商店は、釣り人と魚を買いたい人を繋げるマッチングサービスです。釣り人が釣った魚をサービスに掲載する事で、購入者はその魚達を釣り人から直接買取る事が出来ます。</span></p>
        </div>
        <div class="js_faq_line faq_line">
        <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>取引時にトラブルなどは発生しますか？<br class="hide_pc">また、フォローなどはしてもらえますか？</span></p>
        <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>トラブルの発生は考えられます。その際は運営事務局までお問い合わせください。</span></p>
        </div>
        <div class="js_faq_line faq_line">
        <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>写真や産地などを偽装した人を発見した場合はどうしたらいいですか？</span></p>
        <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>運営事務局までお問い合わせください。出品者の登録抹消するなど対応を行います。</span></p>
        </div>
    </div>

    <div class="js_tab_baloon_inner tab_baloon_inner">
        <div class="js_faq_line faq_line">
        <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>どこの海で釣った魚でも大丈夫でしょうか？</span></p>
        <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>登録の際に、釣れた場所を登録ください。法律上、違法海域での釣りはご遠慮ください。</span></p>
        </div>
        <div class="js_faq_line faq_line">
        <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>スマートフォンからも登録は可能ですか？</span></p>
        <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>はい。可能です。PCだけでなくスマートフォンサイト、今後はアプリでもサービスをご提供予定です。</span></p>
        </div>
        <div class="js_faq_line faq_line">
        <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>配送料についての負担は？</span></p>
        <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣り人側のご負担となります。</span></p>
        </div>
        <div class="js_faq_line faq_line">
        <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>クール便でないとだめか？</span></p>
        <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>必ずしもクール便である必要はありません。発送方法につきましては、店舗側と協議の上、決めていただければと思います。</span></p>
        </div>
        <div class="js_faq_line faq_line">
        <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>毒のある魚を出品し、被害が出た場合はどうなりますか？</span></p>
        <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚商店は釣り人と店舗のマッチングサービスになります。あくまでもプラットフォームに過ぎません。被害がでた場合は、出品者側の過失となります。詳しくは利用規約をご確認ください。ただし弊社としましても問題があると判断された出品者は登録抹消するなど対応を行います。</span></p>
        </div>
        <div class="js_faq_line faq_line">
        <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>違法な方法で採取した商品を出品した場合、どうなりますか？？</span></p>
        <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>問題があると判断された出品者は登録抹消するなど対応を行います。</span></p>
        </div>
    </div>

    <div class="js_tab_baloon_inner tab_baloon_inner">
        <div class="js_faq_line faq_line">
        <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>どんな魚がありますか？</span></p>
        <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>時期によって掲載される魚は異なります。掲載している魚をご確認ください。</span></p>
        </div>
        <div class="js_faq_line faq_line">
        <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>領収書は発行できますか？</span></p>
        <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>マイページより領収書の発行が可能です。</span></p>
        </div>
        <div class="js_faq_line faq_line">
        <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>ほしい魚のリクエストは可能ですか？</span></p>
        <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>はい。可能です。店舗でほしい魚等をオファーすることが可能です。</span></p>
        </div>
        <div class="js_faq_line faq_line">
        <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>どのような方法で支払いができますか？</span></p>
        <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>クレジットカードでの支払いが可能です。</span></p>
        </div>
        <div class="js_faq_line faq_line">
        <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>寄生虫がついていた場合はどうなりますか？</span></p>
        <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>寄生虫の存在の有無は解体しないとわかりません。釣り人、店舗側が責任をもって対処をお願いします。</span></p>
        </div>
    </div>
    </div>
</div>
@endsection
