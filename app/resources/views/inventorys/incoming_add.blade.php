@extends('layouts.app')

@section('content')
<div class="container">
    <h2>入荷予定登録</h2>

    <!-- エラーメッセージ表示 -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('incoming_store') }}">
        @csrf

        <div class="mb-3">
            <label for="product_id" class="form-label">商品ID</label>
            <select name="product_id" id="product_id" class="form-control">
                <option value="">選択してください</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="expected_date" class="form-label">入荷予定日</label>
            <input type="date" name="expected_date" id="expected_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">数量</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
            <label for="weight" class="form-label">重量</label>
            <input type="number" name="weight" id="weight" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">登録</button>
        <a href="{{ route('incoming_list') }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>
@endsection