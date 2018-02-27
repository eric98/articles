<?php

namespace Ergare17\Articles\Feature;

use Ergare17\Articles\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;

/**
 * Class DeleteArticleCommandTest.
 */
class DeleteArticleCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testItDeletesAArticle()
    {
        $article = factory(Article::class)->create();
        $this->artisan('article:delete', ['id' => $article->id]);

        $resultAsText = Artisan::output();

        $this->assertDatabaseMissing('articles', [
            'id'        => $article->id,
            'title'      => $article->title,
            'user_id'   => $article->user_id,
            'completed' => $article->completed,
        ]);

        $this->assertContains('Article has been deleted to database succesfully', $resultAsText);
    }

    public function testItDeletesAArticleWhithWizard()
    {
        $command = Mockery::mock('Ergare17\Articles\Console\Commands\DeleteArticleCommand[ask,choice]');
        $article = factory(Article::class)->create();

        $command->shouldReceive('choice')
            ->once()
            ->with('Article id?', [0 => $article->title])
            ->andReturn($article->title);

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        $this->artisan('article:delete');

        $resultAsText = Artisan::output();

        $this->assertDatabaseMissing('articles', [
            'id'          => $article->id,
            'title'        => $article->title,
            'user_id'     => $article->user_id,
            'completed'   => $article->completed,
        ]);

        $this->assertContains('Article has been deleted to database succesfully', $resultAsText);
    }
}
