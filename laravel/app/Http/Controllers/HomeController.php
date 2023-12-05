<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Post;
use App\Models\Place;

class HomeController extends Controller
{
    public function index()
    {
        $post = Post::with(['user', 'file'])->paginate(5);
    
        return view('home', compact('post'));
    }
    

    
}