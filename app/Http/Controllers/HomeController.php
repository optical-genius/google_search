<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $images = Image::orderBy('id', 'desc')->where('user_id',$id)->take(10)->get();
        $user_request = Image::get()->where('user_id',$id)->last();
        return view('search', compact('images', 'user_request'));
    }
}
