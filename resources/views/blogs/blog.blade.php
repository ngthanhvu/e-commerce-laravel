@extends('layouts.main')
@section('content')
    <style>
        .blog-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">TIn tức mới</h1>
            </div>
            @php
                $posts = [
                    ['title' => 'Bài viết 1', 'description' => 'Mô tả bài viết 1'],
                    ['title' => 'Bài viết 2', 'description' => 'Mô tả bài viết 2'],
                    ['title' => 'Bài viết 3', 'description' => 'Mô tả bài viết 3'],
                ];
            @endphp
            @foreach ($posts as $post)
                <div class="col-md-4">
                    <div class="card border-0">
                        <img src="https://placehold.co/400x300" class="card-img-top blog-img" alt="Blog Image">
                        <div class="mt-2">
                            <h5>xin chào đây là bài viết để test xme được bao nhiêu ký tự haha</h5>
                            <p>description</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
