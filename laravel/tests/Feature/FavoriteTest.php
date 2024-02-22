<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Place;
use App\Models\Favorite;
use Illuminate\Database\QueryException;

class FavoriteTest extends TestCase
{
    //use RefreshDatabase;

    /**
     * Test can create a favorite.
     */
    public function test_can_create_favorite()
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();

        $favoriteData = [
            'user_id' => $user->id,
        ];

        $response = $this->actingAs($user)->postJson("/api/places/{$place->id}/favorites", $favoriteData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('favorites', $favoriteData);
    }

    /**
     * Test can list favorites.
     */
    public function test_can_list_favorites()
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();

        // Crear favoritos asociados al usuario y al lugar
        Favorite::create(['user_id' => $user->id, 'place_id' => $place->id]);

        // Obtener la lista de favoritos del usuario
        $response = $this->actingAs($user)->getJson("/api/places/{$place->id}/favorites");

        // Verificar que la solicitud fue exitosa y que la respuesta tiene la estructura esperada
        $response->assertStatus(200)
                 ->assertJsonStructure(['*' => [
                    'user_id',
                    'place_id',
                 ]]);
    }

    /**
     * Test can show a favorite.
     */
    public function test_can_show_favorite()
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();
        $favorite = Favorite::create(['user_id' => $user->id, 'place_id' => $place->id]);

        $response = $this->actingAs($user)->getJson("/api/places/{$place->id}/favorites/{$favorite->user_id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['user_id' => $user->id])
                 ->assertJsonFragment(['place_id' => $place->id]);
    }


    public function test_can_update_favorite()
        {
            // Crear un usuario y un lugar
            $user = User::factory()->create();
            $place = Place::factory()->create();

            // Crear un favorito para el usuario y el lugar
            $favorite = Favorite::create(['user_id' => $user->id, 'place_id' => $place->id]);

            // Enviar una solicitud PUT para actualizar el favorito
            $response = $this->actingAs($user)->putJson("/api/places/{$place->id}/favorites/{$user->id}", [
                'user_id' => $user->id,
                'place_id' => $place->id,
                // Puedes agregar aquí los campos que deseas actualizar
            ]);

            // Verificar que la solicitud fue exitosa
            $response->assertStatus(200);

            // Verificar que el favorito se actualizó correctamente en la base de datos
            $this->assertDatabaseHas('favorites', [
                'user_id' => $user->id,
                'place_id' => $place->id,
                // Verificar aquí los campos actualizados
            ]);
        }

    /**
     * Test can delete a favorite.
     */
    public function test_can_delete_favorite()
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();
        $favorite = Favorite::create(['user_id' => $user->id, 'place_id' => $place->id]);

        $response = $this->actingAs($user)->deleteJson("/api/places/{$place->id}/favorites/{$favorite->user_id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('favorites', ['user_id' => $user->id, 'place_id' => $place->id]);
    }
}
