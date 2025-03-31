<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Orders_item;
use App\Models\Carts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required',
            'payment_method' => 'required|in:cod,vnpay,momo',
        ]);
        $user = Auth::user();
        $cartItems = Carts::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Giỏ hàng trống');
        }

        DB::beginTransaction();

        try {
            $totalPrice = $cartItems->sum(fn($item) => $item->price * $item->quantity);
            $order = Orders::create([
                'user_id' => $user->id,
                'address_id' => $request->address_id,
                'payment_method' => $request->payment_method,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                Orders_item::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);
            }

            Carts::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('alert.success', $order->id)->with('success', 'Thêm đơn hàng thanh cong!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('alert.fail')->with('error', 'Có lỗi khi thêm đơn hàng!');
        }
    }

    public function show(Orders $orders)
    {
        //
    }


    public function edit(Orders $orders)
    {
        //
    }

    public function update(Request $request, Orders $orders)
    {
        //
    }

    public function destroy(Orders $orders)
    {
        //
    }
}
