<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Response;

class CouponController extends Controller
{
    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $totalAmount = $request->input('total_amount');

        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', true)
            // ->where('start_date', '<=', now())
            // ->where('end_date', '>=', now())
            // ->where('used_count', '<', 'max_usage')
            ->first();

        if (!$coupon) {
            return Response::json([
                'success' => false,
                'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.'
            ], 400);
        }

        if ($coupon->min_order_amount && $totalAmount < $coupon->min_order_amount) {
            return Response::json([
                'success' => false,
                'message' => 'Đơn hàng chưa đạt giá trị tối thiểu để áp dụng mã này.'
            ], 400);
        }

        $discount = $coupon->type === 'fixed'
            ? $coupon->discount
            : ($totalAmount * $coupon->discount / 100);

        $newTotal = $totalAmount - $discount;

        return Response::json([
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'discount' => $discount,
            'new_total' => $newTotal
        ]);
    }
}
