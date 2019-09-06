<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name=”robots” content=”noindex,nofollow”>
    <link rel="icon" href="{{ url('/img/common/favicon.ico') }}">
    <title>@yield('page_name')　|　{{ config('app.admin', '釣魚商店') }}</title>
    <link href="{{ url('/css/libs/style.min.css') }}" rel="stylesheet">
    <link href="{{ url('/css/admin-ui/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css') }}/@yield('css')">
</head>
<body>
  <div class="l-sidebars">
    <div class="l-sidebar__content">
    <div class="c-side-icon">
        <img src="{{ url('/img/logo_white.png') }}" alt="homepage" class="light-logo" />
    </div>
      <nav class="c-menu js-menu">
        <ul class="u-list">
            <li class="c-menu__item {{ last(request()->segments()) == 'user' ? 'is-active' : '' }}">
                <a href="{{ url('/admin/user') }}" aria-expanded="false">
                    <div class="c-menu__item__inner">ユーザー管理</div>
                </a>
            </li>
            <li class="c-menu__item {{ last(request()->segments()) == 'blog' ? 'is-active' : '' }}">
                <a href="{{ url('/admin/blog') }}" aria-expanded="false">
                    <div class="c-menu__item__inner">ブログ管理</div>
                </a>
            </li>
            <li class="c-menu__item {{ last(request()->segments()) == 'payment' ? 'is-active' : '' }}">
                <a href="{{ url('/admin/payment') }}" aria-expanded="false">
                    <div class="c-menu__item__inner">決済管理</div>
                </a>
            </li>
            <li class="c-menu__item {{ last(request()->segments()) == 'fish' ? 'is-active' : '' }}">
                <a href="{{ url('/admin/fish') }}" aria-expanded="false">
                    <div class="c-menu__item__inner">釣魚管理</div>
                </a>
            </li>

            <li class="c-menu__item mt-5">
                <a href="" onclick="event.preventDefault();document.getElementById('logout-form').submit();" aria-expanded="false">
                    <div class="c-menu__item__inner">ログアウト</div>
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
            </li>
          </ul>
        </nav>
        </ul>
      </nav>
    </div>
  </div>
  <main class="l-main" id="@yield('page_id')" @if (!trim($__env->yieldContent('not_need_head_img'))) class="lower_bg" @endif>
    <div class="content-wrapper content-wrapper--with-bg">
      <h1 class="page-title">@yield('page_name')</h1>
      <div>@yield('content')</div>
    </div>
  </main>
<script src="{{ url('js/libs/jquery.min.js') }}"></script>
<script>
  // 数値にカンマを打つ
  function number_separate(num) {
      // 文字列にする
      num = String(num);
      var sign = false;
      if (num.substring(0, 1) === '-') {
          sign = true;
          num = num.replace('-', '');
      }
      var len = num.length;
      // 再帰的に呼び出す
      if (len > 3) {
          // 前半を引数に再帰呼び出し + 後半3桁
          var left = num.substring(0, len - 3);
          if (sign) {
              left = left * -1;
          }
          var right = num.substring(len - 3);
          return number_separate(left) + ',' + right;
      } else {
          if (sign) {
              num = num * -1;
          }

          return num;
      }
  }
</script>
@yield('before_end')
</body>
</html>