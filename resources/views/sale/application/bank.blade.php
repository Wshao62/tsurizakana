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
            <div>
                @if ($errors->has('bank_name'))
                    <p class="error">
                        {{ $errors->first('bank_name') }}
                    </p>
                @endif
                @if ($errors->has('bank_branch_code'))
                    <p class="error">
                        {{ $errors->first('bank_branch_code') }}
                    </p>
                @endif
                @if ($errors->has('bank_type'))
                    <p class="error">
                        {{ $errors->first('bank_type') }}
                    </p>
                @endif
                @if ($errors->has('bank_number'))
                    <p class="error">
                        {{ $errors->first('bank_number') }}
                    </p>
                @endif
                @if ($errors->has('bank_user_name'))
                    <p class="error">
                        {{ $errors->first('bank_user_name') }}
                    </p>
                @endif
            </div>
            <form action="{{ url('/mypage/sales/application/confirm') }}" method="post">
                @csrf
                <table class="bank_table">
                    <tr>
                        <th>銀行名</th>
                        <td><input type="text" placeholder="サカナ銀行" name="bank_name" value="{{ old('bank_name', $bank_form['bank_name'] ?? $user->bank_name) }}"></td>
                    </tr>
                    <tr>
                        <th>支店コード</th>
                        <td><input class="input_branchCode" type="text" placeholder="001" name="bank_branch_code" value="{{ old('bank_branch_code', $bank_form['bank_branch_code'] ?? $user->bank_branch_code) }}"></td>
                    </tr>
                    <tr>
                        <th>口座種別</th>
                        <td>
                            <label class="accountType_label">
                                <select name="bank_type">
                                    @foreach (\App\Models\User::BANK_TYPE_NAME as $_k => $_v)
                                        <option value="{{ $_k }}" @if (old('bank_type', $bank_form['bank_type'] ?? $user->bank_type) ==  $_k) selected="selected" @endif>{{ $_v }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th>口座番号</th>
                        <td><input type="text" placeholder="1234567" name="bank_number" value="{{ old('bank_number', $bank_form['bank_number'] ?? $user->bank_number) }}"></td>
                    </tr>
                    <tr>
                        <th>口座名義（カナ）</th>
                        <td><input type="text" placeholder="ウザギ タロウ" name="bank_user_name" value="{{ old('bank_user_name', $bank_form['bank_user_name'] ?? $user->bank_user_name) }}"></td>
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
    <style>
        .error {
            color: red;
            text-align: center;
        }
    </style>
@endsection
