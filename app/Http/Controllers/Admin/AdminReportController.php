<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);

        // 📈 Doanh thu theo tháng
        $monthlyRevenue = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total) as total')
        )
        ->whereYear('created_at', $year)
        ->where('status', 'completed')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // 🔝 Top 5 sản phẩm bán chạy
        $topProducts = OrderItem::select(
            'product_id',
            DB::raw('SUM(quantity) as total_sold')
        )
        ->groupBy('product_id')
        ->orderByDesc('total_sold')
        ->with('product')
        ->take(5)
        ->get();

        // 🔝 Top 5 danh mục bán chạy
        $topCategories = Category::select(
            'categories.id',
            'categories.name',
            DB::raw('SUM(order_items.quantity) as total_sold')
        )
        ->join('products', 'products.category_id', '=', 'categories.id')
        ->join('order_items', 'order_items.product_id', '=', 'products.id')
        ->groupBy('categories.id', 'categories.name')
        ->orderByDesc('total_sold')
        ->take(5)
        ->get();

        return view('admin.reports.index', compact(
            'year',
            'monthlyRevenue',
            'topProducts',
            'topCategories'
        ));
    }
}
