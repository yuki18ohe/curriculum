@extends('layouts.app')

@section('content')
<div class="container">
    <h2>商品削除確認</h2>
    <p><strong>商品名:</strong> {{ $product->name }}</p>
    <p><strong>重量:</strong> {{ $product->weight }} g</p>

    @if ($product->image)
        <p><strong>画像:</strong></p>
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="200">
    @endif

    <p>この商品を削除してもよろしいですか？</p>

    <form action="{{ route('products.delete', $product->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">削除</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>
@endsection