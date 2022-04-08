<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;

class PostsController extends Controller
{
    // 
    // function index()
    // {
    //    return view('index',['posts'=>BlogPost::orderBy('created_at','desc')->get()]);
    // }
    // function create()
    // {
    //     return view('create');
    // }
    // function show()
    // {
    //     return view('show',['post'=>BlogPost::findorFail($id)]);
    // }
    function index()
    {
        
        // $comments = Comment::all();
        // $posts = BlogPost::all();
        // dd($comments);

        // dd($posts);
        // foreach ($comments as $comment) {
        //     echo $comment->post->title;
        //     echo "<br>";
        // }
        // $comments = Comment::with('post')->get();

        // foreach($comments as $comment)
        // {
        //     echo $comment->post->title;
        //     echo "<br>";
        // }
        // $user = User::find(1);

        // $user->posts()
        // ->where('active', 1)
        // ->orWhere('votes', '>=', 100)
        // ->get();

    }
}
