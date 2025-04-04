<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Product;
use App\Models\RatingLike;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|in:1,2,3,4,5',
            'comment' => 'nullable|string|max:500',
        ]);

        $product = Product::findOrFail($productId);

        Rating::create([
            'user_id' => Auth::user()->id,
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi!');
    }

    public function like($ratingId)
    {
        $rating = Rating::findOrFail($ratingId);
        $userId = Auth::user()->id;

        RatingLike::create([
            'user_id' => $userId,
            'rating_id' => $ratingId,
        ]);

        return response()->json([
            'success' => true,
            'action' => 'liked',
            'message' => 'Đã thích bình luận!',
            'likes_count' => $rating->likes()->count()
        ]);
    }

    public function destroy($ratingId)
    {
        $rating = Rating::findOrFail($ratingId);

        if ($rating->user_id !== Auth::user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền xóa bình luận này!'
            ], 403);
        }

        $rating->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bình luận đã được xóa!'
        ]);
    }
}
