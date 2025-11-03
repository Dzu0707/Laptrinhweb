<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function show()
    {
        $cart = session('cart', []);
        return view('checkout.checkout', compact('cart'));
    }

    public function place(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|digits_between:9,12',
            'payment_method' => 'required',
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.digits_between' => 'Số điện thoại không hợp lệ.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.'
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng đang trống!');
        }

        DB::transaction(function () use ($cart, $request) {

            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => collect($cart)
                            ->sum(fn($item) => $item['price'] * $item['quantity']),
                'status' => 'pending',
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'payment_method' => $request->payment_method,
            ]);

            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            session()->forget('cart');
        });

        return redirect()->route('orders.mine')
            ->with('success', 'Đặt hàng thành công! Chúng tôi sẽ liên hệ xác nhận sớm nhất.');
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
                        ->latest()
                        ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function showOrder($orderId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $order = $user->orders()
                        ->with('items.product')
                        ->findOrFail($orderId);

        return view('orders.show', compact('order'));
    }
}
