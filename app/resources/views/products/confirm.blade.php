@extends('layouts.app')

@section('content')
<div class="container">
    <h2>商品登録確認</h2>
    <form action="{{ route('products.store') }}" method="post">
        @csrf
        <p>商品名: {{ $validatedData['name'] }}</p>
        <p>重量: {{ $validatedData['weight'] }}g</p>
        @if(isset($validatedData['image']))
            <p>画像:</p>
            @if (!empty($validatedData['image']))
                <img src="{{ asset('storage/' . str_replace('public/', '', $validatedData['image'])) }}" alt="確認画像" width="150">
            @else
                <p>画像登録なし</p>
            @endif

            <!-- 画像のパスをhiddenに -->
            <input type="hidden" name="image" value="{{ $validatedData['image'] }}">
        @endif
        <!-- 入力値をhiddenで渡す -->
        <input type="hidden" name="name" value="{{ $validatedData['name'] }}">
        <input type="hidden" name="weight" value="{{ $validatedData['weight'] }}">
        
        <button type="submit" class="btn btn-success">登録する</button>
        <a href="{{ route('products.create') }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection