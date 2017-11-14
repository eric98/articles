<?php

namespace Tests\Feature;


use App\User;
use Ergare17\Articles\Models\Article;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class ApiArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
//        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function can_list_articles()
    {
        factory(Article::class,3)->create();

        $user = factory(User::class)->create();
//        View::share('user',$user);
        $this->actingAs($user);

        $response = $this->json('GET','/api/v1/articles');
        $response->assertSuccessful();

        $response->assertJsonStructure([[
            'id',
            'title',
            'created_at',
            'updated_at'
        ]]);
    }

    /**
     * @test
     */
    public function can_show_an_article()
    {
        $article = factory(Article::class)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->json('GET', '/api/v1/articles/' . $article->id);

        $response->assertSuccessful();

        $response->assertJson([
            'id' => $article->id,
            'title' => $article->title,
            'description' => $article->description,
            'created_at' => $article->created_at,
            'updated_at' => $article->updated_at
        ]);
    }

    /**
     * @test
     */
    public function cannot_add_article_if_not_logged()
    {
        $faker = Factory::create();

        // EXECUTE
        $response = $this->json('POST','/api/v1/articles', [
            'title' => $title = $faker->word,
            'description' => $description = $faker->sentence
        ]);

        // ASSERT
        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function title_provided()
    {
        // PREPARE
        $faker = Factory::create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        // EXECUTE
        $response = $this->json('POST','/api/v1/articles');

        // ASSERT
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function can_add_a_article()
    {
        // PREPARE
        $faker = Factory::create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        // EXECUTE
        $response = $this->json('POST','/api/v1/articles', [
            'title' => $title = $faker->word,
            'description' => $description = $faker->sentence
        ]);

        // ASSERT
        $response->assertSuccessful();
        $this->assertDatabaseHas('articles', [
            'title' => $title
        ]);

        $response->assertJson([
            'title' => $title,
            'description' => $description
        ]);
    }
    
    /**
     * @test
     */
    public function can_delete_article()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->json('DELETE','/api/v1/articles/'.$article->id);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('articles',[
            'id' => $article->id
        ]);

        $response->assertJson([
            'id' => $article->id,
            'title' => $article->title,
            'description' => $article->description
        ]);
    }

    /**
     * @test
     */
    public function cannot_delete_unexisting_article()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->json('DELETE','/api/v1/articles/1');

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function can_edit_article()
    {
        // PREPARE
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        // EXECUTE
        $response = $this->json('PUT','/api/v1/articles/'.$article->id, [
            'title' => $newTitle = 'NOU TITOL',
            'description' => $newDescription = 'nova descripcio'
        ]);

        // ASSERT
        $response->assertSuccessful();

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => $newTitle,
            'description' => $newDescription
        ]);

        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
            'title' => $article->title,
            'description' => $article->description
        ]);

        $response->assertJson([
            'id' => $article->id,
            'title' => $newTitle,
            'description' => $newDescription
        ]);
    }
}