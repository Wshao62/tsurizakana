@extends('layouts.admin_app')

@section('page_name', '釣魚管理')
@section('page_id', 'fish_page')
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
        @csrf
        <div class="row">
            <label class="fish_search_length">
                <select class="input_length_short" name="lenStatus" id="lenStatus">
                    <option value="25"  selected>25</option>
                    <option value="50">50</option>
                    <option value="-1">全</option>
                </select>
            </label>

            <label class="fish_search_dl">
                <div class="fish_search_button">
                    <input id="csv" type="button" class="btn btn-primary" value="CSVダウンロード">
                </div>
            </label>
            </div>
            <div class="row w-100">
            <label class="fish_search_name fish_search_length ml-3">
                <input name="fish_category_name" placeholder="魚名" id="fish_category_name" class="js_search_target">
            </label>

            <label class="fish_search_name col-3">
                <select name="seller_id" id="seller_id" data-placeholder="販売者" class="input_length_short js_search_target">
                    <option value=""></option>
                    @foreach ($users as $_u)
                    <option value="{{$_u->id}}" @if ($seller_id == $_u->id) selected @endif>{{$_u->name}}[{{$_u->email}}]</option>
                    @endforeach
                </select>
            </label>

            <label class="fish_search_name col-3">
                <select name="buyer_id" id="buyer_id" data-placeholder="購入者" class="input_length_short js_search_target">
                    <option value=""></option>
                    @foreach ($users as $_u)
                    <option value="{{$_u->id}}" @if ($buyer_id == $_u->id) selected @endif>{{$_u->name}}[{{$_u->email}}]</option>
                    @endforeach
                </select>
            </label>

            <label class="fish_search_length col-1">
                <select class="input_length_short js_search_target" name="status" id="status">
                    <option value="" selected>---</option>
                    @foreach ($statusArray as $key => $value)
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
                        <th>魚名</th>
                        <th class="d-none">販売者ID</th>
                        <th>販売者</th>
                        <th class="d-none">購入者ID</th>
                        <th>購入者</th>
                        <th>釣った場所</th>
                        <th>届け可能先</th>
                        <th class="d-none">価格</th>
                        <th>価格</th>
                        <th class="d-none">詳細</th>
                        <th>ステータス</th>
                        <th>登録日</th>
                        <th>削除日</th>
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
<link rel="stylesheet" href="{{ url('/css/component-chosen.css') }}">
<script type="text/javascript" src="{{ url('/js/chosen.jquery.js') }}"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>


<script>
    $(function() {
        let fish_category_name = "";
        let seller_id = @if (!empty($seller_id)) {{$seller_id}} @else "" @endif;
        let buyer_id = @if (!empty($buyer_id)) {{$buyer_id}} @else "" @endif;
        let status = "";

        $('#fish_category_name').on('keyup', function(){
            fish_category_name = this.value;
            table.draw();
        });

        $('#buyer_id').on('change', function(){
            buyer_id = this.value;
            table.draw();
            console.log("ok");
        });

        $('#seller_id').on('change', function(){
            seller_id = this.value;
            table.draw();
        });

        $('#status').on('change', function(){
            status = this.value;
            table.draw();
        });

        $('#seller_id, #buyer_id').chosen({
            search_contains: true,
        });

        $('.js_reseet_btn').on('click', function(){
            $('.js_search_target').val('');
            $('#seller_id, #buyer_id').trigger('chosen:updated');
            fish_category_name = "";
            seller_id = "";
            buyer_id = "";
            status = "";
            table.draw();
        });

        let status_names = {!! json_encode($statusArray) !!};
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
                data: 'fish_category_name',
            },
            {
                data: 'seller_id',
                visible: false,
            },
            {
                data: 'seller_name',
            },
            {
                data: 'buyer_id',
                visible: false,
            },
            {
                data: 'buyer_name',
            },
            {
                data: 'location',
            },
            {
                data: 'destination',
            },
            {
                data: 'price',
                visible: false,
            },
            {
                data: 'price',
                sortable: true,
                render: function (data, type, row) {
                    return number_separate(row.price)+'円';
                }
            },
            {
                data: 'description',
                visible: false,
            },
            {
                data: 'status',
                sortable: true,
                render: function (data, type, row) {
                    return status_names[row.status];
                }
            },
            {
                data: 'created_at',
            },
            {
                data: 'deleted_at',
            },
            {
                data: null,
                sortable: false,
                render: function (data, type, row) {
                    return '<div class="btn-group-vertical">'
                            + '<a href="/fish/'+ row.id+'" target="_blank"><button type="button" class="btn btn-info">詳細</button></a>'
                            + '<a href="/admin/fish/'+ row.id+ '/edit"><button type="button" class="btn btn-success">編集</button></a>'
                            + '</div>'
                }
            }
        ];

        var table = $('#table').DataTable({
            "processing": true,
            "iDisplayLength": 25,
            "order": [0, "desc"],
            "bLengthChange" : false,
            "aaSorting": [],
            "dom": 'Bfrtip',
            "serverSide": true,
            "searching": false,
            "buttons": [
                {
                    extend: 'csvHtml5',
                    text: '',
                    extend: 'csv',
                    charset: 'utf-8',
                    bom: true,
                    filename: function(){
                        var utc = new Date().toJSON().slice(0,10).replace(/-/g,'/');
                        return 'fish-' + utc;
                    },
                    exportOptions: {
                        columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 13],
                    },
                }
            ],
            "ajax": {
                type: 'GET',
                url: "{{ url('/admin/fish/list') }}",
                dataSrc: 'data',
                data: function ( d ) {
                    d._token = $('input[name="_token"]').val();
                    d.fish_category_name = fish_category_name;
                    d.seller_id = seller_id;
                    d.buyer_id = buyer_id;
                    d.status = status;
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
            },
        });

        $('#lenStatus').on('change', function(){
            table.page.len(this.value).draw();
        });
    });

    {{-- var actionThis = function(element) {
        var id = $(element).attr('id');
        var strhostname_ = window.location.hostname;
        var strprotocol = window.location.protocol;

        var Route = strprotocol + "//" + strhostname_ +  "/admin/fish/"+id+"/restart";
        var confirm_mssg = confirm("復元しますか？");

        if(confirm_mssg) {
            $(".js_btn_restart").attr('href', Route);
        }
    } --}}
</script>
@endsection