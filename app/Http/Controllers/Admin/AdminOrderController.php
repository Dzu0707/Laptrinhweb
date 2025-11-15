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

        $status = request('status');

        $allowed = ['pending', 'completed', 'cancelled'];

        if (!in_array($status, $allowed)) {
            return back()->with('error', 'Trạng thái không hợp lệ!');
        }

        $order->status = $status;
        $order->save();

        $messages = [
            'pending' => 'Đơn hàng chuyển sang trạng thái: Chờ xử lý!',
            'completed' => 'Đơn hàng đã được hoàn tất!',
            'cancelled' => 'Đơn hàng đã bị hủy!',
        ];

        return back()->with('success', $messages[$status]);
    }
}
