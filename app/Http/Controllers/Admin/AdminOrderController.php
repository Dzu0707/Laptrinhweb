<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }


    public function updateStatus($id)
    {
        $order = Order::findOrFail($id);
        $order->status = request('status');
        $order->save();

        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}
