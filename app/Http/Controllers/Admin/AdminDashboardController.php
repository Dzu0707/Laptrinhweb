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
        $totalUsers    = User::count();
        $totalAdmins   = User::where('role', 'admin')->count();
        $totalProducts = Product::count();
        $totalOrders   = Order::count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalRevenue  = Order::where('status', 'completed')->sum('total');
        $pendingReviews = Review::where('approved', false)->count();

        $latestOrders = Order::with('user')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $topProducts = Product::withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalProducts',
            'totalOrders',
            'completedOrders',
            'totalRevenue',
            'pendingReviews',
            'latestOrders',
            'topProducts'
        ));
    }
}
