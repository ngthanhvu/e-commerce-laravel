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
            @foreach ($posts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark">
                    <div class="col-md-4">
                        <div class="card border-0">
                            <img src="{{ $post->image }}" class="card-img-top blog-img" alt="Blog Image" width="400"
                                height="300" style="object-fit: cover;">
                            <div class="mt-2">
                                <h5>{{ $post->title }}</h5>
                                <p>{{ $post->description ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
