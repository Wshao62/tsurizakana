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
            <!-- 全体のサービスについて -->
            <div class="js_tab_baloon_inner tab_baloon_inner current">
                <div class="new-content wrapper">
                    <article><p class="tab">釣魚商店をご利用前に</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>サービスの利用にはお金がかかりますか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>サービスの利用にお金はかかりません。唯一魚を購入する時に魚の値段分の支払いが発生します。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>利用規約はありますか？<br
                                            class="hide_pc">また、フォローなどはしてもらえますか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>以下のリンク先からご確認くださいますようお願い致します。<a
                                            herf="https://www.turizakana/#">【釣魚商店利用規約】</a></span></p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>どのようなサービスなのですか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚商店は、釣り人と魚を買いたい人を繋げるマッチングサービスです。釣り人が釣った魚をサービスに掲載する事で、購入者はその魚達を釣り人から直接買取る事が出来ます。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>会員登録をするのに料金はかかりますか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚商店の会員登録は無料です。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>取引時にトラブルなどは発生しますか？また、フォローなどはしてもらえますか？？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>トラブルの発生は考えられます。その際は運営事務局までお問い合わせください。</span>
                            </p>
                        </div>

                        <p class="tab">サイト利用</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>釣魚商店へ問い合わせをしたい</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚商店サイト内にあるお問合せからお願いいたします。回答までに２営業日いただいておりますので、ご了承ください。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>サポートしているブラウザを教えてください。</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>サポートブラウザは次のとおりです。<br>PC版動作環境：Google Chrome最新版<br> スマートフォン版動作環境：各OSで標準搭載されているブラウザ、Google Chrome。<br></span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line"><p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>釣魚リクエストとは何ですか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>飲食店の方が、釣り人へ欲しい魚を事前にリクエストとして、お願い出来るサービスです。<br></span>
                            </p></div>
                        <div class="js_faq_line faq_line"><p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>気に入った釣人や飲食店を保存したい、お気に入りに登録したい</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>お気に入りに登録したい釣人や店舗を選択していただき、「このユーザーのプロフィールを見る」を選択します。以降検討<br></span>
                            </p></div>


                        <p class="tab">支払い</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>釣魚の決済方法は何がありますか？</span></p>
                            <p class="faq_line_text"><span
                                        class="font_avenirnext">A.</span><span>釣魚商店の決済時方法は以下の通りです。<br>クレジットカードのみ<br>・JCB<br>・VISA<br>・Master<br>・AMERICAN<br>　EXPRESS<br>・ANA</span>
                            </p>
                        </div>

                        <div class="js_faq_line faq_line"><p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>釣り人と、店舗間での現金で直接支払いは可能ですか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚商店では直接現金での手渡しは禁止しております。詳しくは、釣魚商店禁止行為及び利用規約をご確認ください。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>銀行振込で決済を行いたいのに、選択出来ない</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>決済方法は、クレジットカードのみとなっております。クレジット情報をご登録いただいてから、決済を行ってくださいますようお願いいたします。</span>
                            </p>
                        </div>

                        <p class="tab">領収書</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>領収書は発行出来ますか？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚商店のマイページへログインしていただき、「売上管理」画面から、領収書を発行していただけます。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>領収書は月ごとに発行出来ますか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>月ごとに発行が可能です。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>領収書を郵送して欲しい</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>領収書を郵送するサービスは行っておりません。釣魚商店の”ご利用日以降”にマイページの「領収書」ボタンより発行をお願い致します。</span>
                            </p>
                        </div>
                    </article>
                    <!-- ここから -->
                    <aside>
                        <p class="tab">キャンセル・返金</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>購入をキャンセルした場合の返金について</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>キャンセル返金につきましては、魚を受け取りる際に、ご確認いただき、受け取り完了ボタンをクリックするまでは、本決済はなされません。受け取り完了のボタンをクリックする前に、キャンセルした場合ば、本決済が取り消しとなりますので、キャンセル返金は発生いたしません。</span>
                            </p>
                        </div>

                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>購入のキャンセルがしたい</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>マイページの売魚取引一覧画面から、キャンセルしたいお取引売魚を選択していただき、「×このユーザとの取引を中止する」ボタンを押下していただきますと、お取引が中止となりキャンセルお手続きが完了となります。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>キャンセル料はかかりますか？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>キャンセル料はかかりません。</span>
                            </p>
                        </div>
                        <p class="tab">アカウント登録・情報変更</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>振込申請をした場合の自分の口座はどうやって登録するの？<br
                                            class="hide_pc">また、口座が変更した場合はどうした良いですか？</span></p>
                            <p class="faq_line_text"><span
                                        class="font_avenirnext">A.</span><span>銀行口座情報のご登録方法は以下となります。<br>①マイページへログイン後、「プロフィール編集」をクリックします。②プロフィール編集画面に、銀行口座情報をご登録をお願いいたします。口座が変更になった場合も、プロフィール編集画面にて、編集が可能です。こちらの登録は弊社にて代理のご登録は出来かねますので、ご本人様にてご登録いただけますよう、どうぞよろしくお願いいたします。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>本人確認について</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>運転免許証・健康保険証・その他いづれか１つを選択していただき、書類をアップロードしてください。運営側の審査結果が４営業日以内にご登録メールアドレスに届きますので、承認後、釣魚商店をご利用いただけます。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>登録したメールアドレスにメールが届かない</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>迷惑メールフォルダに返信が無いかご確認ください。携帯電話のキャリアドメインを利用したメールアドレスの場合、釣魚商店のドメイン(@tsurizakana-shoten.jp)の受信許可設定をお願い致します。
・上記で改善されない場合は、gmail等アドレスを新規に作成いただき、再度アカウント登録してください。</span></p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>パスワードを忘れてしまった</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>パスワードを忘れてしまった場合は、釣魚商店のログイン画面にある「パスワードを忘れた方はこちら」をクリックしていただき、メールアドレスを入力後、「パスワード再設定」を行ってください。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>アカウントが使えなくなった</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>利用規約に従い、利用者のアカウントを制限・停止・削除する場合がございますので、ご了承ください。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>登録した住所や電話番号を変更するのは、どうしたら良いですか？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>住所や電話番号の変更は、マイページへログイン後、「プロフィール編集」画面より編集していただけます。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>退会したい</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>テキスト</span></p>
                        </div>

                    </aside>
                </div>
            </div>

            <!-- 釣り人でご利用の方 -->
            <div class="js_tab_baloon_inner tab_baloon_inner">
                <div class="new-content wrapper">
                    <article><p class="tab">サイト利用</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>サービスの利用にはお金がかかりますか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>サービスの利用にお金はかかりません。唯一魚を購入する時に魚の値段分の支払いが発生します。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>スマートフォンからの登録は可能でしょうか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>はい。可能です。PCだけでなくスマートフォンサイト、今後はアプリでもサービスをご提供予定です。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>配送料についての負担は？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣り人側のご負担となりす。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>本人認証について</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>利用者様から身分証を登録いただきトラブル履歴やブラックリストと照合いたします。</span>
                            </p>
                        </div>
                        <p class="tab">売上</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>システム利用料について教えてください。<br class="hide_pc">また、販売手数料とは何ですか？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚商店のシステムを利用するための手数料です。システム利用料につきましては、会員登録・月会費・出品・購入時にお金はかかりません。魚が売れた時は、釣魚の販売履歴×１０％となっております。また、売上を引き出す時は、振込事務手数料×400円がかかります。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>売上はどこで確認出来ますか？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>売上のご確認は、「マイページ」の「売上・振込申請管理」からご確認いただけます。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>売上はいつ入金されますか？<br
                                            class="hide_pc">また、振込申請の締め日などはありますか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>売上につきましては、お取引が完了した時点で、マイページの「売上・振込申請管理」に反映させていただきます。振込申請の締め日は、毎週月曜日となっており、振込申請日から数えて４営業日以降の毎週金曜日にお振込みいたします。</span>
                            </p>
                        </div>

                        <p class="tab">釣魚の管理</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>毒のある魚を出品し、被害が出た場合はどうなりますか？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚商店は釣り人と店舗マッチングサービスになります。あくまでもプラットフォームに過ぎません。被害が出た場合は、出品者側の過失となります。詳しくは利用規約をご確認ください。ただし弊社としましても問題ががあると判断された聚富んしゃは登録抹消するなど対応を行います。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>違法な方法で採取した商品を出品した場合、どうなりますか？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>問題があると判断された出品者は登録抹消するなど対応を行います。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>釣魚の加工をしても良いですか？<br
                                            class="hide_pc">また、店舗から依頼された場合はどうしたら良いですか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚商店では、釣魚の加工は禁止させていただいております。店舗から依頼された場合も同様です。但し、鮮度を保つことを目的とした「血抜き」「内臓抜き」等を施したものは可とします。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>冷蔵庫で保存した魚は出品しても良いですか？<br
                                            class="hide_pc">また、何時間までなら貯蔵しても良いですか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>冷蔵庫での貯蔵は、１２時間までとさせていただいております。１２時間以上経過した釣魚は出品することは出来ません。</span>
                            </p>
                        </div>

                        <p class="tab">出品</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>出品の時にお金はかかりますか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>出品時にお金はかかりません。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>食用以外の魚を出品しても良いですか<br
                                            class="hide_pc">また、観賞用として魚を出品しても良いですか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚商店では、食用と認められるもの以外の鮮魚類出品禁止とさせていただいております。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>自分が釣った魚以外でも出品して良いですか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>自身が釣った魚以外のものを出品することは出来ません。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>写真をアップロードできません。<br
                                            class="hide_pc">掲載する写真の容量はきまってますかか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>写真のアップロードは合計５MBまでとなっております。３枚までの掲載がか可能です。</span>
                            </p>
                        </div>
                    </article>
                    <aside><p class="tab">キャンセル対応</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>お取引確定後、釣人の都合でキャンセルしたい。</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>必ず店舗側へ事情を説明し、店舗との合意の上取引詳細画面にて、「このユーザーとのお取り引きをキャンセルする」ボタンをクリックしてください。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>キャンセル料などは発生しますか？<br
                                            class="hide_pc"></span></p>
                            <p class="faq_line_text"><span
                                        class="font_avenirnext">A.</span><span>キャンセル料等は発生いたしません。</span></p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>取引が店舗によってキャンセルになった場合、返金はどうなりますか？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>キャンセル返金につきましては、魚を受け取りる際に、ご確認いただき、受け取り完了ボタンをクリックするまでは、本決済はなされません。受け取り完了のボタンをクリックする前に、キャンセルした場合ば、本決済が取り消しとなりますので、キャンセル返金は発生いたしません。</span>
                            </p>
                        </div>

                        <p class="tab">その他</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>クール便で無いと駄目ですか？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>必ずしもクール便である必要はありません。発送方法につきましては、店舗側と協議の上、決めていただければと思います。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>どこの海で釣った魚でも大丈夫でしょうか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>登録の際に、釣れた場所を登録ください。法律上、違法海域での釣りはご遠慮ください。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>サービスの利用にはお金がかかりますか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>サービスの利用にお金はかかりません。唯一魚を購入する時に魚の値段分の支払いが発生します。</span>
                            </p>
                        </div>
                    </aside>
                </div>
            </div>
            <!-- 店舗でご利用の方 -->
            <div class="js_tab_baloon_inner tab_baloon_inner">
                <div class="new-content wrapper">
                    <article><p class="tab">サイト利用</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>店舗での店舗証明等は必要ですか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>マイページTOPから、店舗情報をご登録いただけます。釣魚商店では、安全にお取引いただく為に、店舗でご利用の際には、営業許可証のご提出をお願いしています。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line"><p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>どんな魚がありますか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>時期によって掲載される魚は異なります。掲載している魚をご確認ください。</span>
                            </p></div>
                        <div class="js_faq_line faq_line"><p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>欲しい魚のリクエストは可能ですか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>はい、可能です。店舗で欲しい魚をオファーすることが可能ｄす。</span>
                            </p></div>
                        <p class="tab">支払い</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>どのような方法で支払い出来ますか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>クレジットカードでのお支払いが可能です。銀行振込は行っておりませんのでご了承ください。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>サービスの利用にはお金がかかりますか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>サービスの利用にお金はかかりません。唯一魚を購入する時に魚の値段分の支払いが発生します。</span>
                            </p>
                        </div>
                        <p class="tab">釣魚の受け取り</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>寄生虫がついていた場合はどうなりますか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>寄生虫の存在の有無は解体しないと分かりません。釣り人、店舗側が責任を持って対処くださりますようお願いいたします。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>違法な方法で採取した商品が出品されているのを見つけた場合どうしたら良いですか？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚商店運営事務局までお知らせください。問題があると判断された出品者は登録抹消するなど対応を行います。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>写真や産地などを偽装した人を発見した場合はどうしたら良いですか？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>運営事務局までお問合せください。出品者の登録抹消をするなど対応を行います。</span>
                            </p>
                        </div>
                    </article>
                    <!-- ２段目 -->
                    <aside><p class="tab">キャンセル</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>受け取り時にリクエストした魚と全く違う魚が届いた場合はどうしたら良いですか？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚を受け取り時に、相違があった場合は「受け取り完了」ボタンをクリックせずに、釣人との合意の上「キャンセルする」ボタンをクリックください。お取引が中止となり、本決済の取り消しとなります。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>キャンセル料などは発生しますか？<br
                                            class="hide_pc"></span></p>
                            <p class="faq_line_text"><span
                                        class="font_avenirnext">A.</span><span>キャンセル料等は発生いたしません。</span></p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>キャンセルになった場合、返金はどうなりますか？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>キャンセル返金につきましては、魚を受け取りる際に、ご確認いただき、受け取り完了ボタンをクリックするまでは、本決済はなされません。受け取り完了のボタンをクリックする前に、キャンセルした場合ば、本決済が取り消しとなりますので、キャンセル返金は発生いたしません。</span>
                            </p>
                        </div>
                        <p class="tab">領収書</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>領収書は発行出来ますか？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚商店のマイページへログインしていただき、「売上管理」画面から、領収書を発行していただけます。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span
                                        class="font_avenirnext">Q.</span><span>領収書は月ごとに発行出来ますか？</span></p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>月ごとに発行が可能です。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>領収書を郵送して欲しい</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>領収書を郵送するサービスは行っておりません。釣魚商店の”ご利用日以降”にマイページの「領収書」ボタンより発行をお願い致します。</span>
                            </p>
                        </div>
                        <p class="tab">その他</p>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>配送料についての負担は？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣り人側のご負担となります。</span>
                            </p>
                        </div>
                        <div class="js_faq_line faq_line">
                            <p class="faq_line_title"><span class="font_avenirnext">Q.</span><span>釣り人と、店舗間での現金で直接支払いは可能ですか？</span>
                            </p>
                            <p class="faq_line_text"><span class="font_avenirnext">A.</span><span>釣魚商店では直接現金での手渡しは禁止しております。詳しくは、釣魚商店禁止行為及び利用規約をご確認ください。</span>
                            </p>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
@endsection
