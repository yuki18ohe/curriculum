@extends('layouts.app')

@section('content')
<div class="container">
    <h2>ユーザー詳細</h2>
    <p><strong>名前:</strong> {{ $user->name }}</p>
    <p><strong>メール:</strong> {{ $user->email }}</p>
    <p><strong>店舗ID:</strong> {{ $user->shop_id }}</p>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">戻る</a>
</div>
@endsection