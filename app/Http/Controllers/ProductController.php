<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use App\Models\Variant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Products';
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $query = Product::with(['category', 'mainImage', 'variants', 'images']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $products = $query->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);

        return view('admin.products.index', compact('title', 'products', 'search', 'perPage'));
    }

    public function create()
    {
        $title = 'Tạo sản phẩm';
        $categories = Category::all();
        return view('admin.products.create', compact('title', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'main_image' => 'required|image',
            'sub_images.*' => 'image',
            'description' => 'required|string',
        ], [
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'price.required' => 'Vui lòng nhập giá sản phẩm',
            'price.numeric' => 'Giá sản phẩm phải là số',
            'quantity.required' => 'Vui lòng nhập số lượng sản phẩm',
            'quantity.integer' => 'Số lượng sản phẩm phải là số nguyên',
            'category_id.required' => 'Vui lòng chọn danh mục',
            'category_id.exists' => 'Danh mục không tồn tại',
            'main_image.required' => 'Vui lòng chọn hình ảnh chính',
            'main_image.image' => 'Hình ảnh chính phải là hình ảnh',
            'description.required' => 'Vui lòng nhập mô tả sản phẩm',
        ]);

        $slug = Str::slug($request->name);

        $count = 1;
        $originalSlug = $slug;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);

        $mainImagePath = $request->file('main_image')->store('products', 'public');
        Image::create([
            'sub_image' => $mainImagePath,
            'is_main' => true,
            'products_id' => $product->id,
        ]);

        if ($request->hasFile('sub_images')) {
            foreach ($request->file('sub_images') as $subImage) {
                $subImagePath = $subImage->store('products', 'public');
                Image::create([
                    'sub_image' => $subImagePath,
                    'is_main' => false,
                    'products_id' => $product->id,
                ]);
            }
        }

        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                if (!empty($variant['name']) && !empty($variant['price'])) {
                    Variant::create([
                        'varriant_name' => $variant['name'],
                        'varriant_price' => $variant['price'],
                        'varriant_quantity' => $variant['quantity'] ?? 0,
                        'sku' => $variant['sku'] ?? '',
                        'products_id' => $product->id,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'mainImage', 'variants', 'images', 'ratings.user', 'ratings.likes'])->where('slug', $slug)->first();
        $ratings = $product->ratings()->with('user', 'likes')->paginate(3);
        if (!$product) {
            abort(404);
        }
        $title = 'Chi tiết sản phẩm';

        return view('detail', compact('title', 'product', 'ratings'));
    }

    public function edit(Product $product)
    {
        $title = 'Chỉnh sửa sản phẩm';
        $categories = Category::all();
        return view('admin.products.edit', compact('title', 'product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'main_image' => 'nullable|image',
            'sub_images.*' => 'nullable|image',
            'description' => 'required|string',
        ], [
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'price.required' => 'Vui lòng nhập giá sản phẩm',
            'price.numeric' => 'Giá sản phẩm phải là số',
            'quantity.required' => 'Vui lòng nhập số lượng sản phẩm',
            'quantity.integer' => 'Số lượng sản phẩm phải là số nguyên',
            'category_id.required' => 'Vui lòng chọn danh mục',
            'category_id.exists' => 'Danh mục không tồn tại',
            'main_image.image' => 'Hình ảnh chính phải là hình ảnh',
            'sub_images.image' => 'Hình ảnh phụ phải là hình ảnh',
            'description.required' => 'Vui lòng nhập mô tả sản phẩm',
        ]);

        $slug = Str::slug($request->name);
        $count = 1;
        $originalSlug = $slug;
        while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);

        if ($request->hasFile('main_image')) {
            if ($product->mainImage) {
                Storage::delete('public/' . $product->mainImage->sub_image);
                $product->mainImage->delete();
            }
            $mainImagePath = $request->file('main_image')->store('products', 'public');
            Image::create([
                'sub_image' => $mainImagePath,
                'is_main' => true,
                'products_id' => $product->id,
            ]);
        }

        if ($request->hasFile('sub_images')) {
            foreach ($product->images()->where('is_main', false)->get() as $image) {
                Storage::delete('public/' . $image->sub_image);
                $image->delete();
            }
            foreach ($request->file('sub_images') as $subImage) {
                $subImagePath = $subImage->store('products', 'public');
                Image::create([
                    'sub_image' => $subImagePath,
                    'is_main' => false,
                    'products_id' => $product->id,
                ]);
            }
        }

        if ($request->has('variants')) {
            $product->variants()->delete();
            foreach ($request->variants as $variant) {
                if (!empty($variant['name']) && !empty($variant['price'])) {
                    Variant::create([
                        'varriant_name' => $variant['name'],
                        'varriant_price' => $variant['price'],
                        'varriant_quantity' => $variant['quantity'] ?? 0,
                        'sku' => $variant['sku'] ?? '',
                        'products_id' => $product->id,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa thành công!');
    }
}
