@extends('layouts.admin_app')

@section('page_name', '本人確認 | ユーザー管理' )
@section('page_id', 'user_page')
@section('css', 'admin.css')

@section('content')
<div class="layout">
    <a href="{{ url('/admin/user/'.$user->id.'/edit') }}" class="btn btn-default">ユーザ編集へ戻る</a>
    <div class="row w-100 mt-2">
        <div class="col-4">
            <div class="col-12">
                <img class="img-responsive w-100" src="{{ $identification->getUrl(1) }}" data-toggle="modal"
                    data-target="#modal1">
            </div>
            <div id="modal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="{{ $identification->getUrl(1) }}" class="img-responsive w-100">
                        </div>
                    </div>
                </div>
            </div>
            @if (!empty($identification->file_path2))
            <div class="col-12 mt-3">
                <img class="img-responsive w-100" src="{{ $identification->getUrl(2) }}" data-toggle="modal"
                    data-target="#modal2">
            </div>
            <div id="modal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="{{ $identification->getUrl(2) }}" class="img-responsive w-100">
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="offset-1 col-7">
            <table class="table table-bordered bg-white">
                <tbody>
                    <tr>
                        <th>名前</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>住所</th>
                        <td>〒{{ $user->zipcode }}<br>{{ $user->public_address }}{{ $user->private_address }}</td>
                    </tr>
                    <tr>
                        <th>書類タイプ</th>
                        <td>{{ $identification->getTypeName() }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="card col-12">
                <div class="card-body">
                    <form method="POST" id="judgeForm">
                        @csrf
                        @if (session('error'))
                            <p class="content_alert_box alert">{{ session('error') }}</p>
                        @endif
                        <input type="radio" name="judge" value="承認" class="hide">
                        <input type="radio" name="judge" value="否認" class="hide" checked>
                        @if ($errors->count() > 0)
                            <p class="alert alert-danger mb-3">
                            @foreach ( $errors->all() as $_e)
                                {{ $_e }}<br>
                            @endforeach
                            </p>
                        @endif
                        <div class="form-group mt-1 row">
                            <button type="submit" class="btn btn-success mx-auto col-6" onclick="return approve();">承認する</button>
                        </div>
                        <hr class="mt-3">
                        <div class="form-group">
                            <textarea name="reject_reason" class="form-control textarea" placeholder="否認理由を記載してください。">{{ old('reject_reason') }}</textarea>
                        </div>
                        <div class="form-group mt-1 row">
                            <button type="submit" class="btn btn-danger mx-auto col-6" onclick="return deny();">認めない</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('before_end')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>

<script>
    function approve()
    {
        $('input[name="judge"]:eq(0)').prop('checked', true);
        return confirm("本人確認書類を承認します。この操作は取り消せません。\n実行してよろしいですか？");
    }

    function deny()
    {
        $('input[name="judge"]:eq(1)').prop('checked', true);
        return confirm("本人確認書類を否認します。この操作は取り消せません。ユーザに通知のメールが飛び再度申請するように促されます。\n実行してよろしいですか？");

    }
</script>
@endsection
