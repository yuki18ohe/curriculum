<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }
     // 入力内容の確認画面へ遷移
     public function confirm(Request $request)
     {
         // バリデーション実施
         $validatedData = $request->validate([
             'name'   => 'required|string|max:255',
             'weight' => 'required|integer',
             'image'  => 'nullable|image|max:2048',  // 画像アップロードのバリデーション
         ]);
         
         // 画像がアップロードされていた場合、一旦一時保存
         if ($request->hasFile('image')) {
             // ※ 一時保存用ディレクトリ（例：temp）に保存
             $imagePath = $request->file('image')->store('temp');
             $validatedData['image'] = $imagePath;
         }
         
         // 確認画面にバリデート済みのデータを渡す
         return view('products.confirm', compact('validatedData'));
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                // 再度バリデーション（念のため）
                $data = $request;

                $product = new Product();
                $product->user_id = Auth::id();
                $product->name    = $data['name'];
                $product->weight  = $data['weight'];
                
                if (!empty($data['image'])) {
                    // 画像を正式な保存先に移動する場合の例（※ここではそのまま使う場合）
                    // 一時保存された画像のパス (temp/xxx.jpg)
                    $tempPath = $data['image'];

                    // 新しい保存先のパスを設定（storage/app/public/products/ に移動）
                    $newPath = 'public/products/' . basename($tempPath);

                    // temp から products に移動
                    Storage::move($tempPath, $newPath);

                    // DB には 'public/' を除いたパスを保存
                    $product->image = str_replace('public/', '', $newPath);
                }
                $product->save();
        
               return redirect()->route('mypage')->with('success', '商品が登録されました！');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        return view('products.edit', compact('product'));
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
        $product = Product::where('user_id', Auth::id())->findOrFail($id);

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'weight' => 'required|integer',
        'image' => 'nullable|image|max:2048',
    ]);

    $product->name = $validatedData['name'];
    $product->weight = $validatedData['weight'];

    if ($request->hasFile('image')) {
        // 既存の画像を削除
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }

        // 新しい画像を保存
        $path = $request->file('image')->store('public/products');
        $product->image = str_replace('public/', '', $path);
    }

    $product->save();

    return redirect()->route('products.show', $product->id)->with('success', '商品情報を更新しました！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);

    // 画像があれば削除
    if ($product->image) {
        Storage::delete('public/' . $product->image);
    }

    // 商品削除
    $product->delete();

    return redirect()->route('mypage')->with('success', '商品を削除しました！');
    }
}
