<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory; // 在庫モデルを使用
use App\Product; // 商品モデルを使用
use App\User; // ユーザーモデルを使用


class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 在庫は confirmed_flag が true のデータのみ表示
    $query = Inventory::where('confirmed_flag', true)->with(['product', 'user']);
            // 検索フィルターの処理
            if ($request->filled('search')) {
                $query->whereHas('product', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->search . '%');
                });
            }

            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }


            $users = User::all(); // 検索用ユーザーリスト

            $inventories = $query->get(); // 在庫一覧を取得

                // 同一商品かつ同一ユーザーの在庫データを合計
    $groupedInventories = $inventories->groupBy(function ($item) {
        return $item->product_id . '-' . $item->user_id;
    })->map(function ($group) {

        // 数量と重量の合計を計算
        $totalQuantity = $group->sum('quantity');
        $totalWeight = $group->sum('weight');

       //  グループの最初の在庫を取得（合計しない）
       $firstInventory = $group->first(); // 最初のレコードを取得
    // 合計値を追加したデータを返す
    return [
        'product_id' => $firstInventory->product_id,
        'user_id' => $firstInventory->user_id,
        'total_quantity' => $totalQuantity,
        'total_weight' => $totalWeight,
        'product' => $firstInventory->product ?? null, // NULLチェック追加
        'user' => $firstInventory->user ?? null, // NULLチェック追加
    ];
});


    // グループ化した在庫データをコレクション形式に変換
$groupedInventories = $groupedInventories->values();

            return view('inventorys.inventory_list', compact('groupedInventories', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($product_id, $user_id)
    {
        // 同一商品かつ同一ユーザーの在庫データを取得
        $inventoriey = Inventory::where('product_id', $product_id)
                                ->where('user_id', $user_id)
                                ->where('confirmed_flag', true)  // 確定された在庫だけを対象
                                ->get();

        if ($inventoriey->isEmpty()) {
            return response()->json(['error' => '在庫が見つかりません'], 404);
        }

        // 数量と重量の合計
        $totalQuantity = $inventoriey->sum('quantity');
        $totalWeight = $inventoriey->sum('weight');

        // 最初の在庫データを使って商品の詳細を取得
        $firstInventory = $inventoriey->first();
        $product = $firstInventory->product;

        // モーダルに必要なデータを返す
        return response()->json([
            'product_name' => $product->name,
            'total_quantity' => $totalQuantity,
            'total_weight' => $totalWeight,
            'image' => asset('storage/' . $product->image),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id, $user_id)
{
    // ❶ 同一商品・同一ユーザーの確定済み在庫をすべて取得
    $inventories = Inventory::where('product_id', $product_id)
        ->where('user_id', $user_id)
        ->where('confirmed_flag', true)
        ->get();

    if ($inventories->isEmpty()) {
        return redirect()->route('inventory_list')->with('error', '在庫が見つかりません');
    }

    // ❷ すべての在庫を削除
    foreach ($inventories as $inventory) {
        $inventory->delete();
    }

    return redirect()->route('inventory_list')->with('success', '在庫を削除しました');
}
}
