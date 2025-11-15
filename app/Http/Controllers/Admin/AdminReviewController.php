<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'product'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function toggle(Review $review)
    {
        $review->approved = !$review->approved;
        $review->save();

        return back()->with('success', 'Cập nhật trạng thái đánh giá thành công!');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Đã xóa đánh giá!');
    }
}
