<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Post;
use App\Models\User;
use App\Models\Like;

class PostLikeTest extends TestCase
{
    //use RefreshDatabase;

    public function test_like_index()
    {
        // Crear un post
        $post = Post::factory()->create();

        // Hacer una solicitud GET al endpoint de likes para obtener todos los likes del post
        $response = $this->getJson("/api/posts/{$post->id}/likes");

        // Asegurar que la respuesta tenga el código de estado 200
        $response->assertStatus(200);
    }

    public function test_like_creation()
    {
        // Crear un post
        $post = Post::factory()->create();

        // Simular la autenticación de un usuario
        $user = User::factory()->create();
        $this->actingAs($user);

        // Hacer una solicitud POST al endpoint de likes para crear un like en el post
        $response = $this->postJson("/api/posts/{$post->id}/likes");

        // Asegurar que la respuesta tenga el código de estado 201 (creado)
        $response->assertStatus(201);
    }

    public function test_show_like()
    {
        // Crear un post
        $post = Post::factory()->create();

        // Hacer una solicitud POST al endpoint de likes para crear un like en el post
        $response = $this->postJson("/api/posts/{$post->id}/likes");

        // Obtener el id del like creado
        $likeId = $response->json('id');

        // Hacer una solicitud GET al endpoint de likes para mostrar el like
        $response = $this->getJson("/api/posts/{$post->id}/likes/{$likeId}");

        // Asegurar que la respuesta tenga el código de estado 200
        $response->assertStatus(200);
    }

    public function test_like_update()
    {
        // Crear un post
        $post = Post::factory()->create();

        // Simular la autenticación de un usuario
        $user = User::factory()->create();
        $this->actingAs($user);

        // Hacer una solicitud POST al endpoint de likes para crear un like en el post
        $response = $this->postJson("/api/posts/{$post->id}/likes");

        // Asegurar que la respuesta sea exitosa y contenga el ID del like
        $response->assertStatus(201);
        $likeData = $response->json();
        $this->assertArrayHasKey('id', $likeData);
        $likeId = $likeData['id'];

        // Hacer una solicitud PUT al endpoint de likes para actualizar el like
        $response = $this->putJson("/api/posts/{$post->id}/likes/{$likeId}");

        // Asegurar que la respuesta tenga el código de estado 200
        $response->assertStatus(200);
    }

    public function test_like_deletion()
    {
        // Crear un post
        $post = Post::factory()->create();

        // Simular la autenticación de un usuario
        $user = User::factory()->create();
        $this->actingAs($user);

        // Hacer una solicitud POST al endpoint de likes para crear un like en el post
        $response = $this->postJson("/api/posts/{$post->id}/likes");

        // Obtener el id del like creado
        $likeId = $response->json('id');

        // Hacer una solicitud DELETE al endpoint de likes para eliminar el like
        $response = $this->deleteJson("/api/posts/{$post->id}/likes/{$likeId}");

        // Asegurar que la respuesta tenga el código de estado 204 (ningún contenido)
        $response->assertStatus(204);
    }

}
