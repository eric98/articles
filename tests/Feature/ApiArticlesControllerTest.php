<?php

namespace Ergare17\Articles\Feature;

use App\User;
use Ergare17\Articles\Models\Article;
use Ergare17\Articles\TestCase;
use Ergare17\Articles\Traits\RefreshDatabase;
use Faker\Factory;
use Illuminate\Support\Facades\Artisan;

class ApiArticlesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        initialize_articles_permissions();
        Artisan::call('passport:install');
//        $this->withoutExceptionHandling();
    }

    protected function loginAndAuthorize()
    {
        $user = factory(User::class)->create();
        $user->assignRole('articles-manager');
        $this->actingAs($user, 'api');

        return $user;
    }

    /**
     * @test
     */
    public function can_list_articles()
    {
        $articles = factory(Article::class, 3)->create();

        $user = $this->loginAndAuthorize();

        $response = $this->json('GET', '/api/v1/articles');
        $response->assertSuccessful();

        $response->assertJsonStructure([[
            'id',
            'title',
            'description',
            'user_id',
            'read',
            'created_at',
            'updated_at',
        ]]);
    }

    /**
     * @test
     */
    public function can_show_an_article()
    {
        $article = factory(Article::class)->create();

        $user = $this->loginAndAuthorize();

        $response = $this->json('GET', '/api/v1/articles/'.$article->id);

        $response->assertSuccessful();

        $response->assertJson([
            'id'         => $article->id,
            'title'       => $article->title,
            'description'       => $article->description,
            'user_id'    => $article->user_id,
            'read'  => $article->read,
            'created_at' => $article->created_at,
            'updated_at' => $article->updated_at,
        ]);
    }

    /**
     * @test
     */
    public function cannot_add_article_if_not_title_provided()
    {
        // PREPARE
        $user = $this->loginAndAuthorize();

        // EXECUTE
        $response = $this->json('POST', '/api/v1/articles');

        // ASSERT
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function can_add_an_article()
    {
        // PREPARE
        $faker = Factory::create();
        $user = $this->loginAndAuthorize();

        // EXECUTE
        $response = $this->json('POST', '/api/v1/articles', [
            'title'        => $title = $faker->word,
            'description' => $description = $faker->paragraph,
            'user_id'     => $user->id,
        ]);

        // ASSERT
        $response->assertSuccessful();
        $this->assertDatabaseHas('articles', [
            'title'        => $title,
            'description' => $description,
            'user_id'     => $user->id,
        ]);

        $response->assertJson([
            'title'        => $title,
            'description' => $description,
            'user_id'     => $user->id,
        ]);
    }

    /**
     * @test
     */
    public function can_delete_article()
    {
        $article = factory(Article::class)->create();
        $user = $this->loginAndAuthorize();

        $response = $this->json('DELETE', '/api/v1/articles/'.$article->id);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('articles', [
            'id'        => $article->id,
            'title'      => $article->title,
            'description'   => $article->description,
            'user_id'   => $article->user_id,
            'read' => $article->read,
        ]);

        $response->assertJson([
            'id'        => $article->id,
            'title'      => $article->title,
            'description'   => $article->description,
            'user_id'   => $article->user_id,
            'read' => $article->read,
        ]);
    }

    /**
     * @test
     */
    public function cannot_delete_unexisting_article()
    {
        $user = $this->loginAndAuthorize();

        $response = $this->json('DELETE', '/api/v1/articles/1');

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function can_edit_article()
    {
        $article = factory(Article::class)->create();
        $user = $this->loginAndAuthorize();

        $response = $this->json('PUT', '/api/v1/articles/'.$article->id, [
            'title' => $newName = 'NOU NOM',
        ]);

        $response->assertSuccessful();
        $this->assertDatabaseHas('articles', [
            'id'        => $article->id,
            'title'      => $newName,
            'description'   => $article->description,
            'user_id'   => $article->user_id,
            'read' => $article->read,
        ]);

        $this->assertDatabaseMissing('articles', [
            'id'        => $article->id,
            'title'      => $article->title,
            'description'   => $article->description,
            'user_id'   => $article->user_id,
            'read' => $article->read,
        ]);

        $response->assertJson([
            'id'        => $article->id,
            'title'      => $newName,
            'description'   => $article->description,
            'user_id'   => $article->user_id,
            'read' => $article->read,
        ]);
    }
}
