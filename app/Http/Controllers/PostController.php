<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Post;
use App\Model\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // public function __construct()
    // {
    //     // proteksi route
    //     $this->middleware('auth')->except([
    //         'index', 'show'
    //     ]);
    // }

    public function index()
    {
        // return Post::get(['title', 'slug']);
        // $posts =  Post::get();
        $posts =  Post::latest()->paginate(6);
        return view('posts.index', ['posts' => $posts]);
    }

    public function show(Post $post)
    {
        // $post = Post::where('slug', $slug)->first();
        // if (!$post) {
        //     abort(404);
        // }
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create', [
            'post' => new Post(),
            'categories' => Category::get(),
            'tags' => Tag::get(),
        ]);
    }

    public function Store(Request $request)
    {
        // validate data
        $this->validateRequest();

        // Post::create([
        //     'title' => $request->title,
        //     'slug' => \Str::slug($request->title),
        //     'body' => $request->body,
        // ]);

        // insert image
        $slug = \Str::slug($request->title);

        if(request()->file('thumbnail')){
            $thumbnail = request()->file('thumbnail');
            // $thumbnailUrl = $thumbnail->storeAs("images/posts", "{$slug}.{$thumbnail->extension()}");
            $thumbnailUrl = $thumbnail->store("images/posts");
        }else{
            $thumbnailUrl = null;
        }



        // insert data
        $attr = $request->all();
        $attr['slug'] = $slug;
        $attr['category_id'] = $request->category;
        $attr['user_id'] = auth()->id();
        $attr['thumbnail'] = $thumbnailUrl;

        // input relasi
        $post = auth()->user()->posts()->create($attr);
        // dd($post);

        // $post = Post::create($attr);
        // memasukan data multiple
        $post->tags()->attach(request('tags'));

        // create session
        session()->flash('success', 'The post was created!.');

        // return back();
        return redirect('posts');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::get(),
            'tags' => Tag::get(),
        ]);
    }

    public function update(Post $post)
    {
        // validation
        $this->validateRequest();

        // update image
        if (request()->file('thumbnail')) {
            // hapus file lama
            \Storage::delete($post->thumbnail);

            $thumbnail = request()->file('thumbnail');
            // $thumbnailUrl = $thumbnail->storeAs("images/posts", "{$slug}.{$thumbnail->extension()}");
            $thumbnailUrl = $thumbnail->store("images/posts");
        }else{
            $thumbnailUrl = $post->thumbnail;
        }


        // updated data
        $attr = request()->all();
        $attr['category_id'] = request('category');
        $attr['thumbnail'] = $thumbnailUrl;
        $post->update($attr);

        $post->tags()->sync(request('tags'));

        // set session
        session()->flash('success', 'The post was updated!.');

        // return back();
        return redirect('posts');
    }

    public function validateRequest()
    {
        return request()->validate([
            'thumbnail' => 'mimes:jpeg,png,jpg,svg|max:2048',
            'title' => 'required|min:3|unique:posts,slug',
            'body' => 'required',
            'category' => 'required',
            'tags' => 'array|required',
        ]);
    }

    public function destroy(Post $post)
    {
        // untuk menghapus di table tags karna tags merupakan parent dari post
        if (auth()->user()->id == $post->user_id) {
            \Storage::delete($post->thumbnail);
            // menghapus data join
            $post->tags()->detach();
            // menghapus semua data post
            $post->delete();
            session()->flash("success", "The post was destroyed");
            return redirect('posts');
        }
    }
}
