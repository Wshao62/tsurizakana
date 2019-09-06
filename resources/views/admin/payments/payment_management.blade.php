@extends('layouts.admin_app')

@section('page_name', '決済管理')
@section('page_id', 'payment_page')
@section('css', 'admin.css')

@section('content')
<div class="layout">
    <div class="wrappers">
        <div class="payment_search row w-100">
            <label class="payment_search_length">
                <select class="input_length_short" name="lenStatus" id="lenStatus">
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="-1">全</option>
                </select>
            </label>

            <label class="payment_search_name col-4">
                <select name="user_id" id="user_id" data-placeholder="ユーザ/メールアドレス" class="input_length_short js_search_target">
                    <option value=""></option>
                    @foreach ($users as $_u)
                    <option value="{{$_u->id}}">{{$_u->name}}[{{$_u->email}}]</option>
                    @endforeach
                </select>
            </label>

            <label class="payment_search_length row col-2">
                <select class="input_length_short" name="ym" id="ym">
                    <option value="">年月</option>
                    @foreach ($ym as $_k => $_v)
                        <option value="{{ $_k }}" @if( date('Y-m') == $_k) selected="selected" @endif>{{ $_v }}</option>
                    @endforeach
                </select>
            </label>

            <label class="payment_search_dl">
                <div class="payment_search_button">
                    <input id="csv" type="button" class="btn btn-primary" value="CSVダウンロード">
                </div>
            </label>
        </div>

        <div class="table-responsive">
            @csrf
            <table id="table" class="display table-striped">
                <thead class="tblTitle">
                    <tr>
                        <th>年月</th>
                        <th>ユーザーID</th>
                        <th>ユーザー名</th>
                        <th class="hidden">金額</th>
                        <th>1ヶ月の売上金額</th>
                        <th>総手数料</th>
                        <th>総手数料</th>
                        <th>振込金額</th>
                        <th>振込金額</th>
                        <th class="hidden">銀行名</th>
                        <th class="hidden">銀行支店コード</th>
                        <th class="hidden">口座種別</th>
                        <th class="hidden">口座番号</th>
                        <th class="hidden">口座名義</th>
                    </tr>
                </thead>
                {{-- <tbody>
                    @foreach($data as $list)
                    <tr class="">
                            <td class="text-lg-center">{{ $list->user_id }}</td>
                            <td class="text-lg-center">{{ $list->name }}</td>
                            <td class="text-lg-center">{{ number_format($list->price) }}</td>
                            <td class="text-lg-center">{{ number_format($list->ServiceFee) }}</td>
                            <td class="text-lg-center">{{ number_format($list->price - $list->ServiceFee) }}</td>
                            <td class="text-lg-center">{{ $list->billYear }}</td>
                            <td class="text-lg-center">{{ $list->billMonth }}</td>
                        </tr>
                    @endforeach
                </tbody> --}}
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
        $('#user_id').chosen({
            search_contains: true,
        });


        let bank_type_name = {!! json_encode(\App\Models\User::BANK_TYPE_NAME) !!};
        let dataTableCols = [
            {
                data: 'bill_ym',
                render: function (data, type, row) {
                    return row.bill_ym.slice(0,4)+'年'+row.bill_ym.slice(4)+'月';
                }
            },
            {
                data: 'user_id',
            },
            {
                data: 'name',
            },
            {
                data: 'price',
                render: function (data, type, row) {
                    return number_separate(row.price)+'円';
                }
            },
            {
                data: 'price',
                visible: false,
            },
            {
                data: null,
                visible: false,
                render: function (data, type, row) {
                    return Math.round(row.price * {{ config('const.service_charge') }});
                }
            },
            {
                data: null,
                sortable: false,
                render: function (data, type, row) {
                    return number_separate(Math.round(row.price * {{ config('const.service_charge') }}))+'円';
                }
            },
            {
                data: null,
                visible: false,
                render: function (data, type, row) {
                    return Math.round(row.price - (row.price * {{ config('const.service_charge') }}));
                }
            },
            {
                data: null,
                sortable: false,
                render: function (data, type, row) {
                    return number_separate(Math.round(row.price - (row.price * {{ config('const.service_charge') }})))+'円';
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
        ];

        var table = $('#table').DataTable({
            "processing": true,
            "iDisplayLength": 25,
            "aaSorting": [3, 'desc'],
            "dom": 'Bfrtip',
            "serverSide": true,
            "buttons": [
                {
                    extend: 'csvHtml5',
                    text: 'CSVダウンロード',
                    extend: 'csv',
                    charset: 'utf-8',
                    bom: true,
                    filename: function(){
                        var utc = new Date().toJSON().slice(0,10).replace(/-/g,'/');
                        return 'receipt-' + utc;
                    },
                    exportOptions: {
                        rows: [':visible' ],
                        columns: [0, 1, 2, 4, 6, 8, 9, 10, 11, 12, 13],
                        format: {
                            body: function (data, row, column, node) {
                                return data;
                            }
                        }
                    }
                }
            ],
            "ajax": {
                type: 'GET',
                url: "{{ url('/admin/payment/list') }}",
                dataSrc: 'data',
                data: function ( d ) {
                    d._token = $('input[name="_token"]').val();
                    d.user_id = user_id;
                    d.ym = ym;
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
                url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Japanese.json"
            },
        });

        let user_id = "";
        let ym = "{{ date('Y-m') }}";
        $('#user_id').on('change', function(){
            user_id = this.value;
            table.draw();
        });

        $('#lenStatus').on('change', function(){
            table.page.len(this.value).draw();
        });

        $('#ym').on('change', function(){
            ym = this.value;
            table.draw();
        });
    });
</script>
@endsection