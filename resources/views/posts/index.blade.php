@extends('layouts.app')

@section('title', 'Post')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <div>
                @if (isset($category))
                    <h4>Category : {{ $category->name }}</h4>
                @endif
                @if (isset($tag))
                    <h4>Tag : {{ $tag->name }}</h4>
                @endif
                @if (!isset($tag) && !isset($category))
                    <h4>All Post</h4>
                @endif
                <hr>
            </div>
            <div>
                @if (Auth::check())
                    <a href="/posts/create" class="btn btn-primary">New Post</a>
                @else
                    <a href="#" class="btn btn-primary">Login for create post</a>
                @endif
            </div>
        </div>

        <div class="row">
            @if ($posts->count())
                @foreach ($posts as $post)
                    <div class="col-md-4">
                        <div class="card mb-4">

                            @if (isset($post->thumbnail))
                                <img style="height: 270px; object-fit: cover; object-position: center;" class="card-img-top"
                                    src="{{ asset('/storage/' . $post->thumbnail) }}">
                            @endif
                            <div class="card-body">
                                <div class="card-title">
                                    {{ $post->title }}
                                </div>
                                <div>
                                    {{ Str::limit($post->body, 100, '.') }}
                                </div>
                                <a href="/post/{{ $post->slug }}">Read more</a>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                {{-- Published on {{ $post->created_at->format('d F, Y') }} --}}
                                Published on {{ $post->created_at->diffForHumans() }}
                                {{-- @auth --}}
                                @if (isset(auth()->user()->id))
                                    @if (auth()->user()->id == $post->user_id)
                                        <a href="/posts/{{ $post->slug }}/edit" class="btn btn-success">Edit</a>
                                    @endif
                                @endif
                                {{-- @endauth --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-info">
                    There are no post.
                </div>
            @endif

        </div>
        <div class="d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
