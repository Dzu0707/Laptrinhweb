<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class AdminPromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->paginate(10);
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:promotions,code',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:1',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
        ]);

        Promotion::create($request->all());

        return redirect()->route('admin.promotions.index')
                         ->with('success', 'Đã thêm mã khuyến mãi thành công!');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return back()->with('success', 'Đã xóa mã khuyến mãi!');
    }
}
