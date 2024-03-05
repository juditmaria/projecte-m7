<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\File;

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
            'upload' => 'required|mimes:gif,jpeg,jpg,mp4,png|max:1024',
            'name' => 'required|string',
            'description' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'visibility_id' => 'required',
        ]);
    
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        $name = $request->get('name');
        $description = $request->get('description');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $visibility_id = $request->get('visibility_id'); // Cambio aquí
    
        $uploadName = time() . '_' . $fileName;
        $filePath = $upload->storeAs(
            'uploads',
            $uploadName,
            'public'
        );
    
        if (\Storage::disk('public')->exists($filePath)) {
            \Log::debug("Local storage OK");
            $fullPath = \Storage::disk('public')->path($filePath);
            \Log::debug("File saved at {$fullPath}");
    
            $file = File::create([
                'filepath' => $filePath,
                'filesize' => $fileSize,
            ]);
    
            $place = Place::create([
                'name' => $name,
                'description' => $description,
                'file_id' => $file->id,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'visibility_id' => $visibility_id, // Cambio aquí
                'author_id' => auth()->user()->id,
            ]);
    
            \Log::debug("DB storage OK");
            return response()->json([
                'success' => true,
                'data'    => $place
            ], 201);
        } else {
            \Log::debug("Local storage FAILS");
            return response()->json([
                'success'  => false,
                'message' => 'Error storing place'
            ], 500);
        }
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
    public function update(Request $request, $id)
    {
        $place = Place::find($id);
        if ($place) {
            // Validar archivo
            $validatedData = $request->validate([
                'upload' => 'nullable|mimes:gif,jpeg,jpg,mp4,png|max:1024',
            ]);
    
            $file = File::find($place->file_id);
    
            // Obtener datos del archivo
            $upload = $request->file('upload');
            $controlNull = false;
    
            if (!is_null($upload)) {
                $fileName = $upload->getClientOriginalName();
                $fileSize = $upload->getSize();
                \Log::debug("Storing file '{$fileName}' ($fileSize)...");
    
                // Guardar archivo en el disco
                $uploadName = time() . '_' . $fileName;
                $filePath = $upload->storeAs(
                    'uploads', // Ruta
                    $uploadName, // Nombre del archivo
                    'public' // Disco
                );
            } else {
                $filePath = $file->filepath;
                $fileSize = $file->filesize;
                $controlNull = true;
            }
    
            if (\Storage::disk('public')->exists($filePath)) {
                if ($controlNull == false) {
                    \Storage::disk('public')->delete($file->filepath);
                    \Log::debug("Local storage OK");
                    $fullPath = \Storage::disk('public')->path($filePath);
                    \Log::debug("File saved at {$fullPath}");
                }
    
                // Guardar datos en la base de datos
                $file->filepath = $filePath;
                $file->filesize = $fileSize;
                $file->save();
                \Log::debug("DB storage OK");
    
                $place->name = $request->input('name');
                $place->description = $request->input('description');
                $place->latitude = $request->input('latitude');
                $place->longitude = $request->input('longitude');
                $place->visibility_id = $request->input('visibility_id'); // Cambio visibility_id por visibility
                $place->save();
    
                return response()->json([
                    'success' => true,
                    'data'    => $place
                ], 200);
            } else {
                \Log::debug("Local storage FAILS");
                return response()->json([
                    'success'  => false,
                    'message' => 'Error uploading place'
                ], 500);
            }
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error searching place'
            ], 404);
        }
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
