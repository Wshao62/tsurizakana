@extends('layouts.app')

@section('title', '直接取引の禁止')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_directtrading')
@section('css', 'directtrading.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>直接取引の禁止</h2>
            <p class="font_avenirnext">Transfer application</p>
        </div>
    </div>

    <div class="directtrading_info">
        <div class="layout">
            <div class="directtrading">
                <div class="container">
                    <p><br><img src="{{ asset('img/hajimete/service39.jpg') }}" width="800px" height="80px"></p>
                    <p><br><br>釣魚商店では、釣り人と飲食店が直接取引をする事は禁止しております。以下の禁止事項にある行為を持ち掛けられた場合は、釣魚事務局までご一報ください。<br><br></p>
                    <p><br><img src="{{ asset('img/hajimete/service40.jpg') }}" width="800px" height="80px"></p>
                    <p><br>■釣魚商店の決済を利用しない支払い
                        <br><br></p><br>
                    <p><br><img src="{{ asset('img/hajimete/service41.jpg') }}" width="800px" height="80px"></p>
                    <p><br>■出品者が指定する口座への直接振込<br>

                        振込申請の締め日は、毎週月曜日です。<br>
                        振込は、振込申請の締め日から数えて4営業日目になります。<br><br>
                    </p>
                    <p><br><img src="{{ asset('img/hajimete/service42.jpg') }}" width="800px" height="80px"></p>
                    <br>
                    <p>■代金引換（配送時）に商品と代金を入れ替える配送方式<br><br>
                        <br><br></p>
                    <p><br><img src="{{ asset('img/hajimete/service43.jpg') }}" width="800px" height="80px"></p>
                    <br>
                    <p>■オンラインギフト券類での支払い<br><br>
                        <br><br></p>
                    <p><br><img src="{{ asset('img/hajimete/service44.jpg') }}" width="800px" height="80px"></p>
                    <br>
                    <p>■現金の手渡し<br><br>
                        <br><br></p>
                    <br><br><br><br><br>

                </div>
            </div>
        </div>
    </div>
@endsection
