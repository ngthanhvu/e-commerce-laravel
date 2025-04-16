<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Response;

class CouponController extends Controller
{
    public function index()
    {
        $title = "Quản lý mã giảm giá";
        $search = request()->input('search');
        $perPage = request()->input('per_page', 10);
        $sortBy = request()->input('sort_by', 'id');
        $sortCoupon = request()->input('sort_coupon', 'desc');

        $query = Coupon::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }

        $query->orderBy($sortBy, $sortCoupon);

        $coupons = $query->paginate($perPage);

        $coupons->appends([
            'search' => $search,
            'per_page' => $perPage,
            'sort_by' => $sortBy,
            'sort_coupon' => $sortCoupon,
        ]);

        return view('admin.coupons.index', compact('title', 'coupons', 'search', 'perPage', 'sortBy', 'sortCoupon'));
    }

    public function create()
    {
        $title = "Thêm mã giảm giá";
        return view('admin.coupons.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'code' => 'required|string|max:50|unique:coupons,code',
                'discount' => 'required|numeric|min:0',
                'type' => 'required|in:fixed,percent',
                'min_order_amount' => 'nullable|numeric|min:0',
                'max_usage' => 'required|integer|min:1',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after:start_date',
                'is_active' => 'required|boolean',
            ],
            [
                'code.required' => 'Vui lòng nhập mã giảm giá',
                'discount.required' => 'Vui lòng nhập giá trị giảm',
                'type.required' => 'Vui lòng chọn loại mã',
                'min_order_amount.required' => 'Vui lòng nhập giá trị tối thiểu',
                'max_usage.required' => 'Vui lòng nhập số lần sử dụng tối đa',
                'start_date.required' => 'Vui lòng nhập ngày bắt đầu',
                'start_date.after_or_equal' => 'Ngày bắt đầu phải từ hôm nay trở đi',
                'end_date.required' => 'Vui lòng nhập ngày kết thúc',
                'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu',
                'is_active.required' => 'Vui lòng chọn trạng thái',
            ]
        );

        Coupon::create($request->all());

        return redirect()->route('admin.coupons.index')->with('success', 'Thêm mã giảm giá thành công!');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'discount' => 'required|numeric|min:0',
            'type' => 'required|in:fixed,percent',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_usage' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'required|boolean',
        ]);

        $coupon->update($request->all());

        return redirect()->route('admin.coupons.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return redirect()->back()->with('success', 'Xóa mã giảm giá thành công!');
    }

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
