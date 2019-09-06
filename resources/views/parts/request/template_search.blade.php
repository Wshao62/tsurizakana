<div class="request_search_input">
    @if ($isSearch == "list")
    <div class="request_search_area">
        <div class="request_status_select">          
            <select class="input_length_short" name="status">
                <option value=""  @if ($status == "") selected @endif>-</option>
                <option value="0" @if ($status == "0") selected @endif>表示終了</option>
                <option value="1" @if ($status == "1") selected @endif>表示中</option>
            </select>
        </div>
    </div>
    @endif
    <label class="request_search_fish">
        <span>魚の名前</span>
        <input name="category" value="{{ $category }}" placeholder="(例)マグロ">
    </label>
    @if ($isSearch == "confirm")
    <label class="request_search_area">
        <span>エリア</span>
        <div>
            <select class="input_length_short" name="area">
                <option value="">都道府県</option>
                @foreach (config('const.prefectures') as $_pref)
                <option value="{{ $_pref }}" @if (old('area', $area)  ==  $_pref) selected="selected" @endif>{{ $_pref }}</option>
                @endforeach
            </select>
        </div>
    </label>
    @endif
    @if ($isSearch == "confirm")
    <label class="request_search_detail"> 
        <span>ユーザー名</span>
        <input   placeholder="(例)田中" name="username" value="{{ $username }}">
    </label> 
    @endif
    <label class="request_search_day">
    <span>希望日</span>
    <input class="js_search_calender request_calender" name="date" value="{{ $date }}" placeholder="(例)2018/11/01" autocomplete="off">
    </label>
</div>