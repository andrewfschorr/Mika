<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = [];
        var_dump($posts, true);
        // error_log('HELLO');
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        //dd(request()->all());
        // $post = new \App\Post;
        // $post->title = request('title');
        // $post->body = request('body');
        // $post->save();
        Post::create([
            'title' => request('title'),
            'body' => request('body'),
        ]);
        return redirect('/');
    }
}
