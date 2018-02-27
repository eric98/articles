<?php

namespace Ergare17\Articles\Feature;

use App\User;
use Ergare17\Articles\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        initialize_articles_permissions();
//        $this->withoutExceptionHandling();
    }

    protected function loginAsArticleManager()
    {
        $user = factory(User::class)->create();
        $user->assignRole('articles-manager');
        $this->actingAs($user);
        View::share('user', $user);
    }

    public function testShowAllArticles()
    {
        // 3 parts

        // 1) Preparo el test
        // 2) Executo el codi que vull provar
        // 3) Comprovo: assert

        $this->loginAsArticleManager();

        $articles = factory(Article::class, 50)->create();

        $response = $this->get('/articles_php');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('articles::list_article');

        foreach ($articles as $article) {
            $response->assertSeeText($article->title);
            $response->assertSeeText($article->title);
        }
    }

    /**
     *
     */
    public function testShowAnArticle()
    {
        // Preparo
        $article = factory(Article::class)->create();
        $this->loginAsArticleManager();

        // Executo
        $response = $this->get('/articles_php/'.$article->id);
        // Comprovo
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('articles::show_article');
        $response->assertViewHas('article');

        // assertSeeText() -> mira si apareix el text que li passes, a la web
        $response->assertSeeText($article->title);
        $response->assertSeeText($article->description);
        $response->assertSeeText('Article:');
    }

    /**
     *
     */
    public function testNotShowAnArticle()
    {
        // Executo
        $this->loginAsArticleManager();

        $response = $this->get('/articles_php/999999');
        // Comprovo
        $response->assertStatus(404);
    }

    //laravel eloquent: retrieving models

    public function testShowCreateArticleForm()
    {
        // Preparo
        $this->loginAsArticleManager();

        // Executo
        $response = $this->get('/articles_php/create');
        // Comprovo
        $response->assertStatus(200);
        $response->assertViewIs('articles::create_article');
        $response->assertSeeText('Create Article');
    }

    public function testShowEditArticleForm()
    {
        // Preparo
        $article = factory(Article::class)->create();
        $this->loginAsArticleManager();

        // Executo
        $response = $this->get('/articles_php/edit/'.$article->id);
        // Comprovo
        $response->assertStatus(200);
        $response->assertViewIs('articles::edit_article');
        $response->assertSeeText('Edit Article');

        $responseFinal = $this->get('/articles_php/'.$article->id);

        $responseFinal->assertSeeText($article->title);
        $responseFinal->assertSeeText($article->description);
    }
}
