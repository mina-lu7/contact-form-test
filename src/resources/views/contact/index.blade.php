@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<h1 class="page-title">Contact</h1>

<form action="/confirm" method="POST" class="form">
    @csrf

    <!-- お名前 -->
    <div class="form__row">
        <div class="form__label">
            お名前 <span class="form__required">※</span>
        </div>
        <div class="form__control">
            <div class="form__name">
                <div class="form__field">
                    <input class="input" type="text" name="first_name" placeholder="例：山田" value="{{ old('first_name') }}">
                    @error('first_name')
                    <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form__field">
                    <input class="input" type="text" name="last_name" placeholder="例：太郎" value="{{ old('last_name') }}">
                    @error('last_name')
                    <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- 性別 -->
    <div class="form__row">
        <div class="form__label">
            性別 <span class="form__required">※</span>
        </div>
        <div class="form__control">
            <div class="form__radio">
                <label class="radio">
                    <input type="radio" name="gender" value="1" {{ old('gender') == 1 ? 'checked' : '' }}>
                    <span>男性</span>
                </label>
                <label class="radio">
                    <input type="radio" name="gender" value="2" {{ old('gender') == 2 ? 'checked' : '' }}>
                    <span>女性</span>
                </label>
                <label class="radio">
                    <input type="radio" name="gender" value="3" {{ old('gender') == 3 ? 'checked' : '' }}>
                    <span>その他</span>
                </label>
            </div>
            @error('gender')
            <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- メールアドレス -->
    <div class="form__row">
        <div class="form__label">
            メールアドレス <span class="form__required">※</span>
        </div>
        <div class="form__control">
            <input class="input" type="text" name="email" placeholder="例：test@example.com" value="{{ old('email') }}">
            @error('email')
            <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- 電話番号 -->
    <div class="form__row">
        <div class="form__label">
            電話番号 <span class="form__required">※</span>
        </div>
        <div class="form__control">
            <div class="form__tel">
                <input class="input input--tel" type="text" name="tel1" placeholder="090" value="{{ old('tel1') }}">
                <span class="form__tel-hyphen">-</span>
                <input class="input input--tel" type="text" name="tel2" placeholder="1234" value="{{ old('tel2') }}">
                <span class="form__tel-hyphen">-</span>
                <input class="input input--tel" type="text" name="tel3" placeholder="5678" value="{{ old('tel3') }}">
            </div>

            @if ($errors->has('tel1') || $errors->has('tel2') || $errors->has('tel3'))
            <p class="form__error">
                {{ $errors->first('tel1') ?: ($errors->first('tel2') ?: $errors->first('tel3')) }}
            </p>
            @endif
        </div>
    </div>

    <!-- 住所 -->
    <div class="form__row">
        <div class="form__label">
            住所 <span class="form__required">※</span>
        </div>
        <div class="form__control">
            <input class="input" type="text" name="address" placeholder="例：東京都渋谷区…" value="{{ old('address') }}">
            @error('address')
            <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- 建物名 -->
    <div class="form__row">
        <div class="form__label">
            建物名
        </div>
        <div class="form__control">
            <input class="input" type="text" name="building" placeholder="例：○○マンション101" value="{{ old('building') }}">
        </div>
    </div>

    <!-- お問い合わせの種類 -->
    <div class="form__row">
        <div class="form__label">
            お問い合わせの種類 <span class="form__required">※</span>
        </div>
        <div class="form__control">
            <div class="select select--narrow">
                <select name="categry_id" class="select__control">
                    <option value="" disabled {{ old('categry_id') ? '' : 'selected' }}>選択してください</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('categry_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->content }}
                    </option>
                    @endforeach
                </select>
            </div>
            @error('categry_id')
            <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- お問い合わせ内容 -->
    <div class="form__row form__row--textarea">
        <div class="form__label">
            お問い合わせ内容 <span class="form__required">※</span>
        </div>
        <div class="form__control">
            <textarea class="textarea" name="detail" placeholder="お問い合わせ内容を入力してください">{{ old('detail') }}</textarea>
            @error('detail')
            <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn btn--primary">確認画面</button>
    </div>
</form>
@endsection