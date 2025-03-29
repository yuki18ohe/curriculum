@extends('layouts.app')

@section('content')
<div class="container">
    <h2>入荷予定編集</h2>

    <form method="POST" action="{{ route('incoming_update', $stock->id) }}">
        @csrf
        <div class="mb-3">
            <label for="product_id" class="form-label">商品ID</label>
            <select name="product_id" id="product_id" class="form-control">
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $stock->product_id == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="expected_date" class="form-label">入荷予定日</label>
            <input type="date" name="expected_date" id="expected_date" class="form-control" value="{{ $stock->expected_date }}">
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">数量</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $stock->quantity }}">
        </div>

        <div class="mb-3">
            <label for="weight" class="form-label">重量</label>
            <input type="number" name="weight" id="weight" class="form-control" value="{{ $stock->weight }}">
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
        <a href="{{ route('incoming_list') }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>
@endsection