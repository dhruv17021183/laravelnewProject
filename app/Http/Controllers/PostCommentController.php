<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreComment;
use App\Jobs\NotifyusersPostWasCommented;
use App\Jobs\ThrottledMail;
use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
// use App\Mail\CommentPosted;
use App\Events\Commentposted;
use App\Mail\CommentPostedmarkdown;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']); //Users Need To Authenticated Before They Send Anythings to That Action 
    }
    public function store(BlogPost $post,StoreComment $request)
    {
        
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);
      
        Mail::to($post->user->email)->queue(
            new CommentPostedmarkdown($comment)
        );

        event(new Commentposted($comment));
        // ThrottledMail::dispatch(new CommentPostedmarkdown($comment),$post->user);

        $request->session()->flash('status','Comment Was Created');

        return redirect()->back();
        
    }
}
