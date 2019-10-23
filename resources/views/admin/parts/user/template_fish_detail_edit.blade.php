<div class="divTable">
    <label>
        <span>魚名</span>
        <input type="text" class="input_length_full" id="find_fish" name="fish_category_name" value="{{ old('fish_category_name', $fishInfo['fish_category_name']) }}">
    </label>
    @if ($errors->has('fish_category_name'))
        <p class="error">
            {{ $errors->first('fish_category_name') }}
        </p>
    @endif
    <label>
        <span>販売者</span>
        <select class="input_length_short" name="seller_id">
            @foreach ($userInfo as $user)
                <option value="{{ $user['id'] }}"@if (old('category', $fishInfo['seller_id']) ==  $user['id']) selected="selected"  @endif>{{ $user['name'] }}</option>
            @endforeach
        </select>
    </label>
    @if ($errors->has('seller_id'))
        <p class="error">
            {{ $errors->first('seller_id') }}
        </p>
    @endif
    <label>
        <span>購入者</span>
        <select class="input_length_short" name="buyer_id">
            @foreach ($userInfo as $user)
                <option value="{{ $user['id'] }}"@if (old('category', $fishInfo['buyer_id']) ==  $user['id']) selected="selected"  @endif>{{ $user['name'] }}</option>
            @endforeach
        </select>
    </label>
    @if ($errors->has('buyer_id'))
        <p class="error">
            {{ $errors->first('buyer_id') }}
        </p>
    @endif
    <label>
        <span>釣った場所</span>
        <input id="location" class="input_length_full" type="text" name="location" value="{{ old('location', $fishInfo['location']) }}">
    </label>
    @if ($errors->has('location'))
        <p class="error">
            {{ $errors->first('location') }}
        </p>
    @endif
    <label>
        <span>お届け場所</span>
        <input id="destination" class="input_length_full" type="text" name="destination" value="{{ old('destination', $fishInfo['destination']) }}">
    </label>
    @if ($errors->has('destination'))
        <p class="error">
            {{ $errors->first('destination') }}
        </p>
    @endif
    <label>
        <span>詳細</span>
        <textarea id="description" name="description">{{ old('description', $fishInfo['description']) }}</textarea>
    </label>
    @if ($errors->has('description'))
        <p class="error description">
            {{ $errors->first('description') }}
        </p>
    @endif
    <label>
        <span>価格</span>
        <input id="price" class="input_length_full" type="text" name="price" value="{{ old('price', $fishInfo['price']) }}">
    </label>
    @if ($errors->has('price'))
        <p class="error">
            {{ $errors->first('price') }}
        </p>
    @endif
    <label>
        <span>ステータス</span>
        <div class="input_length_short">
            <select class="input_length_short" name="status">
                @foreach ($statusArray as $key => $value)
                    <option value="{{ $key }}"@if (old('status', $fishInfo['status']) ==  $key) selected="selected"  @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </label>
    @if ($errors->has('status'))
        <p class="error">
            {{ $errors->first('status') }}
        </p>
    @endif
</div>


@section('before_end')
<!-- Theme jquery script -->
<link rel="stylesheet" href="/css/jquery-ui/jquery-ui.min.css">
<script src="{{url('/js/libs/jquery-ui.min.js')}}"></script>
<script >
    $(function(){
        let categories = [];
        let selectedId = '';
        $("#find_fish").autocomplete({
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
            autoFocus: true,
            delay: 0,
            minLength: 1
        });
    });

    var actionThis = function(element,status) {
                var id = $(element).attr('id');

                var Route = "/admin/fish/" + id + "/delete";
                var confirm_mssg = confirm('削除しますか?');

                if(confirm_mssg) {
                    $(".btn-danger").attr('href', Route);
                }
            }
</script>
@endsection
