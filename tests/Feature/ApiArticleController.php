<?php

namespace Tests\Feature;

use App\User;
use Ergare17\Articles\Models\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiArticleController extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
//        $this->withoutExceptionHandling();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShowArticlesViaApi()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $articles = factory(Article::class, 5)->create();

        $response = $this->json('GET', '/api/v1/articles');

        $response->assertSuccessful();

        $response->assertJsonStructure([[
            'id','title','description','created_at','updated_at'
        ]]);
    }

    public function testShowArticleViaApi()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $article = factory(Article::class)->create();
        $response = $this->json('GET', '/api/v1/articles/'.$article->id);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'id','title','description','created_at','updated_at'
        ]);
        $response->assertJson([
            'id' => $article->id,
            'title'=> $article->title,
            'description' => $article->description,
            'created_at' => $article->created_at,
            'updated_at' => $article->updated_at
        ]);
    }

    public function testShowArticlesViaApiAreBlankIfDatabaseIsEmpty()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->json('GET', '/api/v1/articles');
        // TODO comprovar es buit!
        $response->assertSuccessful();
    }
}
