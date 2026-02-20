@push('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth">
    <h1 class="page-title">Login</h1>

    <form method="POST" action="{{ route('login') }}" class="auth__form" novalidate>
        @csrf

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
            <button type="submit" class="btn btn--dark">ログイン</button>
        </div>
    </form>
</div>
@endsection