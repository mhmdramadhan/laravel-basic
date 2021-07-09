@extends('layouts.app')

@section('title', 'Post')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @if (isset($post->thumbnail))
                    <img style="height: 550px; object-fit: cover; object-position: center;" class="rounded w-100"
                        src="{{ asset('/storage/' . $post->thumbnail) }}">
                @endif
                <h1>{{ $post->title }}</h1>
                <div class="text-secondary mb-3">
                    <a href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a>
                    &middot; {{ $post->created_at->format('d F, Y') }}
                    &middot;
                    @foreach ($post->tags as $tag)
                        <a href="/tags/{{ $tag->slug }}">{{ $tag->name }}</a>
                    @endforeach
                    <div class="media my-3">
                        <img width="60" class="rounded-circle mr-3" src="{{ $post->author->gravatar() }}" alt="">
                        <div class="media-body">
                            <div>
                                {{ $post->author->name }}
                            </div>
                            {{ '@' . $post->author->username }}
                        </div>
                    </div>
                </div>
                {{-- new line 2to break --}}
                <p>{!! nl2br($post->body) !!}</p>
                @if (isset(auth()->user()->id))
                    @if (auth()->user()->id == $post->user_id)
                        <!-- Button trigger modal -->
                        <div class="flex">
                            <button type="button" class="btn btn-link text-danger btn-sm p-0" data-toggle="modal"
                                data-target="#exampleModal">
                                Delete
                            </button>
                            <a href="/posts/{{ $post->slug }}/edit" class="btn btn-link text-success btn-sm">Edit</a>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Are you sure for delete?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <div>{{ $post->title }}</div>
                                            <div class="text-secondary">
                                                <small>
                                                    Published:
                                                    {{ $post->created_at->format('d, F Y') }}
                                                </small>
                                            </div>
                                        </div>
                                        <form action="/posts/{{ $post->slug }}/delete" method="post">
                                            @csrf
                                            @method('delete')
                                            <div class="d-flex">
                                                <button type="submit" class="btn btn-danger mr-2">Yarp</button>
                                                <button type="button" class="btn btn-success"
                                                    data-dismiss="modal">Norp</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            <div class="col-md-4">
                @foreach ($posts as $post)
                    <div class="card mb-4">
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
            </div>
        </div>
    </div>

@endsection
