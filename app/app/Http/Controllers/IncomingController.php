<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\Product;
use App\User;
use Illuminate\Support\Facades\DB;


class IncomingController extends Controller
{
     // 入荷予定一覧ページの表示
     public function index(Request $request)
     {
         $query = Inventory::where('confirmed_flag', false);

         if ($request->has('search')) {
             $query->whereHas('product', function ($q) use ($request) {
                 $q->where('name', 'like', '%' . $request->search . '%');
             });
         }
         // 日付検索の追加
         if ($request->filled('date')) {
         $query->whereDate('expected_date', $request->date);
         }

         $incomingStocks = $query->get();

         return view('inventorys.incoming_list', compact('incomingStocks'));
     }

     // 入荷予定の登録ページ表示
     public function create()
     {
         $products = Product::all();
         $users = User::all();
         return view('inventorys.incoming_add', compact('products', 'users'));
     }

     // 入荷予定の保存
     public function store(Request $request)
     {
         $request->validate([
             'product_id' => 'required|exists:products,id',
             'quantity' => 'required|integer|min:1',
             'weight' => 'required|integer|min:1',
             'expected_date' => 'required|date',
         ]);

             // **ユーザーIDを設定**
    $user_id = auth()->id(); // ここでログインユーザーのIDを取得

    if (!$user_id) {
        return redirect()->back()->withErrors(['user_id' => 'ログインしてから登録してください']);
    }

         Inventory::create([
             'product_id' => $request->product_id,
             'user_id' => $user_id,
             'quantity' => $request->quantity,
             'weight' => $request->weight,
             'expected_date' => $request->expected_date,
             'confirmed_flag' => false,
         ]);

         return redirect()->route('incoming_list')->with('success', '入荷予定を登録しました');
     }

     // 入荷予定の編集ページ表示
     public function edit($id)
     {
        $stock = Inventory::findOrFail($id);
        $products = Product::all();

        return view('inventorys.incoming_edit', compact('stock', 'products'));
     }

     // 入荷予定の更新
     public function update(Request $request, $id)
     {
         $request->validate([
             'product_id' => 'required|exists:products,id',
             'quantity' => 'required|integer|min:1',
             'weight' => 'required|integer|min:1',
             'expected_date' => 'required|date',
         ]);

         $stock = Inventory::findOrFail($id);
         $stock->update([
             'product_id' => $request->product_id,
             'quantity' => $request->quantity,
             'weight' => $request->weight,
             'expected_date' => $request->expected_date,
         ]);

         return redirect()->route('incoming_list')->with('success', '入荷予定を更新しました');
     }

     // 入荷予定の削除
public function destroy($id)
{
    $incoming = Inventory::findOrFail($id);

    // 確定済みの入荷は削除できないようにする
    if ($incoming->confirmed_flag) {
        return redirect()->route('incoming_list')->with('error', '確定済みの入荷は削除できません');
    }

    $incoming->delete();
    return redirect()->route('incoming_list')->with('success', '入荷予定を削除しました');
}

// 入荷予定の確定
public function confirm($id)
{
    $incoming = Inventory::findOrFail($id);

    // 既に確定されている場合は処理しない
    if ($incoming->confirmed_flag) {
        return redirect()->route('incoming_list')->with('info', 'この入荷は既に確定されています');
    }

    $incoming->update(['confirmed_flag' => true]);




return redirect()->route('incoming_list')->with('success', '入荷を確定しました');
}
// 入荷予定の削除確認ページ
public function deleteConfirm($id)
{
    $stock = Inventory::findOrFail($id);
    return view('inventorys.incoming_delete_conf', compact('stock')); // フォルダ構成を確認
}
// 入荷確定の確認ページ
public function confirmPage($id)
{
    $stock = Inventory::findOrFail($id);
    return view('inventorys.incoming_confirm', compact('stock'));
}

 }
