@extends('layouts.admin_app')

@section('page_name', 'ブログ管理')
@section('page_id', 'blog_page')
@section('css', 'admin.css')

@section('content')
<div class="layout">
    @if (session('error'))
        <p class="content_alert_box alert">{{ session('error') }}</p>
    @endif
    @if (session('status'))
        <p class="content_success_box success">{{ session('status') }}</p>
    @endif
    <div class="wrappers">
        <div class="user_search row">
            <label class="user_search_length col-1">
                <select class="input_length_short" name="lenStatus" id="lenStatus">
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="-1">全</option>
                </select>
            </label>

            <label class="user_search_name col-2">
                <input name="title" placeholder="タイトル名" id="title" class="js_search_target">
            </label>

            <label class="user_search_name col-4">
                <select name="user_id" id="user_id" data-placeholder="ユーザ" class="input_length_short js_search_target">
                    <option value=""></option>
                    @foreach ($users as $_u)
                    <option value="{{$_u->id}}" @if ($user_id == $_u->id) selected @endif>{{$_u->name}}[{{$_u->email}}]</option>
                    @endforeach
                </select>
            </label>

            <label class="fish_search_length col-1">
                <select class="input_length_short js_search_target" name="status" id="status">
                    <option value="" selected>---</option>
                    @foreach ($status_ary as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </label>

            <div>
                <button type="button" class="btn js_reseet_btn">× 検索条件をリセット</button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="table" class="display table-striped">
                <thead class="tblTitle">
                    <tr>
                        <th>ID</th>
                        <th>サムネイル</th>
                        <th>タイトル名</th>
                        <th>ユーザー名</th>
                        <th>ステータス</th>
                        <th>登録日時</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('before_end')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="{{ url('/css/component-chosen.css') }}">
<script type="text/javascript" src="{{ url('/js/chosen.jquery.js') }}"></script>
<script>
    $(function() {
        let status_names = {!! json_encode($status_ary) !!};
        let dataTableCols = [
            {
                data: 'id',
            },
            {
                data: 'file_name',
                sortable: false,
                render: function (data, type, row) {
                    return '<img src="' + row.file_name + '" width="50">';
                }
            },
            {
                data: 'title',
            },
            {
                data: 'name',
            },
            {
                data: 'status',
                sortable: false,
                render: function (data, type, row) {
                    return status_names[row.status];
                }
            },
            {
                data: 'created_at',
            },
            {
                data: null,
                sortable: false,
                render: function (data, type, row) {
                    if (row.status == {{ \App\Models\Blog::STATUS_PUBLISH}}) {
                    return '<a href="/blog/'+row.id+'" class="btn btn-default" target="_blank">ブログを見る</a>';
                    }
                    return '(非公開)';
                }
            },
            {
                data: null,
                sortable: false,
                render: function (data, type, row) {
                    return '<a class="btn btn-danger js_btn_delete" href="javascript:;" id="'+row.id+'" onclick="actionThis(this)">削除</a>';
                }
            },
        ];

        var table = $('#table').DataTable({
            "processing": true,
            "iDisplayLength": 25,
            "bLengthChange" : false,
            "aaSorting": [0, 'desc'],
            "serverSide": true,
            "searching": false,
            "language": {
                    url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Japanese.json",
            },
            "ajax": {
                type: 'GET',
                url: "{{ url('/admin/blog/list') }}",
                dataSrc: 'data',
                data: function ( d ) {
                    d._token = $('input[name="_token"]').val();
                    d.user_id = user_id;
                    d.title = title;
                    d.status = status;
                }
            },
            "columns": dataTableCols,
        });

        $('#user_id').chosen({
            search_contains: true,
        });

        let user_id = @if (!empty($user_id)) {{ $user_id }} @else "" @endif ;
        let title = "";
        let status = "";

        $('#user_id').on('change', function(){
            user_id = this.value;
            table.draw();
        });

        $('#title').on('keyup', function(){
            title = this.value;
            table.draw();
        });
        $('#status').on('change', function(){
            status = this.value;
            table.draw();
        });

        $('#lenStatus').on('change', function(){
            table.page.len(this.value).draw();
        });

        $('.js_reseet_btn').on('click', function(){
            $('.js_search_target').val('');
            $('#user_id').trigger('chosen:updated');
            user_id = "";
            title = "";
            status = "";
            table.draw();
        });
    });

    var actionThis = function(element,title) {
            var id = $(element).attr('id');
            var strhostname_ = window.location.hostname;
            var strprotocol = window.location.protocol;

            var Route = strprotocol + "//" + strhostname_ +  "/admin/blog/"+id+"/delete";
            var confirm_mssg = confirm('選択したブログを削除しますか？');

            if(confirm_mssg) {
                $(".js_btn_delete").attr('href', Route);
            }
        }
</script>
@endsection