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

        if ($rating->isLikedByUser($userId)) {
            RatingLike::where('user_id', $userId)->where('rating_id', $ratingId)->delete();
            $message = 'Đã bỏ thích bình luận!';
        } else {
            RatingLike::create([
                'user_id' => $userId,
                'rating_id' => $ratingId,
            ]);
            $message = 'Đã thích bình luận!';
        }

        // return redirect()->back()->with('success', $message);
        return response()->json(['success' => true, 'action' => 'liked', 'message' => 'Đã thích bình luận!']);
    }
}
