<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ url('/img/common/favicon.ico') }}">
    <title>ログイン</title>
    <link href="{{ url('/css/libs/style.min.css') }}" rel="stylesheet">
    <link href="{{ url('/css/admin-ui/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css') }}/@yield('css')">
</head>

<body id="login_page">
<div class="container">
    <div class="row justify-content-center align-items-center" style="height:100vh">
        <div class="col-4">
            @if ($errors->has('ad_email'))
            <p class="alert alert-danger md-4">
                {{ $errors->first('ad_email') }}
            </p>
            @endif
            @if ($errors->has('password'))
            <p class="alert alert-danger md-4">
                {{ $errors->first('password') }}
            </p>
            @endif
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="ad_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group mt-1 row">
                            <button type="submit" class="btn btn-default mx-auto col-6">ログイン</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
