@extends('layouts.app')

@section('title', 'キャンセル返金について')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_system')
@section('css', 'cancel.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>キャンセル返金について</h2>
            <p class="font_avenirnext">cancel/Refund</p>
        </div>
    </div>

    <div class="cancel_info">
        <div class="layout">
            <div class="cancel">
                <div class="container">
                    <br>
                    <p>
                    <center><img src="{{ asset('img/hajimete/service47.jpg') }}" width="600" height="60"><br><br><img
                                src="{{ asset('img/hajimete/service48.jpg') }}" width="600" height="300"></center>
                    </p>
                    <br><br>
                    <p><b>釣魚商店では、飲食店等による仮決済が行われた後は、「原則キャンセルは出来ない」ルールとなっています。<br>ただし例外として以下のいずれかに当てはまる場合、当事者同士の協議により合意が得られた場合にのみ、キャンセルを認めるケースがございます。<br><br>会員の皆様におかれましては、その旨十分ご理解の上でご利用を頂けますようお願いいたします。</b>
                    </p><br><br>

                    <p>■キャンセルの受付が検討可能なケース<br><br>
                        配達された釣魚等が事前の情報と魚種が異なっていた場合<br>
                        配達された釣魚等の鮮度が著しく劣化していた場合<br>
                        配達された釣魚等が配送の途中で著しく損傷していた場合<br>
                        配達された釣魚等が「食品安全衛生法」「漁業法」等の関連法律に抵触する場合<br>
                        その他、出品者に明らかな悪意が見られる場合</p><br><br>
                    <p><font color="#ffbflf"
                        ><b>※取引中止に関する規定に関する詳細は利用規約等をご参照ください。</b></font></p><br><br><br><br>
                </div>
            </div>
        </div>
    </div>
@endsection
