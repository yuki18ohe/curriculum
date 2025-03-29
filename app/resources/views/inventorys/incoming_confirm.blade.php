@extends('layouts.app')

@section('content')
<div class="container">
    <h2>入荷確定確認</h2>
    <p>本当にこの入荷予定を確定しますか？</p>

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

    <form method="POST" action="{{ route('incoming_confirm_process', $stock->id) }}">
        @csrf
        <button type="submit" class="btn btn-success">確定</button>
        <a href="{{ route('incoming_list') }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>
@endsection