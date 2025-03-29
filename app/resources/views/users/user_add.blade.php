@extends('layouts.app')

@section('content')
<div class="container">
    <h2>ユーザー登録</h2>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <label>名前：</label>
        <input type="text" name="name" required><br>

        <label>メールアドレス：</label>
        <input type="email" name="email" required><br>

        <label>パスワード：</label>
        <input type="password" name="password" required><br>

        <label>権限：</label><br>
        <input type="radio" name="role" value="admin" required> 管理者
        <input type="radio" name="role" value="employee" required> 一般ユーザー
        <br>

        <button type="submit" class="btn btn-primary">登録</button>
        <a href="{{ route('users.list') }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>
@endsection