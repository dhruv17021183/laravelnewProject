<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Http\Requests\StoreComment;
use App\Models\User;

class UserCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']); //Users Need To Authenticated Before They Send Anythings to That Action 
    }
    public function store(User $user,StoreComment $request)
    {
        
        $user->commentsOn()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        // $request->session()->flash('status','Comment Was Created');

        return redirect()->back()
        ->withStatus('Comment Was Created');
        

    }
}
