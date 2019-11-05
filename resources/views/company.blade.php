@extends('layouts.app')

@section('title', '運営会社')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」の運営会社紹介ページです。運営会社・株式会社CPLANの詳細はこちらでご覧ください。')
@section('page_id', 'page_company')
@section('css', 'company.css')

@section('content')
    <div class="layout">
        <div class="title">
        <h2>会社概要</h2>
        <p class="font_avenirnext">COMPANY</p>
        </div>
        <div class="company">
        <h3 class="company_title content_title_middle">運営会社</h3>
        <table class="company_table">
            <tr><th>会社名</th><td>株式会社 自給他足</td></tr>
            <tr><th>所在地</th><td>〒254-0806<br>神奈川県平塚市夕陽ケ丘１番１６号 第１三富ビル３F</td></tr>
            <tr><th>資本金</th><td>850万円</td></tr>
            <tr><th>代表者</th><td>樋口 淳一</td></tr>
            {{-- TODO: 事業内容のテキスト作成 --}}
            {{-- <tr><th>事業内容</th><td class="company_table_small">テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。</td></tr> --}}
        </table>
        </div>
    </div>
    <div class="map">
        <div class="layout">
        <h3 class="map_title content_title_middle">アクセス</h3>
        <div class="map_frame">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3255.299631844856!2d139.3526816868146!3d35.32338022551308!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6019ad21a8d96a55%3A0x3cecc51742574022!2z5qCq5byP5Lya56S-IENwbGFu!5e0!3m2!1sja!2sjp!4v1543817257688" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
        <div class="map_address">
            <p>住所：〒254-0806 神奈川県平塚市夕陽ケ丘１番１６号 第１三富ビル３０２号</p>
            <a href="https://goo.gl/maps/cqzF5vgf1X72" target="blank">Google Mapで確認する</a>
        </div>
        </div>
    </div>
@endsection
