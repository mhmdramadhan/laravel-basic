@extends('layouts.app')

@section('title', 'Post')
@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>
        <div class="text-secondary">
            <a href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a>
            &middot; {{ $post->created_at->format('d F, Y') }}
            &middot;
            @foreach ($post->tags as $tag)
                <a href="/tags/{{ $tag->slug }}">{{ $tag->name }}</a>
            @endforeach
        </div>
        <hr>
        <p>{{ $post->body }}</p>
        <div>
            <div class="text-secondary">
                Wrote by &middot; {{ $post->author->name }}
            </div>
            @if (isset(auth()->user()->id))
                @if (auth()->user()->id == $post->user_id)
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-link text-danger btn-sm p-0" data-toggle="modal"
                        data-target="#exampleModal">
                        Delete
                    </button>

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
                                            <button type="button" class="btn btn-success" data-dismiss="modal">Norp</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

        </div>
    </div>
@endsection
