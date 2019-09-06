<div id="page_addrequest">
    @if (session('error'))
        <span class="alert">{{ session('error') }}</span>
    @endif
    <div class="up_forms">
        <form  method="POST" action="{{ $action_url }}" enctype="multipart/form-data">
        @csrf
            <p class="text_point">魚名</p>
            <dd>
                <div class="form_date">
                    <input type="text" id="find_request" name="category_name" value="{{ old('category_name', $category_name) }}" placeholder="魚の名前を入れてください。">
                    @if ($errors->has('category_name'))
                        <span class="alert">
                            {{ $errors->first('category_name') }}
                        </span>
                    @endif
                </div>
            </dd>
            <p class="fish_item"><br class="hide_pc"><span></span></p>
            <a class="content_button js_link2list_btn" href="{{ url('/fish') }}">売魚を確認する</a>
            <div class="clear"></div>
            <dl class="up_forms">
            <p class="text_point">締切日</p>
            <dd>
                <div class="form_date">
                    <label>
                        <input class="js_request_calender request_calender"  name="request_date" value="{{ old('request_date', $request_date ? date('Y/m/d', strtotime($request_date)) : '') }}" autocomplete="off">
                    </label>
                    @if ($errors->has('request_date'))
                        <span class="alert">
                            {{ $errors->first('request_date') }}
                        </span>
                    @endif
                </div>
            </dd>
            <div class="up_btns">
                <input class="content_button" type="submit" name="" value="登録する">
                <div class="clear"></div>
            </div>
        </form>
    </div>
</div>
</div>
<!-- Theme External plugin script -->
<link rel="stylesheet" href="/css/picker-ui/jquery.datetimepicker.min.css">
<script src="/js/libs/jquery.datetimepicker.full.min.js"></script>
<script src="/js/calender.js"></script>

<!-- Theme jquery script -->
<link rel="stylesheet" href="/css/jquery-ui/jquery-ui.min.css">
<script src="/js/libs/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(function(){
        let listUrl = $('.js_link2list_btn').attr('href');
        let categories = [];
        let selectedId = '';
        $("#find_request").autocomplete({
            source: function( req, res ) {
                selectedId = '';
                $.ajax({
                    url: "{{ url('/fish/category') }}",
                    method: "POST",
                    dataType: "json",
                    data: {
                        keyword: req.term,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function( data ) {
                        categories = data;
                        res(data);
                    },
                    fail: function( jqXHR, textStatus, errorThrown ) {
                        console.log('error');
                    }
                });
            },
            select: function (event, ui) {
                selectedId = ui.item.id;
                $.ajax({
                    url: "{{ url('/mypage/fish/category') }}",
                    method: "POST",
                    data: {
                        keyword: ui.item.value,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $(".fish_item").html(ui.item.value + "は現在 <span>" + data + "</span> 件出品中です");
                    }
                }).always(function() {
                    let newUrl = listUrl + '?is_open=1&category_id='+selectedId;
                    $('.js_link2list_btn').attr('href', newUrl);
                });
            },
            autoFocus: true,
            delay: 0,
            minLength: 1
        });

        $('#find_request').on('change', function(){
            if (selectedId != '') {
                    $('.js_link2list_btn').attr('href', listUrl);
            }
        });
    });
</script>