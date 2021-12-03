<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store()
    {
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $response = $this->actingAs($user,'api')->json('POST', '/api/posts', [ //accedemos a la ruta
            'title' => 'El post de prueba' //enviando este dato
        ]);
        $response->assertJsonStructure(['id','title','created_at','updated_at'])->assertJson(['title'=>'El post de prueba'])->assertStatus(201); //debe retornar esto
        $this->assertDatabaseHas('posts',['title'=>'El post de prueba']);
    }

    public function test_validate_title(){
        $response = $this->json('POST', '/api/posts', [ //accedemos a la ruta
            'title' => '' //enviando este dato
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors('title');//imposible completar
    }

    public function test_show()
    {
    $this->withoutExceptionHandling();
    $post = Post::factory()->create();
    $response = $this->json('GET',"/api/posts/$post->id");
    $response->assertJsonStructure(['id','title','created_at'])->assertJson(['title'=> $post->title])->assertStatus(200);
    }

    public function test_update_posts()
    {
        $post = Post::factory()->create();

        $response = $this->json('PUT', "/api/posts/$post->id", [
            'title' => 'Post editado'
        ]);

        $response->assertJsonStructure([
            'id', 'title', 'created_at', 'updated_at'
        ])
            ->assertJson(['title' => 'Post editado'])
            ->assertStatus(Response::HTTP_OK); //Ok, se ha creado un recurso

        $this->assertDatabaseHas(
            'posts',
            [
                'id' => $post->id,
                'title' => 'Post editado'
            ]
        );
    }
    public function test_delete()
    {
        // Con esto vemos el mensaje del error
        $this->withoutExceptionHandling();

        // Primero se crea el post
        $post = Post::factory()->create();

        // Sec rea la función de eliminar
        $response = $this->json('DELETE', "api/posts/$post->id");

        // Se crean las validaciones
        $response->assertSee(null)
                ->assertStatus(204); //sin contenido

        // Con el  assertDatabaseMissing decimos que esto no existe en la base de datos.
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
    public function test_index()
    {
        Post::factory()->count(5)->create();
        $response = $this->json('GET','api/posts');
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id','title','created_at','updated_at'] // * estoy obteniendo muchos datos
            ]
        ])->assertStatus(200);
    }

    public function test_guest(){
        $this->json('GET', '/api/posts')->assertStatus(401);
    }
}
