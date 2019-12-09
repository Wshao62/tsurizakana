@extends('layouts.app')

@section('title', 'システム利用料について')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_system')
@section('css', 'system.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>システム利用料について</h2>
            <p class="font_avenirnext">System Usage Fee</p>
        </div>
    </div>

    <div class="system_info">
        <div class="layout">
            <div class="system">
                <div class="container">
                    <p><font size="4em">【釣魚商店システム利用料について】</font></p><br>
                    <p>釣魚商店の利用料は、釣魚の取引が成立した場合のみ発生し、利用料の算出は以下の通りです。<br><br></p>
                    <div class="item">
                        <div align="center">
                            <img src="{{ asset('img/hajimete/service23.jpg') }}" alt="" width="400" height="90">
                            <br>
                            <img src="{{ asset('img/hajimete/service24.jpg') }}" alt="" width="200" height="100"></div>
                    </div>
                    <div class="item">
                        <div align="center">
                            <img src="{{ asset('img/hajimete/service25.jpg') }}" alt="" width="420" height="120">
                            <br>
                            <img src="{{ asset('img/hajimete/service24.jpg') }}" alt="" width="200" height="100"></div>
                    </div>
                    <br>
                    <div class="item">
                        <div align="center">
                            <img src="{{ asset('img/hajimete/service26.jpg') }}" alt="" width="200" height="30">
                            <br>
                            <img src="{{ asset('img/hajimete/service35.jpg') }}" alt="" width="400" height="60" 　></div>
                    </div>
                    <br>
                    <div class="item">
                        <div align="center">
                            <img src="{{ asset('img/hajimete/service27.jpg') }}" alt="" width="200" height="30">
                            <br>
                            <img src="{{ asset('img/hajimete/service28.jpg') }}" alt="" width="400" height="60">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
