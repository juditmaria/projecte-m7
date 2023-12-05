<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Post;
use App\Models\Place;

class MainPlacesController extends Controller
{
    public function index()
    {
        $places = Place::with(['user', 'file'])->paginate(5);
    
        return view('mainplaces', compact('places'));
    }
    

    
}