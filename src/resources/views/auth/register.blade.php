@push('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="auth">
    <h1 class="page-title">Register</h1>

    <form method="POST" action="{{ route('register') }}" class="auth__form" novalidate>
        @csrf

        <div class="auth__row">
            <label class="auth__label">お名前</label>
            <input class="auth__input" type="text" name="name" value="{{ old('name') }}">
            @error('name')
            <p class="auth__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth__row">
            <label class="auth__label">メールアドレス</label>
            <input class="auth__input" type="email" name="email" value="{{ old('email') }}">
            @error('email')
            <p class="auth__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth__row">
            <label class="auth__label">パスワード</label>
            <input class="auth__input" type="password" name="password">
            @error('password')
            <p class="auth__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth__actions">
            <button type="submit" class="btn btn--dark">登録</button>
        </div>
    </form>
</div>
@endsection