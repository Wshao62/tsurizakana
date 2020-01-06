@extends('mails.layouts.mail')

@section('content')
    飲食店開拓希望を受け付けました

    お名前：{{ $form['last_name'] }} {{ $form['first_name'] }}
    メールアドレス：{{ $form['email'] }}
    新規開拓希望の店舗種類：{{ $form['shop_type'] }}
    店舗名：{{ $form['shop_name'] }}
    電話番号：{{ $form['tel'] }}
    郵便番号：{{ $form['zip_code'] }}
    都道府県：{{ $form['prefecture'] }}
    住所1：{{ $form['address_1'] }}
    住所2：{{ $form['address_2'] }}
    ご要望やご希望等：{!! $form['request'] !!}
@endsection
