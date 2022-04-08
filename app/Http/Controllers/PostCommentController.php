<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreComment;
use App\Models\BlogPost;
use App\Models\Comment;


class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']); //Users Need To Authenticated Before They Send Anythings to That Action 
    }
    public function store(BlogPost $post,StoreComment $request)
    {
        
        $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        $request->session()->flash('status','Comment Was Created');

        return redirect()->back();

    }
}
