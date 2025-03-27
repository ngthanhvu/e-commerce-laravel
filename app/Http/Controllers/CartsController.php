<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartsController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id ?? null;
        $sessionId = session()->getId();

        $carts = Carts::with(['product.mainImage'])
            ->when($userId, function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            }, function ($query) use ($sessionId) {
                return $query->where('session_id', $sessionId);
            })
            ->get();

        $title = "Giỏ hàng";
        return view('carts', compact('title', 'carts'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);
        $carts = [
            'session_id' => session()->getId(),
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
        ];
        Carts::create($carts);
        Log::info('Cart created', $carts);
        return redirect()->route('carts.index')->with('success', 'Giỏ hàng đã được thêm!');
    }


    public function show(Carts $carts)
    {
        //
    }


    public function edit(Carts $carts)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $cart = Carts::find($id);
            if (!$cart) {
                return response()->json([
                    'message' => 'Không tìm thấy giỏ hàng!',
                    'status' => 'error',
                ], 404);
            }

            $cart->update([
                'quantity' => $request->quantity,
            ]);

            return response()->json([
                'message' => 'Giỏ hàng đã được cập nhật!',
                'status' => 'success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Lỗi khi cập nhật giỏ hàng! ' . $th->getMessage(),
                'status' => 'error',
            ], 500);
        }
    }


    public function delete($id)
    {
        $carts = Carts::find($id);
        $carts->delete();
        return redirect()->route('carts.index')->with('success', 'Giỏ hàng đã được xoá!');
    }

    public function destroy(Carts $carts)
    {
        $carts->delete();
        return redirect()->route('carts.index')->with('success', 'Giỏ hàng đã được xoá!');
    }
}
