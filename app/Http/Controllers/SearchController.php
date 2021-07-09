<?php

namespace App\Http\Controllers;

use App\Model\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function post()
    {
        $key = request('q');

        $posts = Post::with('author', 'category', 'tags')->where("title", "like", "%$key%")->latest()->paginate(6);
        return view('posts.index', ['posts' => $posts]);
    }
}
