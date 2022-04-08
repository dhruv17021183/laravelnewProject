<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class PostTagController extends Controller
{
    public function index($tag)
    {
        $tagg = Tag::findOrFail($tag);
        
        return view('posts.index', [
            'posts' => $tagg->blogPosts,    //read all the tags from the blogpost but also we can read all the blogpost from the tag
            'mostCommented' => [],
            'mostActive' => [],
            
        ]);
    }
}
