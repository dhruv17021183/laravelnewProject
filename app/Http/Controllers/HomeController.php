<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     // $this->middleware('guest', ['except' => ['logout', 'getLogout']]);
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        // dd(Auth::id());
        return view('home');
    }
    

    public function contact()
    {
        return view('contact');
    }
    public function secret()
    {
        return view('secret');
    }
}
