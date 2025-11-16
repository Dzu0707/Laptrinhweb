<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);
        $prevYear = $year - 1;

        // ==== DOANH THU THÁNG ====
        $monthlyRevenue = OrderItem::selectRaw(
            'MONTH(order_items.created_at) as month,
             SUM(quantity * price) as total'
        )
        ->join('orders', 'orders.id', '=', 'order_items.order_id')
        ->where('orders.status', 'completed')
        ->whereYear('order_items.created_at', $year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $monthlyRevenue = collect(range(1, 12))->map(fn($m) => (object)[
            'month' => $m,
            'total' => optional($monthlyRevenue->firstWhere('month', $m))->total ?? 0
        ]);

        // ==== KPI ====
        $totalRevenue = $monthlyRevenue->sum('total');
        $orderCount   = Order::whereYear('created_at', $year)->count();
        $cancelCount  = Order::where('status', 'cancelled')->whereYear('created_at', $year)->count();

        $lastYearRevenue = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereYear('order_items.created_at', $prevYear)
            ->where('orders.status', 'completed')
            ->sum(DB::raw('quantity * price'));

        $growthRate = $lastYearRevenue
            ? (($totalRevenue - $lastYearRevenue) / $lastYearRevenue) * 100
            : null;

        // ==== PIE CHART ====
        $statusDistribution = Order::select('status', DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', $year)
            ->groupBy('status')
            ->get();

        $statusLabelsMap = [
            'pending'   => 'Chờ xử lý',
            'completed' => 'Hoàn tất',
            'cancelled' => 'Đã hủy',
        ];

        $pieLabels = $statusDistribution->pluck('status')
            ->map(fn($s) => $statusLabelsMap[$s] ?? $s);

        $pieData = $statusDistribution->pluck('total');

        // ==== TOP BUYERS ====
        $topBuyers = User::select(
            'users.id', 'users.name',
            DB::raw('SUM(order_items.quantity * order_items.price) as spent')
        )
        ->join('orders', 'orders.user_id', '=', 'users.id')
        ->join('order_items', 'order_items.order_id', '=', 'orders.id')
        ->where('orders.status', 'completed')
        ->groupBy('users.id', 'users.name')
        ->orderByDesc('spent')
        ->take(5)->get();

        // ==== TOP PRODUCTS ====
        $topProducts = OrderItem::select(
            'product_id',
            DB::raw('SUM(quantity) as total_sold')
        )
        ->groupBy('product_id')
        ->orderByDesc('total_sold')
        ->with('product')
        ->take(5)->get();

        // ==== TOP CATEGORIES ====
        $topCategories = Category::select(
            'categories.id', 'categories.name',
            DB::raw('SUM(order_items.quantity) as total_sold')
        )
        ->join('products', 'products.category_id', '=', 'categories.id')
        ->join('order_items', 'order_items.product_id', '=', 'products.id')
        ->groupBy('categories.id', 'categories.name')
        ->orderByDesc('total_sold')
        ->take(5)->get();

        return view('admin.reports.index', compact(
            'year',
            'monthlyRevenue',
            'totalRevenue',
            'orderCount',
            'cancelCount',
            'growthRate',
            'statusDistribution',
            'topBuyers',
            'topProducts',
            'topCategories',
            'pieLabels',
            'pieData'
        ));
    }
}
