<?php

namespace Tests\Feature;

use App\User;
use Ergare17\Articles\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class APIAttendedArticleControllerTest.
 *
 * @package Tests\Feature
 */
class ApiReadArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    const MANAGER = 'articles-manager';

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
        initialize_articles_permissions();
//        $this->withoutExceptionHandling();
    }

    /**
     * Login as articles manager.
     *
     * @param $user
     */
    protected function loginAsManager($user, $driver = 'api')
    {
        $user->assignRole(self::MANAGER);
        $this->actingAs($user, $driver);
    }

    /**
     * Store.
     *
     * @test
     */
    public function store()
    {
        $user = factory(User::class)->create();
        $this->loginAsManager($user, 'api');
        $article = factory(Article::class)->create();

        $response = $this->json('POST', '/api/v1/read-article/' . $article->id);

        $response->assertSuccessful();

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => $article->title,
            'read' => true,
            'description' => $article->description,
            'user_id' => $article->user_id
        ]);

        $response->assertJson([
            'id' => $article->id,
            'title' => $article->title,
            'read' => true,
            'description' => $article->description,
            'user_id' => $article->user_id
        ]);
    }

    /**
     * Destroy.
     *
     * @test
     */
    public function destroy()
    {
        $user = factory(User::class)->create();
        $this->loginAsManager($user, 'api');

        $article = factory(Article::class)->create();
        $response = $this->json('DELETE', '/api/v1/read-article/' . $article->id);

        $response->assertSuccessful();

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => $article->title,
            'read' => false,
            'description' => $article->description,
            'user_id' => $article->user_id
        ]);

        $response->assertJson([
            'id' => $article->id,
            'title' => $article->title,
            'read' => false,
            'description' => $article->description,
            'user_id' => $article->user_id
        ]);

        $response->assertJson([
            'id' => $article->id,
            'title' => $article->title
        ]);
    }
}
