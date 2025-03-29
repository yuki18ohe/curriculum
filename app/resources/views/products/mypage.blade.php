@extends('layouts.app')

@section('content')
<div class="container">
    <h2>商品管理ページ</h2>

 


    <p>名前: {{ $user->name }}</p>
    <p>メールアドレス: {{ $user->email }}</p>

        <!-- 商品登録ボタン -->
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">商品登録</a>

    <h3>登録商品一覧</h3>
    @if($products->isEmpty())
        <p>登録されている商品はありません。</p>
    @else
        <ul>
            @foreach($products as $product)
                <li>
                    商品名: {{ $product->name }} / 重量: {{ $product->weight }}g
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100">
                    @endif
                </li>
                <tr>
    <td>
        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">詳細</a>
    </td>
</tr>
            @endforeach
        </ul>
    @endif
</div>
@endsection
