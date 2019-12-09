@extends('layouts.app')

@section('title', '振込申請について')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_sinsei')
@section('css', 'sinsei.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2> 振込申請について</h2>
            <p class="font_avenirnext">Transfer application</p>
        </div>
    </div>

    <div class="sinsei_info">
        <div class="layout">
            <div class="sinsei">
                <div class="container">
                    <p><br><img src="{{ asset('img/hajimete/service37.jpg') }}" width="800px" height="70px"></p>
                    <p><br>売上の振込申請期限は1年以内となります。<br><br>
                        取引成立日より1年が経過する前に、お早めに振込申請を行って頂けますようお願いいたします。
                        <br><br></p><br>
                    <p><br><img src="{{ asset('img/hajimete/service38.jpg') }}" width="800px" height="70px"></p>
                    <p><br>売上金の振込申請は、「振込スケジュール」に基づき、振込をおこなっております。<br>

                        振込申請の締め日は、毎週月曜日です。<br>
                        振込は、振込申請の締め日から数えて4営業日目になります。<br><br>
                        ※営業日は土・日・祝、年末年始(12/30~1/3)を除く平日を指します<br>
                        振込申請完了日から振込日までの間に祝日・年末年始を挟んでいると、振込日がその日数分だけあとになります。あらかじめご了承ください。<br><br>

                        ※ Webサイトをご利用の場合は、「マイページ」からお進みください。<br><br></p>
                    <p><br><img src="{{ asset('img/hajimete/service36.jpg') }}" width="800px" height="70px"></p>
                    <br>
                    <p>ゆうちょ銀行の貯蓄口座への振込申請はできません。<br>
                        営業日は土・日・祝、年末年始(12/30~1/3)を除く平日を指します。<br><br>
                        振込申請完了日から振込日までの間に祝日・年末年始を挟んでいると、振込日がその日数分だけあとになります。あらかじめご了承ください。<br><br>
                        振込当日にお振込み内容の確認が必要な場合、お客さまご自身でご利用口座の取引明細（入出金明細）をご確認ください。<br>
                        ※ゆうちょ銀行をご利用の場合は記帳の上ご確認ください。<br><br>

                        振込申請履歴の確認につきましては、マイページ＞売上管理より確認できます。<br><br></p><br><br><br><br><br>
                </div>

            </div>
        </div>
    </div>
@endsection
