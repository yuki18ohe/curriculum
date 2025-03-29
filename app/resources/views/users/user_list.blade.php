@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">ユーザー管理</h2>
    
    <!-- 検索フォーム -->
    <form method="GET" action="{{ route('users.list') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="ユーザー検索">
            <button type="submit" class="btn btn-primary">検索</button>
        </div>
    </form>

    <!-- ユーザー一覧 -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.delete.confirm', $user->id) }}" class="btn btn-danger btn-sm">削除</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('users.create') }}" class="btn btn-success">ユーザー追加</a>
</div>
@endsection