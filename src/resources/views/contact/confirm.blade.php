@extends('layouts.app')

@section('title', 'Confirm')

@section('content')
<h1 class="page-title">Confirm</h1>

<div class="confirm">
    <table class="confirm__table">
        <tr class="confirm__row">
            <th class="confirm__head">お名前</th>
            <td class="confirm__data">{{ $data['first_name'] }} {{ $data['last_name'] }}</td>
        </tr>

        <tr class="confirm__row">
            <th class="confirm__head">性別</th>
            <td class="confirm__data">
                @if($data['gender'] == 1)
                男性
                @elseif($data['gender'] == 2)
                女性
                @else
                その他
                @endif
            </td>
        </tr>

        <tr class="confirm__row">
            <th class="confirm__head">メールアドレス</th>
            <td class="confirm__data">{{ $data['email'] }}</td>
        </tr>

        <tr class="confirm__row">
            <th class="confirm__head">電話番号</th>
            <td class="confirm__data">{{ $data['tel'] }}</td>
        </tr>

        <tr class="confirm__row">
            <th class="confirm__head">住所</th>
            <td class="confirm__data">{{ $data['address'] }}</td>
        </tr>

        <tr class="confirm__row">
            <th class="confirm__head">建物名</th>
            <td class="confirm__data">{{ $data['building'] }}</td>
        </tr>

        <tr class="confirm__row">
            <th class="confirm__head">お問い合わせの種類</th>
            <td class="confirm__data">{{ $category->content }}</td>
        </tr>

        <tr class="confirm__row">
            <th class="confirm__head">お問い合わせ内容</th>
            <td class="confirm__data">{!! nl2br(e($data['detail'])) !!}</td>
        </tr>
    </table>

    <div class="confirm__actions">
        <form action="/thanks" method="POST">
            @csrf
            <input type="hidden" name="first_name" value="{{ $data['first_name'] }}">
            <input type="hidden" name="last_name" value="{{ $data['last_name'] }}">
            <input type="hidden" name="gender" value="{{ $data['gender'] }}">
            <input type="hidden" name="email" value="{{ $data['email'] }}">
            <input type="hidden" name="tel1" value="{{ substr($data['tel'], 0, 3) }}">
            <input type="hidden" name="tel2" value="{{ substr($data['tel'], 3, 4) }}">
            <input type="hidden" name="tel3" value="{{ substr($data['tel'], 7) }}">
            <input type="hidden" name="address" value="{{ $data['address'] }}">
            <input type="hidden" name="building" value="{{ $data['building'] }}">
            <input type="hidden" name="categry_id" value="{{ $data['categry_id'] }}">
            <input type="hidden" name="detail" value="{{ $data['detail'] }}">

            <button type="submit" class="btn btn--primary">送信</button>
        </form>

        <form action="/back" method="POST">
            @csrf
            <input type="hidden" name="first_name" value="{{ $data['first_name'] }}">
            <input type="hidden" name="last_name" value="{{ $data['last_name'] }}">
            <input type="hidden" name="gender" value="{{ $data['gender'] }}">
            <input type="hidden" name="email" value="{{ $data['email'] }}">
            <input type="hidden" name="tel1" value="{{ substr($data['tel'], 0, 3) }}">
            <input type="hidden" name="tel2" value="{{ substr($data['tel'], 3, 4) }}">
            <input type="hidden" name="tel3" value="{{ substr($data['tel'], 7) }}">
            <input type="hidden" name="address" value="{{ $data['address'] }}">
            <input type="hidden" name="building" value="{{ $data['building'] }}">
            <input type="hidden" name="categry_id" value="{{ $data['categry_id'] }}">
            <input type="hidden" name="detail" value="{{ $data['detail'] }}">

            <button type="submit" class="btn btn--secondary">修正</button>
        </form>
    </div>
</div>
@endsection