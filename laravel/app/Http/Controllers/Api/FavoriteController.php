<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener los favoritos asociados al usuario
        $favorites = Favorite::where('user_id', $user->id)->get();

        // Retornar los favoritos como respuesta JSON
        return response()->json($favorites);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $placeId)
    {
        $user = $request->user(); // Accede al usuario autenticado a través de la solicitud

        // Verificar si el lugar ya está marcado como favorito por el usuario
        if (Favorite::where('user_id', $user->id)->where('place_id', $placeId)->exists()) {
            return response()->json(['error' => 'El lugar ya está marcado como favorito.'], 422);
        }

        // Crear el favorito
        $favorite = new Favorite();
        $favorite->user_id = $user->id;
        $favorite->place_id = $placeId;
        $favorite->save();

        return response()->json($favorite, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($placeId)
    {
        $user = Auth::user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('place_id', $placeId)
            ->firstOrFail();

        return response()->json($favorite);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $placeId)
    {
        $user = Auth::user();

        // Buscar el favorito a actualizar
        $favorite = Favorite::where('user_id', $user->id)
                            ->where('place_id', $placeId)
                            ->firstOrFail();

        // Validar los datos proporcionados en la solicitud
        $request->validate([
            'place_id' => 'required', // Requerir un nuevo ID del lugar en la solicitud
        ]);

        // Actualizar solo el campo 'place_id' del favorito
        $favorite->update([
            'place_id' => $request->place_id,
        ]);

        return response()->json($favorite);
    }

    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($placeId)
    {
        $user = Auth::user();

        // Buscar y eliminar el favorito
        $favorite = Favorite::where('user_id', $user->id)
            ->where('place_id', $placeId)
            ->firstOrFail();
        $favorite->delete();

        return response()->json(null, 204);
    }

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
 
}
