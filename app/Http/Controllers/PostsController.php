<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;

class PostsController extends Controller
{
    //
    function index()
    {
       return view('index',['posts'=>BlogPost::orderBy('created_at','desc')->get()]);
    }
    function create()
    {
        return view('create');
    }
    // function show()
    // {
    //     return view('show',['post'=>BlogPost::findorFail($id)]);
    // }
}
