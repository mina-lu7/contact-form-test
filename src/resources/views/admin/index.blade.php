@push('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@extends('layouts.app')

@section('title', 'Admin')

@section('content')

<div class="admin">

    <h1 class="page-title">Admin</h1>

    <section class="search">
        <form method="GET" action="/search" class="search__form">

            <input
                class="search__input"
                type="text"
                name="keyword"
                placeholder="名前やメールアドレスを入力してください"
                value="{{ request('keyword') }}">

            <select class="search__select" name="gender">
                <option value="">性別</option>
                <option value="all" {{ request('gender')=='all' ? 'selected' : '' }}>全て</option>
                <option value="1" {{ request('gender')=='1' ? 'selected' : '' }}>男性</option>
                <option value="2" {{ request('gender')=='2' ? 'selected' : '' }}>女性</option>
                <option value="3" {{ request('gender')=='3' ? 'selected' : '' }}>その他</option>
            </select>

            <select class="search__select" name="category_id">
                <option value="">お問い合わせの種類</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id')==$category->id ? 'selected' : '' }}>
                    {{ $category->content }}
                </option>
                @endforeach
            </select>

            <input
                class="search__date"
                type="date"
                name="date"
                value="{{ request('date') }}">

            <button type="submit" class="btn btn--dark">検索</button>
            <a href="/reset" class="btn btn--light">リセット</a>
            <a href="{{ route('export', request()->query()) }}" class="btn btn--export">エクスポート</a>

        </form>
    </section>

    <section class="list">

        <div class="list__pagination">
            {{ $contacts->links('pagination::bootstrap-4') }}
        </div>

        <table class="table">
            <tr class="table__head">
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせ内容</th>
                <th></th>
            </tr>

            @foreach ($contacts as $contact)
            <tr class="table__row">
                <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>

                <td>
                    @if($contact->gender === 1)
                    男性
                    @elseif($contact->gender === 2)
                    女性
                    @else
                    その他
                    @endif
                </td>

                <td>{{ $contact->email }}</td>
                <td>{{ $contact->detail }}</td>

                <td>
                    <button
                        type="button"
                        class="detail-button btn btn--detail"
                        data-id="{{ $contact->id }}">
                        詳細
                    </button>
                </td>
            </tr>
            @endforeach
        </table>

    </section>

</div>

<div id="modal" class="modal" aria-hidden="true">
    <div class="modal__overlay" id="modal-overlay"></div>

    <div class="modal__panel" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <button type="button" class="modal__close" id="close-modal" aria-label="close">×</button>

        <div class="modal__body">
            <dl class="modal__list">
                <div class="modal__row">
                    <dt class="modal__term">お名前</dt>
                    <dd class="modal__desc" id="m-name"></dd>
                </div>

                <div class="modal__row">
                    <dt class="modal__term">性別</dt>
                    <dd class="modal__desc" id="m-gender"></dd>
                </div>

                <div class="modal__row">
                    <dt class="modal__term">メールアドレス</dt>
                    <dd class="modal__desc" id="m-email"></dd>
                </div>

                <div class="modal__row">
                    <dt class="modal__term">電話番号</dt>
                    <dd class="modal__desc" id="m-tel"></dd>
                </div>

                <div class="modal__row">
                    <dt class="modal__term">住所</dt>
                    <dd class="modal__desc" id="m-address"></dd>
                </div>

                <div class="modal__row">
                    <dt class="modal__term">建物名</dt>
                    <dd class="modal__desc" id="m-building"></dd>
                </div>

                <div class="modal__row">
                    <dt class="modal__term">お問い合わせの種類</dt>
                    <dd class="modal__desc" id="m-category"></dd>
                </div>

                <div class="modal__row">
                    <dt class="modal__term">お問い合わせ内容</dt>
                    <dd class="modal__desc modal__desc--multiline" id="m-detail"></dd>
                </div>
            </dl>

            <form method="POST" action="/delete" class="modal__actions">
                @csrf
                <input type="hidden" name="id" id="delete-id">
                <button type="submit" class="modal__delete">削除</button>
            </form>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('modal');
    const overlay = document.getElementById('modal-overlay');
    const closeBtn = document.getElementById('close-modal');

    const setText = (id, value) => {
        const el = document.getElementById(id);
        if (el) el.textContent = value ?? '';
    };

    const openModal = () => {
        modal.style.display = 'block';
        modal.setAttribute('aria-hidden', 'false');
    };

    const closeModal = () => {
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
    };

    document.querySelectorAll('.detail-button').forEach((button) => {
        button.addEventListener('click', async function() {
            const id = this.dataset.id;

            const response = await fetch(`/admin/contacts/${id}`);
            const data = await response.json();

            let genderText = '';
            if (data.gender === 1) genderText = '男性';
            else if (data.gender === 2) genderText = '女性';
            else genderText = 'その他';

            const categoryText = data.category ? data.category.content : '';

            setText('m-name', `${data.first_name} ${data.last_name}`);
            setText('m-gender', genderText);
            setText('m-email', data.email);
            setText('m-tel', data.tel);
            setText('m-address', data.address);
            setText('m-building', data.building ?? '');
            setText('m-category', categoryText);
            setText('m-detail', data.detail);

            document.getElementById('delete-id').value = id;

            openModal();
        });
    });

    closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', closeModal);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });
</script>

@endsection