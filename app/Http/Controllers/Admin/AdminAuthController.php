<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tìm đúng user theo email
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return back()->with('error', 'Email không tồn tại.');
        }

        // Kiểm tra mật khẩu
        if (!Hash::check($data['password'], $user->password)) {
            return back()->with('error', 'Mật khẩu không đúng.');
        }

        // Kiểm tra quyền admin
        if ($user->role !== 'admin') {
            return back()->with('error', 'Bạn không có quyền truy cập admin.');
        }

        // Đăng nhập thủ công
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
