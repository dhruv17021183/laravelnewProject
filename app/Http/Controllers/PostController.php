<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\Gate;
use App\Models\BlogPost;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    // private    $posts=[
    //     1=>[
    //         'title'=>'Intro to laravel',
    //         'content'=>'this is a short intro',
    //         'is_new'=>true
    //     ],
    //     2=>[
    //         'title'=>'Intro to php',
    //         'content'=>'this is a short intro to php',
    //         'is_new'=>false
    //      ]
    //     ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['create','store','edit','update','destroy']);
    }
    public function index()
    {
        // DB::connection()->enableQueryLog();
        // $posts = BlogPost::all();

        // foreach($posts as $post)
        // {
        //     foreach($post->comments as $comment)
        //     {
        //         echo $comment->content;
        //     }
        // }
        // dd(DB::getQueryLog());
        // $user=Blogpost::all();
        // $bp = Blogpost::with('comments')->find(1);
        // $newComment = new Comment(['content'=>'New Comment Test']);
        // dd($newComment->toArray());
        return view(
            'posts.index',
            [
                'posts'=>BlogPost::latest()->withCount('comments')->with('user')->get(),
                'mostCommented' => BlogPost::mostCommented()->take(5)->get(),
                'mostActive' =>User::withMostBlogPosts()->take(5)->get(),
                'mostActiveLastMonth' => User::withMostBlogPostslastmonth()->take(5),
        ]
      );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $post=BlogPost::create($validated);
        $post->save();

        
        $request->session()->flash('status','created!');
        return redirect()->route('posts.show',['post'=>$post->id]);
    }

    /**
     * Display the specified resource. 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return view('posts.show',[
        //     'post'=>BlogPost::with(['comments' => function($query){
        //         return $query->latest();
        //     }])->findOrFail($id)
        // ]);
        return view('posts.show',[
            'post'=>BlogPost::with('comments')->findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $this->authorize('update',$post);
        return view('posts.edit',['post'=>BlogPost::findOrFail($id)]);
    }

    /**                
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        // if(Gate::denies('update-post',$post))
        // {
        //     abort(403,"You Can't Edit This Blog Post!");
        // }
        $this->authorize('update',$post);
        $validated=$request->validated();
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status','updated');

        return redirect()->route('posts.show',['post'=>$post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $post = BlogPost::findOrFail($id);
        // if(Gate::denies('delete-post',$post))
        // {
        //     abort(403,"You Can't Delete This Blog Post!");
        // }
        $this->authorize('delete',$post);
        $post->delete();

        session()->flash('status','Blog Post Was Deleted!');

        return redirect()->route('posts.index');
    }
    public function home()
    {
        // return view('posts.edit',['post'=>BlogPost::findOrFail($id)]);
        return view('home');
    }
}
