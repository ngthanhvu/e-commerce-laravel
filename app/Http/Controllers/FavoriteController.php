<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index() {}

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $exists = Favorite::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Product already in favorites'
            ], 409);
        }

        $favorite = Favorite::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json(
            [
                'message' => 'Product added to favorites',
                'favorite' => $favorite
            ],
            201
        );
    }

    public function destroy($id)
    {
        $favorite = Favorite::find($id);
        $favorite->delete();
        return response()->json([
            'message' => 'Product removed from favorites'
        ], 200);
    }
}
