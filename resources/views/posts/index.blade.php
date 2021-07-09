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
            </div>

            <div>
                @if (Auth::check())
                    <a href="/posts/create" class="btn btn-primary">New Post</a>
                @else
                    <a href="#" class="btn btn-primary">Login for create post</a>
                @endif
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-7">
                @if ($posts->count())
                    @foreach ($posts as $post)
                        <div class="card mb-4">

                            @if (isset($post->thumbnail))
                                <a href="/post/{{ $post->slug }}">
                                    <img style="height: 400px; object-fit: cover; object-position: center;"
                                        class="card-img-top" src="{{ asset('/storage/' . $post->thumbnail) }}">
                                </a>
                            @endif
                            <div class="card-body">
                                <div>
                                    <a href="/categories/{{ $post->category->slug }}"
                                        class="text-secondary"><small>{{ $post->category->name }}</small></a> &middot;

                                    @foreach ($post->tags as $tag)
                                        <a href="/tags/{{ $tag->slug }}"
                                            class="text-secondary"><small>{{ $tag->name }}</small></a>

                                    @endforeach
                                </div>
                                <h5>
                                    <a href="/post/{{ $post->slug }}" class="card-title text-dark">
                                        {{ $post->title }}
                                    </a>
                                </h5>
                                <div class="text-secondary my-3">
                                    {{ Str::limit($post->body, 130, '.') }}
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="media align-items-center">
                                        <img width="40" class="rounded-circle mr-3" src="{{ $post->author->gravatar() }}"
                                            alt="">
                                        <div class="media-body">
                                            <div>
                                                {{ $post->author->name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-secondary ">
                                        <small>Published on {{ $post->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>

                                {{-- <a href="/post/{{ $post->slug }}">Read more</a> --}}
                            </div>
                            <div class="">
                                {{-- Published on {{ $post->created_at->format('d F, Y') }} --}}

                                {{-- @auth --}}

                                {{-- @endauth --}}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info">
                        There are no post.
                    </div>
                @endif
            </div>
        </div>

        {{ $posts->links() }}
        {{-- <div class="d-flex justify-content-center">
            {{ $posts->links() }}
        </div> --}}
    </div>
@endsection
