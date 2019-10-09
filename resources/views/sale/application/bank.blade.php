@extends('layouts.app')

@section('title', '振込先銀行口座')
@section('page_id', 'page_bank')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
    @include('parts/template_mypage_header', ['current' => 'sales'])
    <div class="sales_cont">
        <div class="sales_tabs">
            <a href="{{ url('mypage/sales') }}">売上金</a>
            <a href="{{ url('mypage/sales/history') }}">売上履歴</a>
            <a href="{{ url('mypage/sales/application') }}" class="current">振込申請</a>
            <a href="{{ url('mypage/sales/application/history') }}">申請履歴</a>
        </div><!-- END sales_tabs -->
        <div class="application_cont">
            <div class="application_flow">
                <p>振込内容</p>
                <span>></span>
                <p class="current">振込先<br class="sp">銀行口座</p>
                <span>></span>
                <p>入力情報<br class="sp">確認</p>
                <span>></span>
                <p>登録完了</p>
            </div><!-- END application_flow -->
            <form>
                <table class="bank_table">
                    <tr>
                        <th>銀行名</th>
                        <td><input type="text" placeholder="サカナ銀行"></td>
                    </tr>
                    <tr>
                        <th>支店コード</th>
                        <td><input class="input_branchCode" type="text" placeholder="001"></td>
                    </tr>
                    <tr>
                        <th>口座種別</th>
                        <td>
                            <label class="accountType_label">
                                <select>
                                    <option>普通口座</option>
                                </select>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th>口座番号</th>
                        <td><input type="text" placeholder="1234567"></td>
                    </tr>
                    <tr>
                        <th>口座名義（カナ）</th>
                        <td><input type="text" placeholder="ウザギ タロウ"></td>
                    </tr>
                </table><!-- END bank_table -->
                <div class="application_btn">
                    <button class="applctn_btn_blue">確認する</button>
                </div><!-- END application_btn -->
            </form><!-- END form -->
        </div><!-- END application_cont -->
    </div><!-- END sales_cont -->
    </div><!-- END mp_cont -->
@endsection

@section('before_end')
    <script>
    </script>
    <link rel="stylesheet" href="{{ url('css') }}/sales.css">
@endsection
