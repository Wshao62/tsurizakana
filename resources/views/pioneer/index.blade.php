@extends('layouts.app')

@section('title', '飲食店会員開拓希望について')
@section('meta_description', '釣り人と魚を買いたい人を繋げるマッチングサービス「釣魚商店」のサービス概要をご説明しているページです。魚の売り買いが個人間でも出来る画期的なプラットフォームをぜひご利用ください。')
@section('page_id', 'page_pioneer')
@section('css', 'pioneer.css')
@section('not_need_header_img', true)

@section('content')
    <div class="layout">
        <div class="title">
            <h2>飲食店会員開拓希望について</h2>
            <p class="font_avenirnext">New restaurant development</p>
            <p class="tag"><br><br>あなたのおうちの近くの飲食店会員を開拓して欲しい！<br>
                そんな希望を持ちの方、下記フォームよりご登録いただきますと<br>釣魚商店運営局によるご希望の店舗へ新規開拓をさせていただきます！<br>※店舗の都合等により、ご希望の飲食店への新規開拓のお約束は<br>出来ませんのでご了承ください。</p>
        </div>
    </div>

    <div class="layout_pioneer">

        <div class="flow">
            <p class="current"><span>飲食店開拓希望情報入力</span></p>
            <p><span>入力情報確認</span></p>
            <p><span>入力完了</span></p>
        </div>
    </div>
    <div class="pioneer">
        <div class="layout_pioneer">
            <p class="pioneer_info">飲食店会員開拓希望についての情報は下記フォームより<br class="hide_pc">お願いいたします。<br>
                ご希望の飲食店への確認後、<br class="hide_pc">追って担当者よりご連絡させていただきます。</p>
            <form class="pioneer_form">
                <center><b><p>ご登録者様情報</p></b></center><br>
                <div class="pioneer_form_split require">
                    <p class="pioneer_form_split_title">お名前</p>
                    <div class="pioneer_form_split_content pioneer_form_split_content_name">
                        <div>
                            <p>
                                <label for="pioneer_form_family">姓</label>
                                <input id="pioneer_form_family" class="narrow" placeholder="（例）佐藤">
                            </p>
                            <p>
                                <label for="pioneer_form_name">名</label>
                                <input id="pioneer_form_name" class="narrow" placeholder="（例）太郎">
                            </p>
                        </div>
                        <p class="alert">お名前を入力してください。</p>
                    </div>
                </div>
                <div class="pioneer_form_split require">
                    <p class="pioneer_form_split_title">メールアドレス</p>
                    <div class="pioneer_form_split_content">
                        <input class="wide" placeholder="●●●●●＠oooooo.co.jp">
                        <p class="alert">メールアドレスを入力してください。</p>
                    </div>
                </div><br><br>
                <center><p>新規開拓ご希望店舗情報</p></center><br><br>
                <div class="pioneer_form_split require">

                    <p class="pioneer_form_split_title">新規開拓希望の店舗種類</p>
                    <div class="pioneer_form_split_content pioneer_radio">
                        <label class="pioneer_radio_label"><input type="radio" name="pioneer_radio_item" value="居酒屋" checked="checked"><span>居酒屋</span></label>
                        <label class="pioneer_radio_label"><input type="radio" name="pioneer_radio_item" value="寿司屋"><span>寿司屋</span></label>
                        <label class="pioneer_radio_label"><input type="radio" name="pioneer_radio_item" value="日本食"><span>日本食</span></label>
                        <label class="pioneer_radio_label"><input type="radio" name="pioneer_radio_item" value="その他"><span>その他</span></label>
                    </div>
                </div>
                <div class="pioneer_form_split require">
                    <p class="pioneer_form_split_title">店舗名</p>
                    <div class="pioneer_form_split_content">
                        <input class="wide" placeholder="居酒屋　釣魚商店">
                        <p class="alert">店舗名を入力してください。</p>
                    </div></div>
                <div class="pioneer_form_split require">
                    <p class="pioneer_form_split_title">電話番号</p>
                    <p class="pioneer_form_split_content pioneer_form_split_content_info"><input class="middle" placeholder="000000000"><span class="info">ハイフンなし、半角英数にてご入力ください。</span></p>
                </div>
                <div class="pioneer_form_box">
                    <div class="pioneer_form_box_inner">
                        <p class="pioneer_form_split_title">郵便番号</p>
                        <p class="pioneer_form_split_content pioneer_form_split_content_info"><input class="narrow" placeholder="000-000"><span class="info">ハイフンなし、半角英数にてご入力ください。</span></p>
                    </div>
                    <div class="pioneer_form_box_inner">
                        <span class="pioneer_form_split_title">都道府県</span>
                        <span class="pioneer_form_split_content">
                <label class="pioneer_select">
                  <select name="prefecture">
                    <option value="北海道">北海道</option>
                    <option value="青森県">青森県</option>
                    <option value="岩手県">岩手県</option>
                    <option value="秋田県">秋田県</option>
                    <option value="宮城県">宮城県</option>
                    <option value="山形県">山形県</option>
                    <option value="福島県">福島県</option>
                    <option value="新潟県">新潟県</option>
                    <option value="茨城県">茨城県</option>
                    <option value="栃木県">栃木県</option>
                    <option value="群馬県">群馬県</option>
                    <option value="埼玉県">埼玉県</option>
                    <option value="千葉県">千葉県</option>
                    <option value="東京都" selected="">東京都</option>
                    <option value="神奈川県">神奈川県</option>
                    <option value="長野県">長野県</option>
                    <option value="山梨県">山梨県</option>
                    <option value="静岡県">静岡県</option>
                    <option value="岐阜県">岐阜県</option>
                    <option value="愛知県">愛知県</option>
                    <option value="富山県">富山県</option>
                    <option value="石川県">石川県</option>
                    <option value="福井県">福井県</option>
                    <option value="滋賀県">滋賀県</option>
                    <option value="三重県">三重県</option>
                    <option value="京都府">京都府</option>
                    <option value="奈良県">奈良県</option>
                    <option value="和歌山県">和歌山県</option>
                    <option value="大阪府">大阪府</option>
                    <option value="兵庫県">兵庫県</option>
                    <option value="岡山県">岡山県</option>
                    <option value="鳥取県">鳥取県</option>
                    <option value="島根県">島根県</option>
                    <option value="広島県">広島県</option>
                    <option value="山口県">山口県</option>
                    <option value="香川県">香川県</option>
                    <option value="愛媛県">愛媛県</option>
                    <option value="徳島県">徳島県</option>
                    <option value="高知県">高知県</option>
                    <option value="福岡県">福岡県</option>
                    <option value="佐賀県">佐賀県</option>
                    <option value="大分県">大分県</option>
                    <option value="長崎県">長崎県</option>
                    <option value="熊本県">熊本県</option>
                    <option value="宮崎県">宮崎県</option>
                    <option value="鹿児島県">鹿児島県</option>
                    <option value="沖縄県">沖縄県</option>
                  </select>
                </label>
              </span>
                    </div>
                    <div class="pioneer_form_box_inner">
                        <span class="pioneer_form_split_title">住所1</span>
                        <span class="pioneer_form_split_content"><input class="wide" placeholder="日本橋浜町3-29-5"></span>
                    </div>
                    <div class="pioneer_form_box_inner">
                        <span class="pioneer_form_split_title">住所2</span>
                        <span class="pioneer_form_split_content"><input class="wide" placeholder="菱和パレス日本橋浜町303日本橋浜町3-29-5"></span>
                    </div>
                </div>

                <div class="pioneer_form_split">
                    <p class="pioneer_form_split_title">ご要望やご希望等</p>
                    <p class="pioneer_form_split_content"><textarea class="wide"></textarea></p>
                </div>
                <div class="pioneer_privacy">
                    <p class="pioneer_privacy_title">個人情報の取り扱いについて</p>
                    <div class="pioneer_privacy_box">
                        <p class="pioneer_privacy_box_title">利用目的</p>
                        <p class="pioneer_privacy_box_text pioneer_privacy_box_text_small">
                            お預かりする個人情報は、本人からお問い合わせいただいたご質問等の内容に回答させていただくことを目的として収集し、
                            それ以外に利用することはありません。<br>また、いただいた個人情報を第三者に提供することはありません。
                        </p>
                        <p class="pioneer_privacy_box_title">その他</p>
                        <p class="pioneer_privacy_box_text">その他の個人情報取扱い方針につきましては、<a href="/term/privacy.html" class="point">個人情報保護方針で開く</a>をご覧下さい。</p>
                    </div>
                    <div class="pioneer_privacy_check js_checkbox">
                        <label><input type="checkbox"><span>個人情報の取り扱いに同意する</span></label>
                    </div>
                </div>
                <button class="content_button_arrow js_checkbox_area" type="submit" disabled><a href="pioneerconfirm.html">入力内容の確認画面へ</a></button>
            </form>
        </div>
    </div>

    <!-- ↓SPのみアプリダウンロード（下層全ページ共通） -->
    <div class="sp sp_app">
        <div class="spa_cont">
            <p class="white">\&nbsp;&nbsp;アプリのダウンロードはこちらから！&nbsp;/</p>
            <a class="sp_apple" href="#"><img src="{{ asset('img/store_apple.png') }}"></a>
            <a class="sp_google" href="#"><img src="{{ asset('img/store_google.png') }}"></a>
        </div>
    </div>
@endsection
