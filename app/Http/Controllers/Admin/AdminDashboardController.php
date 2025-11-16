<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ======== THỐNG KÊ NHANH ========
        $totalUsers      = User::count();
        $totalAdmins     = User::where('role', 'admin')->count();
        $totalProducts   = Product::count();
        $totalOrders     = Order::count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalRevenue    = Order::where('status', 'completed')->sum('total');
        $pendingReviews  = Review::where('approved', false)->count();

        // ======== ĐƠN HÀNG MỚI ========
        $latestOrders = Order::with('user')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // ======== TOP SẢN PHẨM ========
        $topProducts = Product::withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->limit(5)
            ->get();

        // ======== DỮ LIỆU BIỂU ĐỒ TRÒN ========
        $orderChart = [
            'completed' => Order::where('status', 'completed')->count(),
            'pending'   => Order::where('status', 'pending')->count(),
            'canceled'  => Order::where('status', 'canceled')->count(),
            'other'     => Order::whereNotIn('status', ['completed', 'pending', 'canceled'])->count(),
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalProducts',
            'totalOrders',
            'completedOrders',
            'totalRevenue',
            'pendingReviews',
            'latestOrders',
            'topProducts',
            'orderChart' 
        ));
    }
}
