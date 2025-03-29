<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // マイページ（管理者）表示
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $users = User::where('role', 'employee')->get(); // 一般ユーザーのみ取得
            return view('users.user_list', compact('users'));
        }

        // 一般ユーザーの場合はマイページを表示
        $products = Product::where('user_id', $user->id)->get();
        return view('users.mypage', compact('user', 'products'));
    }

    public function userList(Request $request)
{
    $query = User::query();

    // 検索フィルターがある場合、名前またはメールアドレスで検索
    if ($request->filled('search') && !empty($request->search)) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request->search . '%')
              ->orWhere('email', 'LIKE', '%' . $request->search . '%');
        });
    }

    $users = $query->get(); // フィルタリングされたユーザーを取得
    return view('users.user_list', compact('users'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //ユーザー登録ページの表示
    public function create()
    {
        return view('users.user_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //新規ユーザーの登録処理
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,employee', // 追加
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // パスワードをハッシュ化
            'role' => $request->role, // 保存
        ]);

        return redirect()->route('users.list')->with('success', 'ユーザーを追加しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
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
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'shop_id' => 'required|integer',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'shop_id' => $request->shop_id,
        ]);

        return redirect()->route('users.list')->with('success', 'ユーザー情報を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //ユーザー削除処理
    public function destroy($id)
    {
        $user = User::findOrFail($id); // すべてのユーザーを取得
        $user->delete();

        return redirect()->route('users.list')->with('success', 'ユーザーを削除しました！');
    }
    //ユーザー削除確認ページ
    public function deleteConfirm($id)
    {
        $user = User::findOrFail($id); // すべてのユーザーを対象
        return view('users.user_delete_conf', compact('user'));
    }

}
