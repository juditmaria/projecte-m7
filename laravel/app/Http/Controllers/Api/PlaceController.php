<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Place::paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'file_id' => 'required',
            'author_id'=> 'required',
            // Add other required fields here
        ]);

        return Place::create($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Place $place)
    {
        return $place;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Place $place)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            // Add other required fields here
        ]);

        $place->update($validatedData);

        return $place->fresh();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {
        $place->delete();

        return response()->json(['message' => 'Place deleted successfully']);
    }

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
}
