@extends('layouts.app')

@section('content')
<div class="container">
    <h2>入荷予定削除確認</h2>
    <p>以下の入荷予定を削除しますか？</p>

    <table class="table">
        <tr>
            <th>ID</th>
            <td>{{ $stock->id }}</td>
        </tr>
        <tr>
            <th>商品名</th>
            <td>{{ $stock->product->name }}</td>
        </tr>
        <tr>
            <th>数量</th>
            <td>{{ $stock->quantity }}</td>
        </tr>
        <tr>
            <th>重量</th>
            <td>{{ $stock->weight }}</td>
        </tr>
        <tr>
            <th>入荷予定日</th>
            <td>{{ $stock->expected_date }}</td>
        </tr>
    </table>

    <form method="POST" action="{{ route('incoming_delete', $stock->id) }}">
        @csrf
        <button type="submit" class="btn btn-danger">削除</button>
        <a href="{{ route('incoming_list') }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>
@endsection