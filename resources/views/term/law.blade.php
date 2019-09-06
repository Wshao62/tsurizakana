@extends('layouts.app')

@section('title', '特定商取引法に基づく表記')
@section('page_id', 'page_tokusho')
@section('css', 'term.css')

@section('content')
<div class="layout">
    <div class="title">
        <h2>特定商取引法に基づく表記</h2>
        <p class="font_avenirnext">ACT ON SPECIFIED COMMERCIAL TRANSACTIONS</p>
    </div>

    <div class="content">
        <dl>
            <dt class="title_middle">販売業者</dt>
            <dd>Cplan株式会社</dd>

            <dt class="title_middle">運営統括責任者名</dt>
            <dd>樋口 淳一</dd>

            <dt class="title_middle">メールアドレス</dt>
            <dd>higuchi@cplan-dcp.com</dd>

            <dt class="title_middle">電話番号</dt>
            <dd>0463-86-6984</dd>

            <dt class="title_middle">所在地</dt>
            <dd>〒254-0806 神奈川県平塚市夕陽ケ丘１番１６号 第１三富ビル３０２号</dd>

            <dt class="title_middle">商品代金以外の料金の説明</dt>
            <dd>ありません。</dd>

            <dt class="title_middle">送料について</dt>
            <dd>送料は無料です。</dd>

            <dt class="title_middle">販売価格帯</dt>
            <dd>各商品に表記された価格に準じます</dd>

            <dt class="title_middle">引渡し時期</dt>
            <dd>入金確認後、1~7日程度で発送</dd>

            <dt class="title_middle">お支払い方法</dt>
            <dd>クレジットカード</dd>

            <dt class="title_middle">お支払期限（時期）</dt>
            <dd>購入者確定後、当日中</dd>

            <dt class="title_middle">返品期限</dt>
            <dd>お客様都合による返品・交換は受け付けておりません<br>
                不良品については販売者への連絡対応を行ってください</dd>
        </dl>
    </div>
</div>
@endsection
