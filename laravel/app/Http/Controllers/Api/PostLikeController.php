<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $postId
     * @return \Illuminate\Http\Response
     */
    public function index($postId)
    {
        // Obtener todos los likes del post dado
        $likes = Like::where('post_id', $postId)->get();

        // Devolver respuesta JSON con los likes obtenidos
        return response()->json($likes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $postId
     * @return \Illuminate\Http\Response
     */
    public function store($postId)
    {
        // Crear un nuevo like asociado al post dado
        $like = Like::create([
            'user_id' => auth()->id(),
            'post_id' => $postId
        ]);

        // Devolver respuesta JSON con el like creado y el código de estado 201 (creado)
        return response()->json($like, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $postId
     * @param  int  $likeId
     * @return \Illuminate\Http\Response
     */
    public function show($postId, $likeId)
    {
        // Buscar el like por su ID y el ID del post asociado
        $like = Like::where('id', $likeId)->where('post_id', $postId)->firstOrFail();

        // Devolver respuesta JSON con el like encontrado
        return response()->json($like);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $postId
     * @param  int  $likeId
     * @return \Illuminate\Http\Response
     */
    public function update($postId)
    {
        // Buscar el like por el ID del post
        $like = Like::where('post_id', $postId)->first();
    
        // Verificar si el like existe
        if (!$like) {
            return response()->json(['error' => 'El like especificado no fue encontrado.'], 404);
        }
    
        // No hay lógica de actualización para los likes, así que simplemente devolvemos el like existente
        return response()->json($like, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $postId
     * @param  int  $likeId
     * @return \Illuminate\Http\Response
     */
    public function destroy($postId, $likeId)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Buscar el like dado por su ID y el ID del post asociado
        $like = Like::where('post_id', $postId)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        // Eliminar el like
        $like->delete();

        // Devolver respuesta JSON con el código de estado 204 (ningún contenido)
        return response()->json(null, 204);
    }

    /* public function update_workaround(Request $request, $postId, $likeId)
    {
        return $this->update($postId, $likeId);
    } */
    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }

}
