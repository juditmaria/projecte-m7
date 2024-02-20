<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Post;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostTest extends TestCase
{
    //use RefreshDatabase;

    public function test_post_creation()
    {
        Storage::fake('public');

        // Simular la autenticación de un usuario
        $user = User::factory()->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->image('test_image.jpg');

        $response = $this->postJson('/api/posts', [
            'body' => 'Test post body',
            'upload' => $file,
            'latitude' => '123.456',
            'longitude' => '789.012',
        ]);

        $response->assertStatus(201);
    }

    public function test_show_post()
    {
        // Crear un post
        $post = Post::factory()->create();

        // Hacer una solicitud GET al endpoint de show
        $response = $this->getJson("/api/posts/{$post->id}");

        // Asegurar que la respuesta tenga el código de estado 200
        $response->assertStatus(200);

        // Asegurar que la respuesta contenga los datos del post
        $response->assertJson([
            'id' => $post->id,
            'body' => $post->body,
            // Agrega más campos si es necesario
        ]);
    }

    public function test_post_reading()
    {
        $post = Post::factory()->create();

        $response = $this->getJson('/api/posts/' . $post->id);

        $response->assertStatus(200)
            ->assertJson([
                'body' => $post->body,
            ]);
    }

    public function test_post_update()
    {
        Storage::fake('public');

        $post = Post::factory()->create();

        $file = UploadedFile::fake()->image('updated_image.jpg');

        $response = $this->putJson('/api/posts/' . $post->id, [
            'body' => 'Updated post body',
            'upload' => $file,
            'latitude' => '123.456',
            'longitude' => '789.012',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('posts', ['body' => 'Updated post body']);
    }

    public function test_post_deletion()
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson('/api/posts/' . $post->id);

        $response->assertStatus(204);
    }

    
}
