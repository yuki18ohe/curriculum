@extends('layouts.app')

@section('content')
<div class="container">
    <h2>在庫一覧</h2>

    <!-- 検索フォーム -->
    <form method="GET" action="{{ route('inventory_list') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="商品名で検索">
            <select name="user_id" class="form-control">
                <option value="">すべてのユーザー</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">検索</button>
        </div>
    </form>

    <!-- 在庫リスト -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品名</th>
                <th>合計数量</th>
                <th>店舗ユーザー</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groupedInventories as $inventory)


                <tr>
                    <td>{{ $inventory['product_id'] }}</td> {{-- 商品ID --}}
                    <td>{{ $inventory['product']->name ?? '不明' }}</td> {{-- 商品名（NULLなら'不明'） --}}
                    <td>{{ $inventory['total_quantity'] }}</td> {{-- 合計数量 --}}
                    <td>{{ $inventory['user']->name ?? '不明' }}</td> {{-- ユーザー名（NULLなら'不明'） --}}
                    <td>
                        <button class="btn btn-info btn-sm" onclick="showInventoryDetail({{ $inventory['product']->id }}, {{ $inventory['user']->id ?? 'null' }})">詳細</button>
                        <form method="POST" action="{{ route('inventory.destroy', [$inventory['product_id'], $inventory['user_id']]) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- 追加ボタン -->
    <!-- 管理者のみ「商品管理へ」ボタンを表示 -->
    @if(auth()->user()->role == 'admin')
    <a href="{{ route('products.index') }}" class="btn btn-primary">商品管理へ</a>
@endif
</div>


<!-- モーダル -->
<div class="modal fade" id="inventoryDetailModal" tabindex="-1" aria-labelledby="inventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inventoryModalLabel">在庫詳細</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>商品名:</strong> <span id="inventoryName"></span></p>
                <p><strong>合計数量:</strong> <span id="totalQuantity"></span></p>
                <p><strong>合計重量:</strong> <span id="totalWeight"></span></p>
                <p><strong>画像:</strong></p>
                <img id="inventoryImage" src="" alt="商品画像" width="150">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>

<!-- Ajax -->
<script>
    function showInventoryDetail(product_id, user_id){
        $.ajax({
            url: '/inventory/' + product_id + '/' + user_id,
            type: 'GET',
            success: function(response) {
                // モーダルにデータをセット
                $('#inventoryName').text(response.product_name);
                $('#totalQuantity').text(response.total_quantity);
                $('#totalWeight').text(response.total_weight);
                $('#inventoryImage').attr('src', response.image);
                $('#inventoryDetailModal').modal('show');
            },
            error: function() {
                alert('在庫情報の取得に失敗しました');
            }
        });
    }
</script>

@endsection