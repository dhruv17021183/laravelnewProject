<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('posts',[PostsController::class,'index']);
// Route::get('posts/{id}',function($id){
//     return 'Blog post'.$id;
// });
// Route::resource('posts',PostsController::class)
    //   ->only(['index','show','create','store']);
// Route::get('/recent-posts/{days_ago?}',function($daysAgo=20){
//     return 'Posts from '. $daysAgo . ' days ago';
// })->name('posts.recent.index')->middleware('auth');
// Route::view('/contact','contact')
//     ->name('home.contact');
    // $posts=[
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

// Route::get('/posts/{id}',function($id) use ($posts){
    
//     abort_if(!isset($posts[$id]),404);

//     return view('posts.show',['post'=>$posts[$id]]);
// })->name('posts.show');

// Route::get('/posts',function() use ($posts){
//     // dd(request()->all());
//     dd((int)request()->query('page',1));
//     return view('posts.index',['posts'=>$posts]);
// });
// Route::prefix('/fun')->name('fun.')->group(function() use($posts){
//     Route::get('response',function() use($posts){
//         return response($posts,201)->header('content-type','application/json')->cookie('MY_COOKIE','Dhruv',3600);
//     });

// Route::get('response',function() use($posts){
//     return response($posts,201)->header('content-type','application/json')->cookie('MY_COOKIE','Dhruv',3600);
// });
// Route::get('redirect',function(){
//     return redirect('/contact');
// });
// Route::get('back',function(){
//     return back();
// });
// Route::get('named-route',function(){
//     return redirect()->route('posts.show',['id'=>1]);
// });
// Route::get('away',function(){
//     return redirect()->away('https://google.com');
// });
// Route::get('json',function() use($posts){
//     return response()->json($posts);
// });
// Route::get('download',function() use($posts){
//     return response()->download(public_path('/Demo.jpg'),'wallpaper.jpg');
//   });
// });




// Auth::routes();

Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::get('/secret',[HomeController::class,'secret'])->name('secret')->middleware('can:home.secret');
// Route::get('/home', 'HomeController@home')->name('home')->middleware('auth');
// Route::get('/contact', 'HomeController@contact')->name('contact');
Route::resource('/posts', PostController::class);
// Route::resource('posts',PostController::class)->only(['index','show','create','store','edit','update','destroy']);
// Route::get('/login', [HomeController::class,'home']);
// Route::get('auth/logout', 'Auth\AuthController@getLogout');
Auth::routes();
Route::get('/',function() {
    return view('welcome',['name' => '<b>Dhruv<b>']);
});