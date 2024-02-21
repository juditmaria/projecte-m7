<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Log;
use App\Models\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar datos del formulario
        $validatedData = $request->validate([
            'body'      => 'required',
            'upload'    => 'required|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            'latitude'  => 'required',
            'longitude' => 'required',
        ]);
        
        // Obtener datos del formulario
        $body       = $request->input('body');
        $upload     = $request->file('upload');
        $latitude   = $request->input('latitude');
        $longitude  = $request->input('longitude');

        // Verificar si el usuario está autenticado
        $authorId = auth()->id();

        if (!$authorId) {
            // Devolver respuesta JSON con mensaje de error si el usuario no está autenticado
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Guardar archivo en el disco
        $file = new File();
        $fileOk = $file->diskSave($upload);

        if ($fileOk) {
            // Guardar datos en la BD
            Log::debug("Saving post at DB...");
            $post = new Post([
                'body'      => $body,
                'latitude'  => $latitude,
                'longitude' => $longitude,
                'author_id' => $authorId, // Usar el ID del usuario autenticado
                'file_id'   => $file->id, // Asociar el archivo al post
            ]);
            $post->save(); // Guardar la publicación en la base de datos

            Log::debug("DB storage OK");
            // Devolver respuesta JSON con los datos del nuevo post y el código de estado 201 (Created)
            return response()->json($post, 201);
        } else {
            // Devolver respuesta JSON con mensaje de error si falla la carga del archivo
            return response()->json(['error' => 'Error uploading file'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'body'      => 'required',
            'latitude'  => 'required',
            'longitude' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->update($validatedData);
        return response()->json($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(null, 204);
    }

    /*
     //Add like
     
    public function like(string $id) 
    {
        $post = Post::findOrFail($id);
        $like = Like::create([
            'user_id'  => auth()->user()->id,
            'post_id' => $post->id
        ]);
        return response()->json($like, 201);
    }

    
    //Undo like
     
    public function unlike(string $id) 
    {
        $post = Post::findOrFail($id);
        $like = Like::where([
            ['user_id', '=', auth()->user()->id],
            ['post_id', '=', $post->id],
        ])->firstOrFail();
        $like->delete();
        return response()->json(null, 204);
    } */

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
}
