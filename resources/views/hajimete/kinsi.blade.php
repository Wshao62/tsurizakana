@extends('layouts.app')

@section('title', '禁止行為/出品物について')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_service')
@section('css', 'kinsi.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>禁止行為/出品物について</h2>
            <p class="font_avenirnext">prohibited act</p>
        </div>
    </div>

    <div class="kinsi_info">
        <div class="layout">
            <div class="kinsi">
                <div class="container">
                    <p><br><img src="{{ asset('img/hajimete/service46.jpg') }}" width="800px" height="70px"></p>
                    <br><br>
                    <p>趣味の延長で釣った魚を、そのまま販売する行為は「採取業」といい、行政監督官庁の許可を必要としません。<br>
                        ただし、釣り人が、通常の趣味の延長としての釣りを逸脱した場合、行政監督官庁からの行政指導が入る場合があります。<br>
                        会員の皆様におかれましては、法律を遵守した上で釣魚商店をお楽しみ頂けますようお願いいたします。<br><br>つきましては、釣魚商店では以下の項目に挙げる出品と行為を禁止しております。<br>
                    </p><br>
                    <p><br><img src="{{ asset('img/hajimete/service29.jpg') }}" width="800px" height="70px"></p>
                    <p><br>■出品者は、自身が釣った魚以外のものを出品することは出来ません。
                        <br><br></p><br>
                    <p><br><img src="{{ asset('img/hajimete/service30.jpg') }}" width="800px" height="70px"></p>
                    <p><br>■以下に記載された釣り魚等を加工したものを出品をすることは出来ません。<br>
                        ①鮮魚等を乾燥させ、「干物等」に加工したもの<br>
                        ②鮮魚等を切除し、「切り身等」に加工したもの<br>
                        ③鮮魚等を塩を含む調味料等に漬け込む加工したもの<br>
                        ④その他、自然のままの鮮魚等を別の目的物にすることを意図して加工したもの<br>※ただし、鮮度を保つことを目的とした「血抜き」「内臓抜き」等を施したものは可<br><br></p>
                    <p><br><img src="{{ asset('img/hajimete/service31.jpg') }}" width="800px" height="70px"></p>
                    <br>
                    <p>
                        ■釣り魚を12時間以上貯蔵し注文に応じて発送することは出来ません。<br>※この行為は、魚介類販売許可免許の取得が必要となる可能性を生じさせるため、釣り魚商店では禁止しております。<br><br>
                    </p>
                    <p><br><img src="{{ asset('img/hajimete/service32.jpg') }}" width="800px" height="70px"></p>
                    <br>
                    <p>■種の保存に関する法律により指定を受けている国内希少野生動植物種を採取し出品することはできません。<br></p><br>
                    <p><a href="https://www.env.go.jp/nature/kisho/domestic/list.html#honyurui" target="_blank"
                          class="reference">【国内希少野生動物種一覧】 👈こちらをクリック</a><br><br></p>
                    <p><br><img src="{{ asset('img/hajimete/service33.jpg') }}" width="800px" height="70px"></p>
                    <br>
                    <p>■厚生労働省が「自然毒のリスクプロファイル」で指定する鮮魚類等を出品することはできません。<br></p><br>
                    <p>
                        <a href="https://www.mhlw.go.jp/stf/seisakunitsuite/bunya/kenkou_iryou/shokuhin/syokuchu/poison/index.html"
                           target="_blank" class="reference">【自然毒のリスクプロファイル】 👈こちらをクリック</a><br></p><br><br>
                    <p><br><img src="{{ asset('img/hajimete/service34.jpg') }}" width="800px" height="70px"></p><br>
                    <br>
                    <p>■その他一般社会通念上「食用と認められるもの以外」の鮮魚類を出品することはできません。
                        <br>※禁止された出品・行為に関する詳細は利用規約をご参照ください。</p><br>
                    <p><a href="http://www.fukushihoken.metro.tokyo.jp/itiba/suisanbutu/index.html" class="reference">【東京都市場衛生検査所　百貝万魚　市場の水産物情報】👈こちらをクリック</a>
                    </p><br><br>
                    <br><br><br><br><br>
                </div>
            </div>
        </div>
    </div>
@endsection
