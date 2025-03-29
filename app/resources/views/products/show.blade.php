@extends('layouts.app')

@section('content')
<div class="container">
    <h2>商品詳細</h2>
    <p><strong>商品名:</strong> {{ $product->name }}</p>
    <p><strong>重量:</strong> {{ $product->weight }} g</p>
    
    @if ($product->image)
        <p><strong>画像:</strong></p>
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="200">
    @endif

    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">編集</a>
    <a href="{{ route('products.delete.confirm', $product->id) }}" class="btn btn-danger">削除</a>
</div>
@endsection
