@extends('layouts.app')

@section('title', 'サービスの流れ')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_service')
@section('css', 'service.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>サービス内容（取引の流れ）</h2>
            <p class="font_avenirnext">Service</p>
            <p><br>釣り人が釣った朝獲れ魚を、<br>欲しい飲食店等に売買することが出来るマッチングサービスです。<br>働き方改革で余暇時間が増える中、趣味を実益に替える手段としてご活用ください。</p>
        </div>
    </div>

    <div class="service_info">
        <div class="layout">
            <div class="service">
                <div class="main-content wrapper">
                    <article>

                        <table border="0">
                            <tr>
                                <th>釣り人</th>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="turibito">１．魚を釣る</p><br><img
                                                src="{{ asset('img/hajimete/service6.jpg') }}" width="150px"
                                                height="100px"></center>
                                    <br>
                                    <p>まずは魚を釣りましょう。<br>リクエストコーナーを見ると、飲食店が欲しがっている魚の情報を見ることが出来ます。</p><br><br><br>
                                    <center><img src="{{ asset('img/hajimete/service1.jpg') }}" width="30px"
                                                 height="20px"></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="turibito">２．出品する</p><br><img
                                                src="{{ asset('img/hajimete/service7.jpg') }}" width="160px"
                                                height="100px"></center>
                                    <br><br>
                                    <p>魚が釣れたら写真を撮り出品しましょう。</p><br><br><br>
                                    <center><img
                                                src="{{ asset('img/hajimete/service1.jpg') }}"
                                                width="30px" height="20px"></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="turibito">３．公開DMでやりとりする</p><br><img
                                                src="{{ asset('img/hajimete/service9.jpg') }}" width="110px"
                                                height="100px"></center>
                                    <br>
                                    <p>出品画面に飲食店から魚に関する質問が来ますので、回答しましょう。</p>  <br><br><br><br>
                                    <center><img
                                                src="{{ asset('img/hajimete/service1.jpg') }}"
                                                width="30px" height="20px"></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="turibito">４．個別DMで条件交渉する</p><br><img
                                                src="{{ asset('img/hajimete/service8.jpg') }}" width="150px"
                                                height="100px"></center>
                                    <br>
                                    <p>魚の詳細情報や配達場所・時間など個別の情報を調整しましょう。</p>  <br><br><br>
                                    <center><img
                                                src="{{ asset('img/hajimete/service1.jpg') }}"
                                                width="30px" height="20px"></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="turibito">５．販売先を決定する</p><br><br><img
                                                src="{{ asset('img/hajimete/service10.jpg') }}" width="120px"
                                                height="100px"></center>
                                    <p>購入希望者一覧から、配達しやすい相手を選び販売先を決定しましょう。 </p> <br><br><br><br>
                                    <center><img
                                                src="{{ asset('img/hajimete/service1.jpg') }}"
                                                width="30px" height="20px"></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="turibito">６．釣魚を持参する</p><br><img
                                                src="{{ asset('img/hajimete/service11.jpg') }}" width="130px"
                                                height="100px"></center>
                                    <br><br>
                                    <p>※宅配便での発送も可<br>釣魚をお店に届けましょう。</p>  <br><br><br>
                                    <center><img
                                                src="{{ asset('img/hajimete/service1.jpg') }}"
                                                width="30px" height="20px"></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="turibito">７．検品をする</p><br><img
                                                src="{{ asset('img/hajimete/service12.jpg') }}" width="160px"
                                                height="100px"></center>
                                    <br>
                                    <p>釣魚を確認してもらったあとに、購入者に「受取完了ボタン」を押してもらいましょう。ここで本決済が完了します。</p> <br><br>
                                    <center><img
                                                src="{{ asset('img/hajimete/service1.jpg') }}"
                                                width="30px" height="20px"></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="turibito">８．飲食店等を評価をする</p><br><img
                                                src="{{ asset('img/hajimete/service13.jpg') }}" width="130px"
                                                height="100px"></center>
                                    <br>
                                    <p>購入者を評価して、コメントを入力しましょう。次の取引の生かすことが出来ます。</p></td>
                            </tr>
                        </table>
                    </article>
                    <sab>
                        <table border="0">
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </sab>
                    <aside>
                        <table border="0">
                            <tr>
                                <th>飲食店等</th>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="omise">１．釣魚を閲覧する<br></p><br><img
                                                src="{{ asset('img/hajimete/service14.jpg') }}" width="170px"
                                                height="100px"></center>
                                    <br>
                                    <p>釣り人が出品している魚を閲覧しましょう。<br>18時になると閉店となり受付は終了するのでご注意ください。</p> <br><br><br>
                                    <center><img src="{{ asset('img/hajimete/service5.jpg') }}" width="30px"
                                                 height="20px"></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="omise">２．公開DMでやりとりする<br></p><br><img
                                                src="{{ asset('img/hajimete/service15.jpg') }}" width="110px"
                                                height="100px"></center>
                                    <br><br>
                                    <p>魚に関する確認事項を公開チャットで質問し、回答を待ちましょう。</p><br><br>
                                    <center><img
                                                src="{{ asset('img/hajimete/service5.jpg') }}"
                                                width="30px" height="20px"></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="omise">３．購入希望を出す<br></p><br><img
                                                src="{{ asset('img/hajimete/service16.jpg') }}"
                                                width="110px" height="100px"></center>
                                    <br>
                                    <p>欲しい魚が決まったら「購入希望をするボタン」を押して、「購入者決定通知」が届くのを待ちましょう。</p>  <br><br><br>
                                    <center><img src="{{ asset('img/hajimete/service5.jpg') }}" width="30px"
                                                 height="20px"></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="omise">４．購入者決定通知が届く<br></p><br><img
                                                src="{{ asset('img/hajimete/service17.jpg') }}" width="80px"
                                                height="100px"></center>
                                    <br>
                                    <p>配達エリア等の条件が合致していると、釣り人から購入者決定通知が届きます。</p> <br><br><br>
                                    <center><img
                                                src="{{ asset('img/hajimete/service5.jpg') }}"
                                                width="30px" height="20px"></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="omise">５．個別DMで条件交渉する<br></p><br><img
                                                src="{{ asset('img/hajimete/service18.jpg') }}" width="150px"
                                                height="100px"></center>
                                    <br>
                                    <p>「購入者決定通知」が届くと、「売魚詳細画面」が開設され、そこで個別DMで釣り人とやり取りができます。</p> <br><br><br>
                                    <center><img
                                                src="{{ asset('img/hajimete/service5.jpg') }}"
                                                width="30px" height="20px"></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="omise">６．仮決済をする<br></p><br><img
                                                src="{{ asset('img/hajimete/service19.jpg') }}" width="180px"
                                                height="100px"></center>
                                    <br>
                                    <p>個別DMでの条件調整が完了した後、クレジットカードの仮決済を行います。本決済は魚を受け取り「受取確認ボタン」を押した後になります。 </p><br><br>
                                    <center><img src="{{ asset('img/hajimete/service5.jpg') }}" width="30px"
                                                 height="20px"></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="omise">７．釣魚を受け取る<br></p><br><img
                                                src="{{ asset('img/hajimete/service20.jpg') }}" width="170px"
                                                height="100px"></center>
                                    <br>
                                    <p>個別DMで調整した店舗に、釣り人が魚を配達してくれます。</p>  <br><br><br>
                                    <center><img src="{{ asset('img/hajimete/service5.jpg') }}" width="30px"
                                                 height="20px"></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="omise">８．検品する<br></p><br><img
                                                src="{{ asset('img/hajimete/service21.jpg') }}" width="160px"
                                                height="100px"></center>
                                    <br>
                                    <p>釣魚を確認しましょう。問題なければ「受取確認ボタン」を押して取引を完了させましょう。</p><br>
                                    ※「受取確認ボタン」を押すと、クレジットカードが本決済へと進みます。 <br><br><br>
                                    <center><img src="{{ asset('img/hajimete/service5.jpg') }}" width="30px"
                                                 height="20px"></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><p class="omise">９．釣り人を評価する<br></p><br><img
                                                src="{{ asset('img/hajimete/service22.jpg') }}" width="100px"
                                                height="100px"></center>
                                    <br>
                                    <p>釣り人を評価して、コメントを入力しましょう。釣り人の励みになり、次の取引につながります。</p></td>
                            </tr>
                        </table>
                    </aside>
                </div>
            </div>
        </div>
    </div>
@endsection
