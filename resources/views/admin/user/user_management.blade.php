@extends('layouts.admin_app')

@section('page_name', 'ユーザー管理')
@section('page_id', 'user_page')
@section('css', 'admin.css')

@section('content')
    <div class="layout">
    @if (session('error'))
        <p class="content_alert_box alert">{{ session('error') }}</p>
    @endif
    @if (session('status'))
        <p class="content_success_box success">{{ session('status') }}</p>
    @endif
    <div class="layout mp_cont row justify-content-md-center w-100">
        <a class="btn btn-info col-5" href="{{ url('/admin/user/create') }}">新規作成</a>
    </div>
    <div class="wrappers">
        <div class="user_search">
            <form class=" row w-100">
                <label class="user_search_length col-1">
                    <select class="input_length_short" name="lenStatus" id="lenStatus">
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="-1">全</option>
                    </select>
                </label>
                <label class="user_search_name col-4">
                    <select name="user_id" id="user_id" data-placeholder="ユーザ/メールアドレス" class="input_length_short js_search_target">
                        <option value=""></option>
                        @foreach ($users as $_u)
                        <option value="{{$_u->id}}">{{$_u->name}}[{{$_u->email}}]</option>
                        @endforeach
                    </select>
                </label>
                <label class="user_search_prefecture">
                    <div>
                        <select class="input_length_short" name="prefecture" id="prefecture">
                            <option value="都道府県">都道府県</option>
                            @foreach (config('const.prefectures') as $_pref)
                            <option value="{{ $_pref }}">{{ $_pref }}</option>
                            @endforeach
                        </select>
                    </div>
                </label>
                <label class="user_search_status col-2">
                    <div>
                        <select class="input_length_short" name="identification" id="identification">
                            <option value="" selected>本人確認</option>
                            <option value="0">未確認</option>
                            <option value="1">確認待ち</option>
                            <option value="9">済み</option>
                        </select>
                    </div>
                </label>

                <label class="user_search_dl">
                    <div class="user_search_button">
                        <input id="csv" type="button" class="btn btn-primary" value="CSVダウンロード">
                    </div>
                </label>
            </form>
        </div>
        <div class="table-responsive">
            <table id="table" class="display table-striped">
                <thead class="tblTitle">
                    <tr>
                        <th>ID</th>
                        <th>プロフィール写真</th>
                        <th>名前</th>
                        <th>メールアドレス</th>
                        <th class="col_hide">フリガナ</th>
                        <th class="col_hide">郵便番号</th>
                        <th>都道府県</th>
                        <th class="col_hide">公開住所</th>
                        <th class="col_hide">非公開住所</th>
                        <th class="col_hide">携帯電話</th>
                        <th class="col_hide">固定電話</th>
                        <th>本人確認</th>
                        <th class="hidden">銀行名</th>
                        <th class="hidden">銀行支店コード</th>
                        <th class="hidden">口座種別</th>
                        <th class="hidden">口座番号</th>
                        <th class="hidden">口座名義</th>
                        <th>登録日</th>
                        {{-- <th>解約日</th> --}}
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection
@section('before_end')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{ url('/css/component-chosen.css') }}">
<script type="text/javascript" src="{{ url('/js/chosen.jquery.js') }}"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

<script>
    $(function () {
        $('#user_id').chosen({
            search_contains: true,
        });

        let bank_type_name = {!! json_encode(\App\Models\User::BANK_TYPE_NAME) !!};
        let dataTableCols = [
            {
                data: 'id',
            },
            {
                data: 'profile_photo',
                sortable: false,
                render: function (data, type, row) {
                    return '<img src="' + row.profile_photo + '" width="50">';
                }
            },
            {
                data: 'name',
            },
            {
                data: 'email',
            },
            {
                data: 'furigana',
                visible: false,
            },
            {
                data: 'zipcode',
                visible: false,
            },
            {
                data: 'prefecture',
            },
            {
                data: 'public_address',
                visible: false,
            },
            {
                data: 'private_address',
                visible: false,
            },
            {
                data: 'mobile_tel',
                visible: false,
            },
            {
                data: 'tel',
                visible: false,
            },
            {
                data: null,
                sortable: false,
                render: function (data, type, row) {
                    if (row.identificated_at)
                    {
                        return '済み';
                    } else if (row.reject_reason == null && row.file_path1 != null) {
                        return '<span class="alert">確認待ち</span>';
                    }
                    return '未確認';
                }
            },
            {
                data: 'bank_name',
                visible: false,
            },
            {
                data: 'bank_branch_code',
                visible: false,
            },
            {
                data: 'bank_type',
                visible: false,
                render: function (data, type, row) {
                    if (row.bank_type) {
                        return bank_type_name[row.bank_type];
                    } else {
                        return "";
                    }
                }
            },
            {
                data: 'bank_number',
                visible: false,
            },
            {
                data: 'bank_user_name',
                visible: false,
            },
            {
                data: 'created_at',
            },
            {
                data: null,
                sortable: false,
                render: function (data, type, row) {
                    return '<div class="btn-group-vertical">'
                            + '<a href="/user/'+ row.id+'" target="_blank"><button type="button" class="btn btn-info">詳細</button></a>'
                            + '<a href="/admin/user/'+ row.id+ '/edit"><button type="button" class="btn btn-success">編集</button></a>'
                            + '</div>'
                }
            },
        ];

        var table = $("#table").DataTable({
            "processing": true,
            "iDisplayLength": 25,
            "aaSorting": [0, 'desc'],
            "dom": 'Bfrtip',
            "serverSide": true,
            "searching": false,
            "buttons": [
                {
                    extend: 'csvHtml5',
                    text: 'CSVダウンロード',
                    extend: 'csv',
                    charset: 'utf-8',
                    bom: true,
                    filename: function(){
                        var utc = new Date().toJSON().slice(0,10).replace(/-/g,'/');
                        return 'user-' + utc;
                    },
                    exportOptions: {
                        rows: [':visible' ],
                        columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
                        format: {
                            body: function (data, row, column, node) {
                                return data + '\t';
                            }
                        }
                    }
                }
            ],
            "ajax": {
                type: 'GET',
                url: "{{ url('/admin/user/list') }}",
                dataSrc: 'data',
                data: function ( d ) {
                    d._token = $('input[name="_token"]').val();
                    d.user_id = user_id;
                    d.prefecture = prefecture;
                    d.identification = identification;
                }
            },
            columns: dataTableCols,
            initComplete: function() {
                var $buttons = $('.dt-buttons').hide();
                $('#csv').on('click', function() {
                    $buttons.find('.buttons-csv').click();
                })
            },
            "language": {
                    url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Japanese.json",
                }
        });

        var prefecture = "";
        var user_id = "";
        var identification = "";

        /* Custom filtering function which will search data in select values */
        $('#prefecture').on('change', function(){
            if(this.value != "都道府県"){
                prefecture = this.value;
            }else{
                prefecture = "";
            }
            table.draw();
        });
        $('#user_id').on('change', function(){
            user_id = this.value;
            table.draw();
        });

        $('#identification').on('change', function(){
            identification = this.value;
            table.draw();
        });

        $('#lenStatus').on('change', function(){
            table.page.len(this.value).draw();
        });
    });

    var resetThis = function(element) {
        var id = $(element).attr('id');
        var strhostname_ = window.location.hostname;
        var strprotocol = window.location.protocol;
        var resetRoute = strprotocol + "//" + strhostname_ +  "/admin/user/reset/"+id;
        var confirm_mssg = confirm("ユーザーを復元しますか？");
        if(confirm_mssg) {
            $(".js_btn_restart").attr('href', resetRoute);
        }
    }
</script>
@endsection