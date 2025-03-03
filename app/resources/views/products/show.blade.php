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
    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">削除</button>
    </form>
    <a href="{{ route('mypage') }}" class="btn btn-secondary">マイページへ戻る</a>
</div>
@endsection
