<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        if (request('clear')) {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Đã xoá giỏ hàng cũ!');
    }
        $cart = session('cart', []);
        $total = collect($cart)->sum(fn($i) => $i['quantity'] * $i['price']);
        return view('cart.index', compact('cart', 'total'));
    }
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $qty = max(1, (int) $request->qty); // đảm bảo >= 1

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $qty,
                'thumbnail' => $product->thumbnail,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }


    public function remove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        return back()->with('success', 'Đã xóa khỏi giỏ hàng!');
    }
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $qty = max(1, (int) $request->quantity);
            $cart[$id]['quantity'] = $qty;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cập nhật giỏ hàng thành công!');
    }
}
