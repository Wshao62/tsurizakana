@extends('layouts.admin_app')

@section('page_name', '編集 | ユーザー管理' )
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
                    <p class="success" >{{ session('status') }}</p>
                </div>
            @endif
            @if ($status != null)
                <div class="content_success_box">
                    <p class="success" >{{ $status }}</p>
                </div>
            @endif
            <div class="content_success_box" id ="divStatus" style="display: none;" >
                <p class="success" id="imageStatus">{{ "status" }}</p>
            </div>
            <form class="user_form" method="POST" action="{{ url('/admin/user/' . $userInfo['id'] .'/update')  }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-md-10 img_center">
                                    <img id="cover_preview" src="{{ $userInfo['coverpreview'] }}">
                                    <input id="coverpreview" name="coverpreview" value="{{ $userInfo['coverpreview'] }}" hidden>
                                    <img id="profile_preview" src="{{ $userInfo['profilepreview'] }}">
                                    <input id="profilepreview" name="profilepreview" value="{{ $userInfo['profilepreview'] }}" hidden>
                            </div>
                            <div class="col-md-10">
                                <div class="divFish">
                                    <a class="w-100 btn btn-default text-white btn_cover">カバー写真を削除</a>
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="divFish">
                                    <a class="w-100 btn btn-default text-white btn_profile">プロフィール写真を削除</a>
                                </div>
                            </div>

                            @if ($userInfo->isWaiting4Identification())
                                <div class="col-md-10 mt-5">
                                    <p class="alert alert-warning">
                                        本人確認書類が届いています。
                                        <a href="{{ url('/admin/user/'.$userInfo['id'].'/identification') }}"><button type="button" class="btn btn-warning mt-4 w-100">確認する</button></a>
                                    </p>
                                </div>
                            @endif

                            @if ($userInfo->isWaiting4BusinessIdentification())
                                <div class="col-md-10 mt-5">
                                    <p class="alert alert-warning">
                                        営業許可証書類が届いています。
                                        <a href="{{ url('/admin/user/'.$userInfo['id'].'/business-license') }}"><button type="button" class="btn btn-warning mt-4 w-100">確認する</button></a>
                                    </p>
                                </div>
                            @endif

                            @if ($userInfo->isIdentified())
                            <div class="col-md-10 mt-5 mb-2">
                                <div class="btn-group w-100">
                                    <button type="button" class="btn btn-default w-100" data-toggle="modal" data-target="#modal1">本人確認書類1</button>
                                    <div id="modal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <img src="{{ $userInfo->identification->getUrl(1) }}" class="img-responsive w-100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if (!empty($userInfo->identification->file_path2))
                                    <button type="button" class="btn btn-default border-left w-100" data-toggle="modal" data-target="#modal2">本人確認書類2</button>
                                    <div id="modal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <img src="{{ $userInfo->identification->getUrl(2) }}" class="img-responsive w-100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if ($userInfo->isBusinessIdentified())
                                <div class="col-md-10 mt-5 mb-2">
                                    <div class="btn-group w-100">
                                        <button type="button" class="btn btn-default w-100" data-toggle="modal" data-target="#modal3">営業許可証書類1</button>
                                        <div id="modal3" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <img src="{{ $userInfo->businessLicense->getUrl(1) }}" class="img-responsive w-100">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if (!empty($userInfo->businessLicense->file_path2))
                                            <button type="button" class="btn btn-default border-left w-100" data-toggle="modal" data-target="#modal4">営業許可証書類2</button>
                                            <div id="modal4" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <img src="{{ $userInfo->businessLicense->getUrl(2) }}" class="img-responsive w-100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-10 mt-5">
                                <div class="divFish">
                                    <a class="w-100 btn btn-primary btn_fish" href="{{ url('/admin/fish?seller_id='.$userInfo['id']) }}">売魚一覧</a>
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="divFish">
                                    <a class="w-100 btn btn-primary btn_blog" href="{{ url('/admin/blog?user_id='.$userInfo['id']) }}">ブログ一覧</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        @include('admin/parts/user/template_user_detail_edit', ['userInfo' => $userInfo])
                        <ul class="w-100 row">
                            <li class="offset-1 col-5">
                                <div class="edit w-100">
                                    <button class="btn btn-success w-100" type="submit" onclick="return confirm('ユーザー情報を更新しますか？')">更新</button>
                                </div>
                            </li>
                            <li class="offset-3 col-3">
                                <div class="del w-100">
                                    <a class="btn btn-danger w-100" onclick="return confirm('ユーザーを削除しますか?')" href="{{ url('/admin/user/' . $userInfo['id'] . '/delete')  }}">削除</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('before_end')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>

<script>
    $(function(){
        var isImageChanges = [];

        $(".btn_profile").click(function () {
                var ans = confirm("プロフィール写真を削除しますか？");
                var strhostname_ = window.location.hostname;
                var strprotocol = window.location.protocol;

                if (ans == true) {
                    var profile_preview = document.getElementById("profile_preview");
                    var newPath = strprotocol + "////" + strhostname_ + "/img/mypage/profile/default_profile.jpg";
                    profile_preview.src = newPath;
                    document.getElementById('profilepreview').value = null;
                    isImageChanges.push('Profile');

                    setStatus();
                }
        });

        $(".btn_cover").click(function() {
            var ans = confirm("カバー写真を削除しますか?");
                var strhostname_ = window.location.hostname;
                var strprotocol = window.location.protocol;

                if (ans == true) {
                    var cover_preview = document.getElementById("cover_preview");
                    var newPath = strprotocol + "////" + strhostname_ + "/img/mypage/profile/default_cover.jpg";
                    cover_preview.src = newPath;
                    document.getElementById('coverpreview').value = null;
                    isImageChanges.push('Cover');

                    setStatus();
                }
        });

        function setStatus(){
            str = "※このまま画像を削除する場合は、更新ボタンを押してください。"

            document.getElementById('imageStatus').innerHTML = str;
            document.getElementById("divStatus").style.display = "block";
        }
    });
</script>
@endsection
