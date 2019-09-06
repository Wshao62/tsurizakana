<div class="divTable">
    <input id="id" class="input_length_full" name="id" value="{{ old('id', $userInfo['id']) }}" hidden>
    <label>
        <span>名前</span>
        <input id="name" class="input_length_full" type="text" name="name" value="{{ old('name', $userInfo['name']) }}">
    </label>
    @if ($errors->has('name'))
        <p class="error">
            {{ $errors->first('name') }}
        </p>
    @endif
    <label>
        <span>フリガナ</span>
        <input id="furigana" class="input_length_full" type="text" name="furigana" value="{{ old('furigana', $userInfo['furigana']) }}">
    </label>
    @if ($errors->has('furigana'))
        <p class="error">
            {{ $errors->first('furigana') }}
        </p>
    @endif
    <label>
        <span>メールアドレス</span>
        <input id="email" class="input_length_full" type="text" name="email" value="{{ old('email', $userInfo['email']) }}">
    </label>
    @if ($errors->has('email'))
        <p class="error">
            {{ $errors->first('email') }}
        </p>
    @endif
    <label>
        <span>パスワード</span>
        <input id="password" class="input_length_full" type="text" name="password">
    </label>
    @if ($errors->has('password'))
        <p class="error">
            {{ $errors->first('password') }}
        </p>
    @endif
    <label>
        <span>郵便番号</span>
        <input id="zipcode" class="input_length_full" type="text" name="zipcode" value="{{ old('zipcode', $userInfo['zipcode']) }}">
    </label>
    @if ($errors->has('zipcode'))
        <p class="error">
            {{ $errors->first('zipcode') }}
        </p>
    @endif
    <label>
        <span>都道府県</span>
        <select class="input_length_short" name="prefecture">
            <option value="">都道府県</option>
            @foreach (config('const.prefectures') as $_pref)
            <option value="{{ $_pref }}"@if (old('prefecture', $userInfo['prefecture']) ==  $_pref) selected="selected" @endif>{{ $_pref }}</option>
            @endforeach
        </select>
    </label>
    @if ($errors->has('prefecture'))
            <p class="error">{{ $errors->first('prefecture') }}</p>
    @endif
    <label>
        <span>公開住所</span>
        <input id="public_address" class="input_length_full" type="text" name="public_address" value="{{ old('public_address', $userInfo['public_address']) }}">
    </label>
    @if ($errors->has('public_address'))
        <p class="error">
            {{ $errors->first('public_address') }}
        </p>
    @endif
    <label>
        <span>非公開住所</span>
        <input id="private_address" class="input_length_full" type="text" name="private_address" value="{{ old('private_address', $userInfo['private_address']) }}">
    </label>
    @if ($errors->has('private_address'))
        <p class="error">
            {{ $errors->first('private_address') }}
        </p>
    @endif
    <label>
        <span>携帯番号</span>
        <input id="mobile_tel" class="input_length_full" type="text" name="mobile_tel" value="{{ old('mobile_tel', $userInfo['mobile_tel']) }}">
    </label>
    @if ($errors->has('mobile_tel'))
        <p class="error">
            {{ $errors->first('mobile_tel') }}
        </p>
    @endif
    <label>
        <span>電話番号</span>
        <input id="tel" class="input_length_full" type="text" name="tel" value="{{ old('tel', $userInfo['tel']) }}">
    </label>
    @if ($errors->has('tel'))
        <p class="error">
            {{ $errors->first('tel') }}
        </p>
    @endif
    <label>
        <span>自己紹介</span>
        <textarea id="introduction" class="input_length_full" type="text" name="introduction">{{ old('introduction', $userInfo['introduction']) }}</textarea>
    </label>
    @if ($errors->has('introduction'))
        <p class="error">
            {{ $errors->first('introduction') }}
        </p>
    @endif

    <hr>

    <label>
        <span>お店の名前</span>
        <input id="shop_name" class="input_length_full" type="text" name="shop_name" value="{{ old('shop_name', $userInfo['shop_name']) }}">
    </label>
    @if ($errors->has('shop_name'))
        <p class="error">
            {{ $errors->first('shop_name') }}
        </p>
    @endif
    <label>
        <span>お店の郵便番号</span>
        <input id="shop_zipcode" class="input_length_full" type="text" name="shop_zipcode" value="{{ old('shop_zipcode', $userInfo['shop_zipcode']) }}">
    </label>
    @if ($errors->has('shop_zipcode'))
            <p class="error">
                {{ $errors->first('shop_zipcode') }}
            </p>
        @endif
    <label>
        <span>お店の都道府県</span>
        <select class="input_length_short" name="shop_prefecture">
            <option value="">都道府県</option>
            @foreach (config('const.prefectures') as $_pref)
            <option value="{{ $_pref }}"@if (old('shop_prefecture', $userInfo['shop_prefecture']) ==  $_pref) selected="selected" @endif>{{ $_pref }}</option>
            @endforeach
        </select>
    </label>
    @if ($errors->has('shop_prefecture'))
            <p class="error">
                {{ $errors->first('shop_prefecture') }}
            </p>
        @endif
    <label>
        <span>お店の住所１</span>
        <input id="shop_address1" class="input_length_full" type="text" name="shop_address1" value="{{ old('shop_address1', $userInfo['shop_address1']) }}">
    </label>
    @if ($errors->has('shop_address1'))
        <p class="error">
            {{ $errors->first('shop_address1') }}
        </p>
    @endif
    <label>
        <span>お店の住所２</span>
        <input id="shop_address2" class="input_length_full" type="text" name="shop_address2" value="{{ old('shop_address2', $userInfo['shop_address2']) }}">
    </label>
    @if ($errors->has('shop_address2'))
        <p class="error">
            {{ $errors->first('shop_address2') }}
        </p>
    @endif

    <hr>

    <label>
        <span>銀行名</span>
        <input id="bank_name" class="input_length_full" type="text" name="bank_name" value="{{ old('bank_name', $userInfo['bank_name']) }}">
    </label>
    @if ($errors->has('bank_name'))
        <p class="error">
            {{ $errors->first('bank_name') }}
        </p>
    @endif
    <label>
        <span>支店コード</span>
        <input id="bank_branch_code" class="input_length_full" type="text" name="bank_branch_code" value="{{ old('bank_branch_code', $userInfo['bank_branch_code']) }}">
    </label>
    @if ($errors->has('bank_branch_code'))
        <p class="error">
            {{ $errors->first('bank_branch_code') }}
        </p>
    @endif
    <label>
        <span>口座種別</span>
            <select name="bank_type">
                <option value="">-----</option>
                @foreach (\App\Models\User::BANK_TYPE_NAME as $_k => $_v)
                <option value="{{ $_k }}" @if (old('bank_type', $userInfo['bank_type']) ==  $_k) selected="selected" @endif>{{ $_v }}</option>
                @endforeach
            </select>
    </label>
    @if ($errors->has('bank_type'))
        <p class="error">
            {{ $errors->first('bank_type') }}
        </p>
    @endif
    <label>
        <span>口座番号</span>
        <input id="bank_number" class="input_length_full" type="text" name="bank_number" value="{{ old('bank_number', $userInfo['bank_number']) }}">
    </label>
    @if ($errors->has('bank_number'))
        <p class="error">
            {{ $errors->first('bank_number') }}
        </p>
    @endif
    <label>
        <span>口座名義（カナ）</span>
        <input id="bank_user_name" class="input_length_full" type="text" name="bank_user_name" value="{{ old('bank_user_name', $userInfo['bank_user_name']) }}">
    </label>
    @if ($errors->has('bank_user_name'))
        <p class="error">
            {{ $errors->first('bank_user_name') }}
        </p>
    @endif
</div>