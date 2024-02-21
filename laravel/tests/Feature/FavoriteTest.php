<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Place;
use App\Models\Favorite;
use Illuminate\Support\Facades\DB;

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
            'place_id' => $place->id,
        ];

        $response = $this->actingAs($user)->postJson('/api/favorites', $favoriteData);

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
        Favorite::create(['user_id' => $user->id, 'place_id' => $place->id]);
        Favorite::create(['user_id' => $user->id, 'place_id' => $place->id]);
        Favorite::create(['user_id' => $user->id, 'place_id' => $place->id]);

        $response = $this->actingAs($user)->getJson('/api/favorites');

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    /**
     * Test can show a favorite.
     */
    public function test_can_show_favorite()
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();
        $favorite = Favorite::create(['user_id' => $user->id, 'place_id' => $place->id]);

        $response = $this->actingAs($user)->getJson("/api/favorites/{$place->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['user_id' => $user->id])
            ->assertJsonFragment(['place_id' => $place->id]);
    }

    /**
     * Test can update a favorite.
     */
    public function test_can_update_favorite()
    {
        // Crear un usuario y un lugar
        $user = User::factory()->create();
        $place = Place::factory()->create();
    
        // Crear un favorito para el usuario y el lugar
        Favorite::create(['user_id' => $user->id, 'place_id' => $place->id]);
    
        // Crear un nuevo lugar
        $newPlace = Place::factory()->create();
    
        // Enviar una solicitud PUT para actualizar el favorito
        $response = $this->actingAs($user)->putJson("/api/favorites/{$place->id}", [
            'place_id' => $newPlace->id,
        ]);
    
        // Verificar que la solicitud fue exitosa
        $response->assertStatus(200);
    
        // Verificar que el favorito se actualizó correctamente en la base de datos
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'place_id' => $newPlace->id,
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

        $response = $this->actingAs($user)->deleteJson("/api/favorites/{$place->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('favorites', ['id' => $favorite->id]);
    }
}
