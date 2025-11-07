<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     echo 'aaaaad'; die();
    // }
    public function index(Request $request)
    {
        // Lấy toàn bộ user
        $query = User::where('id', '!=', auth()->id());
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $users = $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        $query->orderBy('created_at', 'desc');
        $users = $query->paginate(10);

        // Truyền sang view
        return view('users.index', compact('users'));
    }
    public function profile(){
        $profiles = Auth::guard()->user();
        return view("users.profile", compact('profiles'));
    }
    public function edit(){
        $profiles = Auth::guard()->user();
        return view("users.edit", compact('profiles'));
    }
    public function update(UserUpdateRequest $request) {
        // Bước 1: Lấy dữ liệu đã được validate
        // UserUpdateRequest đã kiểm tra:
        $validated = $request->validated();
        // Đảm bảo user chỉ update chính profile của mình
        $users = Auth::guard()->user();
        DB::table('users')
            ->where('id', $users->id)
            ->update([
                'name' => $validated['name'],
                'fullname' => $validated['fullname'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'age' => $validated['age'] ?? null,
                'birth_day' => $validated['birth_day'] ?? null,
            ]);
        if($request->filled('password')) {
            //Tự động thêm salt ngẫu nhiên mã hóa
            $users->password = Hash::make($validated['password']);
        }
        //Lưu vào database
        $users->save();
        return redirect()->route('users.profile')->with('success', 'Cập nhật thông tin thành công!');
    }
    public function destroy(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            return redirect()->route('users.index')
                ->with('error', 'Không tìm thấy user');
        }
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Tài khoản đã được xóa');
    }
}
