<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $title = "Quản lý bài viêt";
        $search = request()->input('search');
        $perPage = request()->input('per_page', 10);

        $query = Post::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate($perPage);

        $posts->appends([
            'search' => $search,
            'per_page' => $perPage,
        ]);

        return view('admin.posts.index', compact('title', 'posts', 'search', 'perPage'));
    }

    public function create()
    {
        $title = "Thêm bài viết";
        return view('admin.posts.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'description' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required|in:0,1',
            ],
            [
                'title.required' => 'Vui lòng nhập tiêu đề bài viết',
                'content.required' => 'Vui lòng nhập nội dung bài viết',
                'description.max' => 'Mô tả không được vượt quá 255 ký tự',
                'description.string' => 'Mô tả không hợp lệ',
                'image.image' => 'Vui lòng chọn một ảnh hợp lệ',
                'image.mimes' => 'Chỉ hỗ trợ các định dạng: jpeg, png, jpg, gif',
                'image.max' => 'Kích thước ảnh không được vượt quá 2MB',
                'status.required' => 'Vui lòng chọn trạng thái bài viết',
                'status.in' => 'Trạng thái không hợp lệ',
            ]
        );

        // Tạo slug từ title
        $slug = Str::slug($request->title);

        // Xử lý upload ảnh (nếu có)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/posts'), $imageName);
            $imagePath = 'storage/posts/' . $imageName;
        }

        // Lưu dữ liệu
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => $request->status,
            'slug' => $slug,
            'user_id' => $request->user_id, // hoặc $request->user_id nếu bạn đã gửi từ form
        ]);

        return redirect()->back()->with('success', 'Tạo bài viết thành công');
    }


    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $title = $post->title;
        $description = $post->description;
        return view('blogs.blog_detail', compact('post', 'title', 'description'));
    }

    public function edit(Post $post)
    {
        $title = "Chỉnh sửa bài viết";
        return view('admin.posts.edit', compact('post', 'title'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $slug = Str::slug($request->title);
        $imagePath = $post->image;

        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/posts'), $imageName);
            $imagePath = 'storage/posts/' . $imageName;
        }

        $post->update([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => $request->status,
            'user_id' => $request->user_id ?? $post->user_id,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Cập nhật bài viết thành công');
    }


    public function destroy(Post $post)
    {
        if ($post->image && file_exists(public_path($post->image))) {
            unlink(public_path($post->image));
        }
        $post->delete();
        return redirect()->back()->with('success', 'Xóa bài viết thành công');
    }
}
