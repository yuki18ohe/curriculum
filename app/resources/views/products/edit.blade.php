@extends('layouts.app')

@section('content')
<div class="container">
    <h2>商品編集</h2>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>商品名:</label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
        
        <label>重量 (g):</label>
        <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" required>
        
        <label>画像:</label>
        <input type="file" name="image">
        
        @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" width="100">
        @endif
        
        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection