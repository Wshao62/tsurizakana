<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attributeを承認してください。',
    'active_url' => ':attributeには有効なURLを指定してください。',
    'after' => ':attributeには:date以降の日付を指定してください。',
    'after_or_equal' => ':attributeには:dateかそれ以降の日付を指定してください。',
    'alpha' => ':attributeには英字のみからなる文字列を指定してください。',
    'alpha_dash' => ':attributeには英数字・ハイフン・アンダースコアのみからなる文字列を指定してください。',
    'alpha_num' => ':attributeには英数字のみからなる文字列を指定してください。',
    'array' => ':attributeには配列を指定してください。',
    'before' => ':attributeには:date以前の日付を指定してください。',
    'before_or_equal' => ':attributeには:dateかそれ以前の日付を指定してください。',
    'between' => [
        'numeric' => ':attributeには:min〜:maxまでの数値を指定してください。',
        'file' => ':attributeには:min〜:max KBのファイルを指定してください。',
        'string' => ':attributeには:min〜:max文字の文字列を指定してください。',
        'array' => ':attributeには:min〜:max個の要素を持つ配列を指定してください。',
    ],
    'boolean' => ':attributeには真偽値を指定してください。',
    'confirmed' => ':attributeが確認用の値と一致しません。',
    'date' => ':attributeには正しい形式の日付を指定してください。',
    'date_format' => '":format"という形式の日付を指定してください。',
    'different' => ':attributeには:otherとは異なる値を指定してください。',
    'digits' => ':attributeには:digits桁の数値を指定してください。',
    'digits_between' => ':attributeには:min〜:max桁の数値を指定してください。',
    'dimensions' => ':attributeの画像サイズが不正です。',
    'distinct' => '指定された:attributeは既に存在しています。',
    'email' => ':attributeには正しい形式のメールアドレスを指定してください。',
    'exists' => '指定された:attributeは存在しません。',
    'file' => ':attributeにはファイルを指定してください。',
    'filled' => ':attributeには空でない値を指定してください。',
    'image' => ':attributeには画像ファイルを指定してください。',
    'in' => ':attributeには:valuesのうちいずれかの値を指定してください。',
    'in_array' => ':attributeが:otherに含まれていません。',
    'integer' => ':attributeには整数を指定してください。',
    'ip' => ':attributeには正しい形式のIPアドレスを指定してください。',
    'ipv4' => ':attributeには正しい形式のIPv4アドレスを指定してください。',
    'ipv6' => ':attributeには正しい形式のIPv6アドレスを指定してください。',
    'json' => ':attributeには正しい形式のJSON文字列を指定してください。',
    'max' => [
        'numeric' => ':attributeには:max以下の数値を指定してください。',
        'file' => ':attributeには:max KB以下のファイルを指定してください。',
        'string' => ':attributeには:max文字以下の文字列を指定してください。',
        'array' => ':attributeには:max個以下の要素を持つ配列を指定してください。',
    ],
    'mimes' => ':attributeには:valuesのうちいずれかの形式のファイルを指定してください。',
    'mimetypes' => ':attributeには:valuesのうちいずれかの形式のファイルを指定してください。',
    'min' => [
        'numeric' => ':attributeには:min以上の数値を指定してください。',
        'file' => ':attributeには:min KB以上のファイルを指定してください。',
        'string' => ':attributeには:min文字以上の文字列を指定してください。',
        'array' => ':attributeには:min個以上の要素を持つ配列を指定してください。',
    ],
    'not_in' => ':attributeには:valuesのうちいずれとも異なる値を指定してください。',
    'numeric' => ':attributeには数値を指定してください。',
    'present' => ':attributeには現在時刻を指定してください。',
    'regex' => '正しい形式の:attributeを指定してください。',
    'required' => ':attributeは必須です。',
    'required_if' => ':otherが:valueの時:attributeは必須です。',
    'required_unless' => ':otherが:values以外の時:attributeは必須です。',
    'required_with' => ':valuesのうちいずれかが指定された時:attributeは必須です。',
    'required_with_all' => ':valuesのうちすべてが指定された時:attributeは必須です。',
    'required_without' => ':valuesのうちいずれかがが指定されなかった時:attributeは必須です。',
    'required_without_all' => ':valuesのうちすべてが指定されなかった時:attributeは必須です。',
    'same' => ':attributeが:otherと一致しません。',
    'size' => [
        'numeric' => ':attributeには:sizeを指定してください。',
        'file' => ':attributeには:size KBのファイルを指定してください。',
        'string' => ':attributeには:size文字の文字列を指定してください。',
        'array' => ':attributeには:size個の要素を持つ配列を指定してください。',
    ],
    'string' => ':attributeには文字列を指定してください。',
    'timezone' => ':attributeには正しい形式のタイムゾーンを指定してください。',
    'unique' => 'その:attributeはすでに使われています。',
    'uploaded' => ':attributeのアップロードに失敗しました。',
    'url' => ':attributeには正しい形式のURLを指定してください。',

    // Added Manual
    'furigana' => ':attributeはカタカナで入力してください。',
    'zipcode' => ':attributeの形式が不正です。123-4567の形式でご入力ください。',
    'phone' => ':attributeは半角の数字で入力してください。',
    'active_storage_url' => ':attributeがエラーとなりました。再度ファイル選択してください。',
    'valid_fish_photo_id' => ':attributeに不正なパラメータがありました。再度お試しください',
    'valid_blog_photo_id' => ':attributeに不正なパラメータがありました。再度お試しください',
    'bank_user_name' => ':attributeはカタカナ、数字、スペース、（）で入力してください。',
    'can_delete_bank' => '口座情報は前月・今月売り上げがなく、取引完了していない売魚がない場合のみ削除できます。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        //会員情報
        'email' => 'メールアドレス',
        'name' => 'お名前',
        'furigana' => 'フリガナ',
        'password' => 'パスワード',
        'zipcode' => '郵便番号',
        'prefecture' => '都道府県',
        'public_address' => '公開住所',
        'private_address' => '非公開住所',
        'mobile_tel' => '携帯電話',
        'tel' => '電話番号',

        'introduction' => '自己紹介',
        'bank_name' => '銀行名',
        'bank_branch_code' => '支店コード',
        'bank_type' => '口座種別',
        'bank_number' => '口座番号',
        'bank_user_name' => '口座名義',

        'shop_name' => 'お店の名前',
        'shop_zipcode' => 'お店の郵便番号',
        'shop_prefecture' => 'お店の都道府県',
        'shop_address1' => 'お店の住所１',
        'shop_address2' => 'お店の住所２',

        //お問い合わせ
        'contact_type' => 'お問い合わせ項目',
        'tel1' => '電話番号１',
        'tel2' => '電話番号２',
        'tel3' => '電話番号３',
        'form_company' => '会社名/組織名',
        'postal_code' => '郵便番号',
        'addr1' => '住所1',
        'addr2' => '住所2',
        'prefect' => '都道府県',
        'contact_email' => 'メールアドレス',
        'description' => 'お問い合わせ内容',
        'agreement' => '個人情報の取り扱いへの同意',

        //売魚
        'photo' => '写真',
        'photo.*' => '写真',
        'photo_id' => '写真ID',
        'photo_id.*' => '写真ID',
        'fish_category_name' => '商品名',
        'fish_category_id' => '魚カテゴリー',
        'location' => '魚が釣れた場所',
        'destination' => 'お届け可能地域',
        'price' => '価格',
        'description' => '詳細',
        'rate' => '評価',
        'rate_message' => 'コメント',
        'reason' => '理由',

        //Fish Request
        'category_name' => '魚の名前',
        'request_date' => '希望日',
        'fish_id' => 'オファー',
        'message' => 'メッセージ',

        //Blog
        'title' => 'タイトル',
        'status' => 'ステータス',

        //User Photo
        'profile_photo' => 'プロフィール画像',
        'cover_photo' => 'カバー画像',

        //Identification
        'type' => '本人確認書類の種類',
        'file_path1' => '1つ目の画像',
        'file_path2' => '2つ目の画像',

        //admin identification
        'judge' => '本人確認書類の可否',
        'reject_reason' => '否認理由',

    ],
];
