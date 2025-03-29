@extends('layouts.app')

@section('content')
<div class="container">
    <h2>ダッシュボード</h2>

    <!-- 通知セクション -->
    <div class="alert alert-info">
        ここに最新の通知が表示されます。
    </div>

    <!-- ナビゲーションボタン -->
    <div class="row">
        <div class="col-md-3">
            <a href="{{ route('inventory_list') }}" class="btn btn-primary btn-block">在庫一覧</a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('incoming_list') }}" class="btn btn-primary btn-block">入荷予定一覧</a>
        </div>
        @if(Auth::user()->role === 'admin')
            <div class="col-md-3">
                <a href="{{ route('products.index') }}" class="btn btn-warning btn-block">商品管理</a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('users.list') }}" class="btn btn-danger btn-block">ユーザー管理</a>
            </div>
        @endif
    </div>
</div>
@endsection