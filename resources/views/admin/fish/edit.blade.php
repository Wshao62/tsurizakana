@extends('layouts.admin_app')

@section('page_name', '釣魚編集' )
@section('page_id', 'fish_page')
@section('css', 'admin.css')

@section('content')
<div class="layout">
    <div class="container">
        @if(!empty($status))
            <div class="content_success_box">
                <p class="success">{{ $status }}</p>
            </div>
        @endif
        @if (session('error'))
            <p class="content_alert_box alert">{{ session('error') }}</p>
        @endif

        <form class="fish_form" method="POST" action="{{ url('/admin/fish/' . $fishInfo['id'] .'/update')  }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
            <input id="id" class="input_length_full" type="text" name="id" value="{{ old('id', $fishInfo['id']) }}" hidden>

                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-md-10 img_center">
                            <img id="photo" src="{{ $fishInfo['photo'] }}">
                        </div>

                        <div class="col-md-10">
                                <div class="divFish">
                                    <a class="btn btn-default w-100" href="{{url('admin/fish/message',$fishInfo['id'])}}">メッセージ一覧</a>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    @include('admin/parts/user/template_fish_detail_edit', ['fishInfo' => $fishInfo])
                    <ul class="w-100 row">
                        <li class="offset-1 col-5">
                            <div class="edit w-100">
                                <button class="btn btn-success w-100 active" type="submit" onclick="return confirm('更新しますか？')">更新</button>
                            </div>
                        </li>
                        <li class="offset-md-3 col-3">
                            <div class="del w-100">
                                <a class="btn btn-danger w-100 active"  href='javascript:;' id="{{$fishInfo['id']}}" onclick='actionThis(this, {{$fishInfo["status"]}})' data-toggle="tooltip">削除</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
