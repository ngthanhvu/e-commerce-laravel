<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Orders_item;
use App\Models\Product;
use App\Models\Category;
use App\Models\Address;
use App\Models\User;
use App\Models\Carts;
use App\Models\Orders;

class HomeController extends Controller
{
    public function index()
    {
        $title = "Trang chủ";

        $products = Product::with('category', 'mainImage', 'variants', 'images')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $categories = Category::with(['products' => function ($query) {
            $query->with('mainImage', 'variants', 'images');
        }])
            ->has('products')
            ->get();

        $list_category = Category::latest()->take(4)->get();

        return view('index', compact('products', 'categories', 'title', 'list_category'));
    }

    public function admin()
    {
        $title = "Trang quản trị";

        $totalRevenue = Orders::sum('total_price');

        $monthlyRevenue = Orders::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as revenue')
        )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        $topProducts = Orders_item::select(
            'product_id',
            DB::raw('SUM(quantity) as total_quantity'),
            DB::raw('SUM(subtotal) as total_revenue')
        )
            ->with(['product.mainImage'])
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        $totalUsers = User::count();
        $totalOrders = Orders::count();
        $totalStock = Product::sum('quantity');

        $months = range(1, 12);

        $monthlyOrders = Orders::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as order_count')
        )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('order_count', 'month')
            ->all();

        $monthlyProducts = Orders_item::select(
            DB::raw('MONTH(orders.created_at) as month'),
            DB::raw('SUM(quantity) as product_count')
        )
            ->join('orders', 'orders_item.order_id', '=', 'orders.id')
            ->groupBy(DB::raw('MONTH(orders.created_at)'))
            ->pluck('product_count', 'month')
            ->all();

        $monthlyUsers = User::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as user_count')
        )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('user_count', 'month')
            ->all();

        $actualRevenue = Orders_item::join('products', 'orders_item.product_id', '=', 'products.id')
            ->join('orders', 'orders_item.order_id', '=', 'orders.id')
            ->sum(DB::raw('orders_item.quantity * GREATEST(orders_item.price - products.original_price, 0)'));


        $monthlyActualRevenue = Orders_item::join('products', 'orders_item.product_id', '=', 'products.id')
            ->join('orders', 'orders_item.order_id', '=', 'orders.id')
            ->select(
                DB::raw('MONTH(orders.created_at) as month'),
                DB::raw('SUM(orders_item.quantity * GREATEST(orders_item.price - products.original_price, 0)) as actual_revenue')
            )
            ->groupBy(DB::raw('MONTH(orders.created_at)'))
            ->orderBy('month')
            ->get();

        $orderData = array_map(fn($month) => $monthlyOrders[$month] ?? 0, $months);
        $productData = array_map(fn($month) => $monthlyProducts[$month] ?? 0, $months);
        $userData = array_map(fn($month) => $monthlyUsers[$month] ?? 0, $months);

        return view('admin.index', compact(
            'title',
            'totalRevenue',
            'monthlyRevenue',
            'topProducts',
            'totalUsers',
            'orderData',
            'productData',
            'userData',
            'totalOrders',
            'totalStock',
            'actualRevenue',
            'monthlyActualRevenue',
        ));
    }

    public function products(Request $request)
    {
        $title = "Danh sách sản phẩm";

        $categoryId = $request->query('category_id');
        $search = $request->query('search');
        $priceMax = $request->query('price_max', 10000000);
        $sort = $request->query('sort');

        $query = Product::with('category', 'mainImage', 'variants', 'images');

        if ($categoryId) {
            $category = Category::findOrFail($categoryId);
            $childIds = $category->getAllChildIds();
            $categoryIds = array_merge([$categoryId], $childIds);
            $query->whereIn('category_id', $categoryIds);
        }

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $query->where('price', '<=', $priceMax);

        if ($sort) {
            switch ($sort) {
                case 'name-az':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name-za':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price-high-low':
                    $query->orderBy('price', 'desc');
                    break;
                case 'price-low-high':
                    $query->orderBy('price', 'asc');
                    break;
            }
        }

        // $products = $query->get();
        $products = $query->paginate(12);

        $categories = Category::whereNull('parent_id')->with('allChildren')->get();

        return view('products', compact('products', 'categories', 'title', 'search', 'priceMax', 'sort', 'categoryId'));
    }

    public function profile()
    {
        $title = "Thông tin cá nhân";
        $profile = User::find(Auth::user()->id);
        return view('profile.profile', compact('title', 'profile'));
    }

    public function address()
    {
        $title = "Địa chỉ";
        $addresses = Address::where('user_id', Auth::user()->id)->get();
        return view('profile.address', compact('title', 'addresses'));
    }

    public function history()
    {
        $title = "Lịch sử";
        $userId = Auth::user()->id;
        $status = request()->query('status');

        $query = Orders::where('user_id', $userId)
            ->with(['orderItems.product', 'orderItems.variant', 'user', 'address'])
            ->orderBy('created_at', 'asc');

        if (!empty($status)) {
            $query->where('status', $status);
        }
        $orders = $query->paginate(5);

        return view('profile.history', compact('title', 'orders', 'status'));
    }

    public function checkout()
    {
        $title = "Thanh toán";

        $user_id = Auth::user()->id ?? null;

        $carts = Carts::with(['product.mainImage', 'variant'])->where('user_id', $user_id)->get();

        $addresses = Address::where('user_id', Auth::user()->id)->get();
        return view('checkout', compact('title', 'addresses', 'carts'));
    }
}
