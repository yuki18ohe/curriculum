@extends('layouts.app')

@section('content')
<div class="container">
    <h2>商品登録</h2>
    <form action="{{ route('products.confirm') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">商品名:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="weight">重量 (g):</label>
            <input type="number" name="weight" id="weight" class="form-control" value="{{ old('weight') }}" required>
        </div>
        <div class="form-group">
            <label for="image">画像 (任意):</label>
            <input type="file" name="image" id="image" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary">確認する</button>
    </form>
</div>
@endsection
