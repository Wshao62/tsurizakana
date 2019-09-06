          <div class="container">
            @if (session('contacted'))
            <span>
            <p class="contact_success">
            お問い合わせいただき、ありがとうございます。<br>
            後ほど担当者から折り返しご連絡差し上げます。
            </p>
            </span>
            @endif
            <form  method="POST" action="{{ url('contact') }}">
              @csrf
              <dl class="forms">
                <dt>お名前<span>必須</span></dt>
                <dd>
                  <div class="form form_name">
                    <label>
                      <input type="text" name="name" value="{{ old('name') }}">
                    </label>
                    @if ($errors->has('name'))
                        <span class="error">
                            {{ $errors->first('name') }}
                        </span>
                    @endif
                  </div>
                </dd>
                <div class="clear"></div>

                <dt>メールアドレス<span>必須</span></dt>
                <dd>
                  <div class="form form_mail">
                    <label class="mail_label">
                      <input type="text" name="contact_email" value="{{ old('contact_email') }}">
                    </label>
                    @if ($errors->has('contact_email'))
                        <span class="error">
                            {{ $errors->first('contact_email') }}
                        </span>
                    @endif
                    <div class="clear"></div>
                  </div>
                </dd>
                <div class="clear"></div>

                <dt>電話番号
                    <span>必須</span>
                </dt>

                <dd>
                  <div class="form form_phone">
                    <label>
                      <input type="text" name="tel1" value="{{ old('tel1') }}">
                    </label>
                    <p>ー</p>
                    <label>
                      <input type="text" name="tel2" value="{{ old('tel2') }}">
                    </label>
                    <p>ー</p>
                    <label>
                      <input type="text" name="tel3" value="{{ old('tel3') }}">
                    </label>
                  </div>
                  <div class="clear"></div>
                  @if ($errors->has('tel1'))
                      <span class="error">
                          {{ $errors->first('tel1') }}
                      </span>
                    </br>
                  @endif
                  @if ($errors->has('tel2'))
                      <span class="error">
                          {{ $errors->first('tel2') }}
                      </span>
                    </br>
                  @endif
                  @if ($errors->has('tel3'))
                      <span class="error">
                          {{ $errors->first('tel3') }}
                      </span>
                      </br>
                  @endif
                </dd>
                <div class="clear"></div>
                <dt>お問い合わせ内容
                    <span>必須</span>
                </dt>
                <dd>
                  <div class="form form_content">
                    <label>
                      <textarea name="description" rows="8" cols="80">{{ old('description') }}</textarea>
                    </label>
                    @if ($errors->has('description'))
                        <span class="error">
                            {{ $errors->first('description') }}
                        </span>
                    @endif
                  </div>
                </dd>
                <div class="clear"></div>
              </dl>
              <div class="privacy">
                <h3>個人情報保護方針</h3>
                <h4>１.プライバシーポリシー（または個人情報保護方針）</h4>
                <p>
                  当社は、当社が取得した個人情報の取扱いに関し、個人情報の保護に関する法律、個人情報
                  保護に関するガイドライン等の指針、その他個人情報保護に関する関係法令を遵守します。
                </p>
                <h4>２.個人情報の安全管理</h4>
                <p>
                  当社は、個人情報の保護に関して、組織的、物理的、人的、技術的に適切な対策を実施し、
                  当社の取り扱う個人情報の漏えい、滅失又はき損の防止その他の個人情報の安全管理のために
                  必要かつ適切な措置を講ずるものとします。
                </p>
                <h4>３.個人情報の取得等の遵守事項</h4>
                <p>
                  当社による個人情報の取得、利用、提供については、以下の事項を遵守します。<br><br>
                  (1)個人情報の取得<br><br>
                  当社は、当社が管理するインターネットによる情報提供サイト（以下「本サイト」といいます。）
                  の運営に必要な範囲で、本サイトの一般利用者（以下「ユーザー」といいます。）又は本サイトに広告掲載
                  を行う者（以下「掲載主」といいます。）から、ユーザー又は掲載主に係る個人情報を取得することがあります。<br><br>
                  (2)個人情報の利用目的<br><br>
                  当社は、当社が取得した個人情報について、法令に定める場合又は本人の同意を得た場合を除き、以下に定める利用目的の
                  達成に必要な範囲を超えて利用することはありません。<br><br>
                  ①&nbsp;&nbsp;本サイトの運営、維持、管理<br><br>
                  ②&nbsp;&nbsp;サイトを通じたサービスの提供及び紹介<br><br>
                  ③&nbsp;&nbsp;本サイトの品質向上のためのアンケート<br><br>
                  (3)個人情報の提供等<br><br>
                  当社は、法令で定める場合を除き、本人の同意に基づき取得した個人情報を、本人の事前の同意なく第三者に提供することは
                  ありません。なお、本人の求めによる個人情報の開示、訂正、追加若しくは削除又は利用目的の通知については、
                  法令に従いこれを行うとともに、ご意見、ご相談に関して適切に対応します。<br><br>
                  ４.個人情報の利用目的の変更<br><br>
                  当社は、前項で特定した利用目的は、予め本人の同意を得た場合を除くほかは、原則として変更しません。
                  但し、変更前の利用目的と相当の関連性を有すると合理的に認められる範囲において、予め変更後の利用目的を公表の上で
                  変更を行う場合はこの限りではありません。<br><br>
                  ５.個人情報の第三者提供<br><br>
                  当社は、個人情報の取扱いの全部又は一部を第三者に委託する場合、その適格性を十分に審査し、
                  その取扱いを委託された個人情報の安全管理が図られるよう、委託を受けた者に対する必要かつ適切な監督を行うこととします。<br><br>
                  ６.個人情報の取扱いの改善・見直し<br><br>
                  当社は、個人情報の取扱い、管理体制及び取組みに関する点検を実施し、継続的に改善・見直しを行います。<br><br>
                  ７.個人情報の廃棄<br><br>
                  当社は、個人情報の利用目的に照らしその必要性が失われたときは、個人情報を消去又は廃棄するものとし、
                  当該消去及び廃棄は、外部流失等の危険を防止するために必要かつ適切な方法により、業務の遂行上必要な限りにおいて行います。
                </p>
              </div>


              <input type="hidden" name="submit" value="{{ "notcontact" }}">

              <div class="submit_container">
                <button type="submit" class="hover submit" id="btn-send"><span>送信</span></button>
              </div>
            </form>
          </div>
        </div>