<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Quản lý danh mục';
        $search = request()->input('search');
        $perPage = request()->input('per_page', 10);

        $query = Category::query()->whereNull('parent_id');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->with('allChildren')->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);

        return view('admin.categories.index', compact('title', 'categories', 'search', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tạo danh mục';
        $categories = Category::whereNull('parent_id')->with('allChildren')->get();
        return view('admin.categories.create', compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id', // Kiểm tra parent_id hợp lệ
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục',
            'name.max' => 'Tên danh mục không quá 255 kí tự',
            'description.required' => 'Vui lòng nhập mô tả',
            'image.required' => 'Vui lòng chọn ảnh',
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $imagePath = $request->file('image')->store('categories', 'public');

        $category = Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $imagePath,
            'parent_id' => $request->parent_id ?: null, // Nếu không chọn parent_id thì để null
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $title = "Chỉnh sửa danh mục: {$category->name}";
        $categories = Category::whereNull('parent_id')->with('allChildren')->get();
        return view('admin.categories.edit', compact('title', 'category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục',
            'name.max' => 'Tên danh mục không quá 255 kí tự',
            'description.required' => 'Vui lòng nhập mô tả',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($category->image);
            $imagePath = $request->file('image')->store('categories', 'public');
        } else {
            $imagePath = $category->image;
        }

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'parent_id' => $request->parent_id ?: null,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được cập nhật!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Storage::disk('public')->delete($category->image);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được xoá!');
    }
}
