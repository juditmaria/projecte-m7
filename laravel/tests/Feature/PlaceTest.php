<?php

namespace Tests\Feature;

use App\Models\Place;
use App\Models\File; // Importamos el modelo File
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlaceTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * Test can create a place.
     */
    public function test_can_create_place()
    {
        $user = User::factory()->create();


        $placeData = [
            'name' => 'Test Place',
            'description' => 'This is a test place',
            'latitude' => '10.123456',
            'longitude' => '20.654321',
            'file_id' => '6', 
            'author_id' => $user->id, // Asigna el ID del usuario actual
        ];
        

        $response = $this->actingAs($user)->postJson('/api/places', $placeData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('places', $placeData);
    }

    /**
     * Test can list places.
     */
    public function test_can_list_places()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/places');

        $response->assertStatus(200)
                ->assertJsonStructure(['data']); // Asegura que la respuesta contenga la clave 'data'
    }





    /**
     * Test can show a place.
     */
    public function test_can_show_place()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $place = Place::factory()->create();

        $response = $this->getJson("/api/places/{$place->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $place->name]);
    }

    /**
     * Test can update a place.
     */
    public function test_can_update_place()
    {
        $user = User::factory()->create();

        // Crea un archivo en la base de datos
        $file = File::factory()->create();

        $placeData = [
            'name' => 'Test Place',
            'description' => 'This is a test place',
            'latitude' => '10.123456',
            'longitude' => '20.654321',
            'file_id' => $file->id, // Utiliza el ID del archivo creado
            'author_id' => $user->id, // Utiliza el ID del usuario autenticado
        ];

        $response = $this->actingAs($user)->postJson('/api/places', $placeData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('places', $placeData);
    }

    /**
     * Test can delete a place.
     */
    public function test_can_delete_place()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $place = Place::factory()->create();

        $response = $this->deleteJson("/api/places/{$place->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('places', ['id' => $place->id]);
    }
}
