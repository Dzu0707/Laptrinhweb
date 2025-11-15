<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // ✅ Hiển thị danh sách người dùng
    public function index()
    {
        $users = User::orderByDesc('id')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // ✅ Chỉnh sửa thông tin user
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // ✅ Cập nhật thông tin user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'password' => 'nullable|min:6'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công!');
    }

    // ✅ Xóa user
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Không thể tự xóa tài khoản của chính bạn!');
        }

        $user->delete();
        return back()->with('success', 'Xóa người dùng thành công!');
    }
}
