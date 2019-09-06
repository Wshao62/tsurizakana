<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <title>{{$date}}領収証</title>
  <style>
    @charset "UTF-8";
    @font-face {
        font-family: noto;
        font-style: normal;
        font-weight: 100;  
        src: url('{{ storage_path('fonts/NotoSansCJKjp-Thin.woff2') }}') format('woff2'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Thin.woff') }}') format('woff'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Thin.ttf') }}')  format('truetype'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Thin.eot') }}') format('embedded-opentype');
    }
    @font-face {
        font-family: noto;
        font-style: normal;
        font-weight: 200;
        src: url('{{ storage_path('fonts/NotoSansCJKjp-Light.woff2') }}') format('woff2'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Light.woff') }}') format('woff'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Light.ttf') }}')  format('truetype'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Light.eot') }}') format('embedded-opentype');
    }
    @font-face {
        font-family: noto;
        font-style: normal;
        font-weight: 300;
        src: url('{{ storage_path('fonts/NotoSansCJKjp-DemiLight.woff2') }}') format('woff2'),
            url('{{ storage_path('fonts/NotoSansCJKjp-DemiLight.woff') }}') format('woff'),
            url('{{ storage_path('fonts/NotoSansCJKjp-DemiLight.ttf') }}')  format('truetype'),
            url('{{ storage_path('fonts/NotoSansCJKjp-DemiLight.eot') }}') format('embedded-opentype');
    }
    @font-face {
        font-family: noto;
        font-style: normal;
        font-weight: 400;
        src: url('{{ storage_path('fonts/NotoSansCJKjp-Regular.woff2') }}') format('woff2'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Regular.woff') }}') format('woff'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Regular.ttf') }}')  format('truetype'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Regular.eot') }}') format('embedded-opentype');
    }
    @font-face {
        font-family: noto;
        font-style: normal;
        font-weight: 500;
        src: url('{{ storage_path('fonts/NotoSansCJKjp-Medium.woff2') }}') format('woff2'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Medium.woff') }}') format('woff'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Medium.ttf') }}')  format('truetype'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Medium.eot') }}') format('embedded-opentype');
    }
    @font-face {
        font-family: noto;
        font-style: normal;
        font-weight: 700;
        src: url('{{ storage_path('fonts/NotoSansCJKjp-Bold.woff2') }}') format('woff2'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Bold.woff') }}') format('woff'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Bold.ttf') }}')  format('truetype'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Bold.eot') }}') format('embedded-opentype');
    }
    @font-face {
        font-family: noto;
        font-style: normal;
        font-weight: 900;
        src: url('{{ storage_path('fonts/NotoSansCJKjp-Black.woff2') }}') format('woff2'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Black.woff') }}') format('woff'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Black.ttf') }}')  format('truetype'),
            url('{{ storage_path('fonts/NotoSansCJKjp-Black.eot') }}') format('embedded-opentype');
    }
  </style>
  <link rel="stylesheet" href="{{ public_path('css/receipt.css') }}">
</head>
<body>
  <main>
    <div class="container">
      <hr>
      <img class="logo" src="{{ public_path('img/logo.png') }}" alt="釣魚商店">
      <div class="head-right">
            <p class="date">{{$date}}</p>
            <p class="company_info">〒254-0806</p>
            <p class="company_info">神奈川県平塚市夕陽ケ丘1番16号 第1三富ビル302号</p>
            <p class="company_name">Cplan株式会社</p>
            <p class="company_info">TEL:0463-86-6984</p>
      </div>
      <div class="clear"></div>
      <dl>
        <dt class="list_title list_top"><img class="logo" src="{{ public_path('img/receipt_title.png') }}"><p>領収証</p></dt>
        <dd class="list_top">
          <div>
            <p>宛名：</p>
            <p class="pr">{{Auth::user()->name}}</p>
          </div>
          <div class="list_r">
            <div class="right">
              <p class="price_big">¥{{ number_format($gtotal) }}</p><p class="yen_big">円</p>
            </div>
          </div>
          <div class="clear"></div>
        </dd>
        <dt class="list_title"><img class="logo" src="{{ public_path('img/receipt_title.png') }}"><p>内訳</p></dt>
        @foreach ($receipt as $item)
        <dd>
          <div>
            <p>商品名：</p>
            <p class="pr">{{$item['fish_name']}}(商品コード: {{$item['fish_id']}})</p>
          </div>
          <div class="list_r">
            <div class="right">
              <p class="price_big">¥{{ number_format($item['price']) }}</p><p class="yen">円</p>
            </div>
          </div>
          <div class="clear"></div>
          <div class="list_03">
            <p>購入日：</p>
            <p class="pr">{{$item['billed_at']}}</p>
          </div>
        </dd>
        @endforeach
        <dd class="subtotal">
          <div>
            <p>小計：</p>
          </div>
          <div class="list_r">
            <div class="right">
              <p class="">¥{{ number_format($total) }}円</p>
            </div>
          </div>
          <div class="clear"></div>
        </dd>
        <dd>
          <div class="tax">
            <p>消費税：</p>
          </div>
          <div class="list_r">
            <div class="right">
              <p class="">¥{{ number_format($vat) }}円</p>
            </div>
          </div>
          <div class="clear"></div>
        </dd>
        <dd class="total">
          <div class="">
            <p>合計：</p>
          </div>
          <div class="list_r">
            <div class="right">
              <p class="price_big">¥{{ number_format($gtotal) }}</p><p class="yen_big">円</p>
            </div>
          </div>
        </dd>
      </dl>
    </div>
  </main>
</body>
</html>
