<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use App\Models\Variant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Products';
        $products = Product::with(['category', 'mainImage', 'variants', 'images'])->get();
        return view('admin.products.index', compact('title', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tạo sản phẩm';
        $categories = Category::all();
        return view('admin.products.create', compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'slug' => 'required|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'main_image' => 'required|image',
            'sub_images.*' => 'image',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
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

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
