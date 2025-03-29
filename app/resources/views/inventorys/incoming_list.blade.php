@extends('layouts.app')

@section('content')
<div class="container">
    <h2>入荷予定一覧</h2>

    <!-- 検索フォーム -->
    <form method="GET" action="{{ route('incoming_list') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="商品名で検索">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            <button type="submit" class="btn btn-primary">検索</button>
        </div>
    </form>

    <!-- 入荷予定リスト -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品名</th>
                <th>数量</th>
                <th>重量</th>
                <th>入荷予定日</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($incomingStocks as $stock)
                <tr>
                    <td>{{ $stock->id }}</td>
                    <td>{{ $stock->product->name }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>{{ $stock->weight }}</td>
                    <td>{{ $stock->expected_date }}</td>
                    <td>
                        <!-- 編集ボタン -->
                        <a href="{{ route('incoming_edit', $stock->id) }}" class="btn btn-warning btn-sm">編集</a>

                        <!-- 削除ボタン -->
                        <a href="{{ route('incoming_delete_conf', $stock->id) }}" class="btn btn-danger btn-sm">削除</a>

                        <!-- 確定ボタン -->
                        <a href="{{ route('incoming_confirm', $stock->id) }}" class="btn btn-success btn-sm">確定</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- 追加ボタン -->
    <a href="{{ route('incoming_add') }}" class="btn btn-success">入荷予定登録</a>
</div>
@endsection