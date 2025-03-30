<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Product;
use App\Models\Variant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        $count_cart = $carts->count();
        session(['count_cart' => $count_cart]);
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
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'variant_id' => 'nullable|exists:variants,id',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $quantityRequested = $validated['quantity'];
        $variant = null;
        $availableQuantity = 0;

        if ($request->filled('variant_id')) {
            $variant = Variant::findOrFail($validated['variant_id']);
            $availableQuantity = $variant->varriant_quantity;
        } else {
            $availableQuantity = $product->quantity;
        }

        if ($quantityRequested > $availableQuantity) {
            return redirect()->back()->with('error', 'Số lượng yêu cầu vượt quá số lượng tồn kho! Còn lại: ' . $availableQuantity);
        }

        $existingCart = Carts::where('product_id', $validated['product_id'])
            ->where('variant_id', $request->filled('variant_id') ? $validated['variant_id'] : null)
            ->when(Auth::check(), function ($query) {
                return $query->where('user_id', Auth::id());
            }, function ($query) use ($request) {
                return $query->where('session_id', $request->session_id);
            })
            ->first();

        if ($existingCart) {
            $newQuantity = $existingCart->quantity + $quantityRequested;
            if ($newQuantity > $availableQuantity) {
                return redirect()->back()->with('error', 'Tổng số lượng trong giỏ hàng vượt quá số lượng tồn kho! Còn lại: ' . $availableQuantity);
            }
            $existingCart->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            $cartData = [
                'session_id' => $request->session_id,
                'user_id' => Auth::id(),
                'product_id' => $validated['product_id'],
                'variant_id' => $request->filled('variant_id') ? $validated['variant_id'] : null,
                'quantity' => $quantityRequested,
                'price' => $validated['price'],
            ];
            Carts::create($cartData);
            Log::info('Cart created', $cartData);
        }

        $userId = Auth::user()->id ?? null;
        $sessionId = session()->getId();

        $carts = Carts::when($userId, function ($query) use ($userId) {
            return $query->where('user_id', $userId);
        }, function ($query) use ($sessionId) {
            return $query->where('session_id', $sessionId);
        })->get();

        $count_cart = $carts->sum('quantity');
        session(['count_cart' => $count_cart]);

        return redirect()->route('carts.index')->with('success', 'Giỏ hàng đã được thêm!');
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

        if (!$carts) {
            return redirect()->back()->with('error', 'Không tìm thấy giỏ hàng!');
        }
        $carts->delete();
        return redirect()->route('carts.index')->with('success', 'Giỏ hàng đã được xoá!');
    }
}
