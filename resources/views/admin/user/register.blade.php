@extends('layouts.admin_app')

@section('page_name', '新規登録 | ユーザー管理' )
@section('page_id', 'user_page')
@section('css', 'admin.css')

@section('content')
    <div class="layout">
        <div class="container">
        @if (session('error'))
        <p class="content_alert_box alert">{{ session('error') }}</p>
        @endif
        @if (session('status'))
            <div class="content_success_box">
                <p class="success">{{ session('status') }}</p>
            </div>
        @endif
            <form class="user_form" method="POST" action="{{ url('/admin/user/register') }}" enctype="multipart/form-data">
                @csrf
                <div class="row divEdit">
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="edit">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-md-10 img_center">
                                <img id="profilepreview" src="{{ $userInfo['profilepreview'] }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        @include('admin/parts/user/template_user_detail_edit', ['userInfo' => $userInfo])
                        <ul class="row w-100">
                            <li class="offset-1 col-5">
                                <div class="edit w-100">
                                    <button class="btn btn-success w-100" type="submit" onclick="return confirm('新規ユーザーを作成しますか？')">登録する</button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>

 @endsection