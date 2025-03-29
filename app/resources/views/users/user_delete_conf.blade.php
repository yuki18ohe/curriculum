@extends('layouts.app')

@section('content')
<div class="container">
    <h2>ユーザー削除確認</h2>
    <p>本当にユーザー「{{ $user->name }}」を削除してよろしいですか？</p>

    <form action="{{ url('/users/' . $user->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">削除</button>
        <a href="{{ route('users.list') }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>
@endsection