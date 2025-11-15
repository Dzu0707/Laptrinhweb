<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;

class PromotionController extends Controller
{
    public function apply(Request $request)
    {
        $code = $request->input('code');
        $promotion = Promotion::where('code', $code)->first();

        if (!$promotion || !$promotion->isValid()) {
            return back()->with('error', 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn!');
        }

        session(['promotion' => $promotion]);

        return back()->with('success', 'Đã áp dụng mã khuyến mãi thành công!');
    }

    public function remove()
    {
        session()->forget('promotion');
        return back()->with('success', 'Đã hủy mã khuyến mãi.');
    }
}
