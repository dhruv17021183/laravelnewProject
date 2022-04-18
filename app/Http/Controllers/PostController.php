<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\Gate;
use App\Models\BlogPost;
use App\Models\User;
use App\Models\Comment;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

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

        $mostCommented = Cache::remember('mostCommented',now()->addSecond(10),function(){
            return BlogPost::mostCommented()->take(5)->get();
        });
        $mostActive = Cache::remember('mostActive',now()->addSecond(10),function(){
            return BlogPost::mostCommented()->take(5)->get();
        });
        $mostActiveLastMonth = Cache::remember('mostActiveLastMonth',now()->addSecond(10),function(){
            return BlogPost::mostCommented()->take(5)->get();
        });

        return view(
            'posts.index',
            [
                'posts'=>BlogPost::latest()->withCount('comments')->with('user')->with('tags')->get(),
                'mostCommented' => $mostCommented,
                'mostActive' =>$mostActive,
                'mostActiveLastMonth' => $mostActiveLastMonth,
                
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

        // $hasFile = $request->hasFile('thumbnail');
        /* File Storage in Storage Directory
        dump($hasFile);
        
        if($hasFile)
        {
           
            $file = $request->file('thumbnail');
            dump($file);
            dump($file->getClientMimeType());
            dump($file->getClientOriginalExtension());

            dump($file->store('thumbails')); 
            dump(Storage::disk('public')->putFile('thumbails',$file));

            $name1 = $file->storeAs('thumbails',$post->id .'.' . $file->guessExtension());
            $name2 = Storage::disk('local')->putFileAs('thumbails',$file,$post->id . '.' . $file->guessExtension());

            dump(Storage::url($name1));
            dump(Storage::disk('local')->url($name2));
        }
        die;
        */
        if($request->hasFile('thumbnail')){
            $path = $request->file('thumbnail')->store('thumbails');
           
            $post->image()->save(
                Image::make(['path' => $path])
            );
        }
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
        $blogPost = Cache::remember("blog-post-{$id}",60,function() use($id){
            return BlogPost::with('comments')->with('tags')->findOrFail($id);
        });

        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";   //read and start the counter 
        $userKey = "blog-post-{$id}-users";        //fetch and store information about the user that visited the page

        $users = Cache::get($userKey,[]);          //key would be sessionId of user and value would bo lastvisited time
        $usersUpdate = [];                         //
        $difference = 0;  //
        $now = now();

        foreach($users as $session => $lastVisit)
        {
            if($now->diffInMinutes($lastVisit)>=1)
            {
                $difference--;
            }
            else
            {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(!array_key_exists($sessionId,$users) || $now->diffInMinutes($users[$sessionId])>=1)
        {
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;
        
        Cache::forever($userKey,$usersUpdate);

        if(!Cache::has($counterKey))
        {
            Cache::forever($counterKey,1);
        }
        else{
            Cache::increment($counterKey,$difference);
        }

        $counter = Cache::get($counterKey);

        return view('posts.show',[
            'post'=>$blogPost,
            'counter' => $counter,
        
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
        // dd('you are updated');

        $post = BlogPost::findOrFail($id);

        // if(Gate::denies('update-post',$post))
        // {
        //     abort(403,"You Can't Edit This Blog Post!");
        // }
        $this->authorize('update',$post);
        $validated=$request->validated();
        $post->fill($validated);
        
        
        if($request->hasFile('thumbnail'))
        {
            $path = $request->file('thumbnail')->store('thumbnails');

            if($post->image)
            {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            }
            else
            {
                $post->image()->save(
                    Image::make(['path' => $path])
                );
            }
        }
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
