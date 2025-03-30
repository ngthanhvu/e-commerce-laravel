<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Address;
use App\Models\User;
use App\Models\Carts;

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

        return view('index', compact('products', 'categories', 'title'));
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

        $products = $query->get();

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
        return view('profile.history', compact('title'));
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
