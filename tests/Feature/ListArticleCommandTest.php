<?php

namespace Ergare17\Articles\Feature;

use App\User;
use Ergare17\Articles\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

/**
 * Class ListArticleCommandTest.
 */
class ListArticleCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testListArticles()
    {
        $articles = factory(Article::class, 3)->create();
        $this->artisan('article:list');

        $resultAsText = Artisan::output();

        foreach ($articles as $article) {
            $this->assertContains((string) $article->id, $resultAsText);
            $this->assertContains($article->title, $resultAsText);
            $this->assertContains((string) $article->read, $resultAsText);
            $this->assertContains((string) $article->user_id, $resultAsText);
            $this->assertContains(User::findOrFail($article->user_id)->name, $resultAsText);
        }
    }
}
