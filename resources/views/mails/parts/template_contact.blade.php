@component('mail::panel')
    @component('mail::table')
    | 項目 | ご入力内容 |
    |-|-|
    @if (!empty($contact_type))
    | お問い合わせ項目 | {{$contact_type}}|
    @endif
    | お名前 | {{ $name }} |
    @if (!empty($form_company))
    | 会社名/組織名 | {{$form_company}}|
    @endif
    @if (!empty($postal_code))
    | 郵便番号 | {{$postal_code}}|
    @endif
    @if (!empty($prefect))
    | 都道府県 | {{$prefect}}|
    @endif
    @if (!empty($addr1))
    | 住所１ | {{$addr1}}|
    @endif
    @if (!empty($addr2))
    | 住所２ | {{$addr2}}|
    @endif
    | メールアドレス  | {{ $contact_email }} |
    | 電話番号  | {{ $tel1. '-'. $tel2. '-'. $tel3 }} |
    | お問い合わせ内容 | {!! nl2br(htmlspecialchars( $description )) !!} |
    @endcomponent
@endcomponent
