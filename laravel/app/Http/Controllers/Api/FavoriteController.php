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
    public function index($placeId)
    {
        // Obtener los favoritos asociados al lugar
        $favorites = Favorite::where('place_id', $placeId)->get();

        // Retornar los favoritos como respuesta JSON
        return response()->json($favorites);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $placeId)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        $request->merge(['place_id' => $placeId]);

        // No se necesita el método create() ya que no hay columna 'id'
        $favorite = Favorite::firstOrCreate([
            'user_id' => $request->user_id,
            'place_id' => $placeId,
        ]);

        return response()->json($favorite, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($placeId, $favorite)
    {
        // En lugar de findOrFail(), buscaremos por las columnas 'user_id' y 'place_id'
        $favorite = Favorite::where('user_id', $favorite)->where('place_id', $placeId)->firstOrFail();

        return response()->json($favorite);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $placeId, $userId)
    {
        // Buscar el favorito por el ID del lugar y el ID del usuario
        $favorite = Favorite::where('place_id', $placeId)
                            ->where('user_id', $userId)
                            ->firstOrFail();

        // Actualizar el favorito con los datos proporcionados en la solicitud
        $favorite->update($request->all());

        return response()->json($favorite, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($placeId, $favorite)
    {
        // En lugar de findOrFail(), eliminaremos por las columnas 'user_id' y 'place_id'
        $deleted = Favorite::where('user_id', $favorite)->where('place_id', $placeId)->delete();

        if ($deleted) {
            return response()->json(null, 204);
        } else {
            return response()->json(['error' => 'No se pudo encontrar el favorito para eliminar'], 404);
        }
    }

    public function update_workaround(Request $request, $id)
   {
       return $this->update($request, $id);
   }

}
