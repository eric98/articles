<?php

namespace Ergare17\Articles\Feature;

use App\User;
use Ergare17\Articles\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;

/**
 * Class ShowArticleCommandTest.
 */
class ShowArticleCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testItShowAArticle()
    {
        $article = factory(Article::class)->create();
        $this->artisan('article:show', ['id' => $article->id]);

        $resultAsText = Artisan::output();

        $this->assertContains('Title: ', $resultAsText);
        $this->assertContains($article->title, $resultAsText);

        $this->assertContains('Read: ', $resultAsText);
        $this->assertContains($article->read ? 'Yes' : 'No', $resultAsText);

        $this->assertContains('User id: ', $resultAsText);
        $this->assertContains((string) $article->user_id, $resultAsText);

        $this->assertContains('User name: ', $resultAsText);
        $this->assertContains(User::findOrFail($article->user_id)->name, $resultAsText);
    }

    public function testItShowAArticleWithWizard()
    {
        $command = Mockery::mock('Ergare17\Articles\Console\Commands\ShowArticleCommand[ask,choice]');
        $article = factory(Article::class)->create();

        $command->shouldReceive('choice')
            ->once()
            ->with('Article id?', [0 => $article->title])
            ->andReturn($article->title);

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        $this->artisan('article:show');

        $resultAsText = Artisan::output();

        $this->assertContains('Title: ', $resultAsText);
        $this->assertContains($article->title, $resultAsText);

        $this->assertContains('Read: ', $resultAsText);
        $this->assertContains($article->read ? 'Yes' : 'No', $resultAsText);

        $this->assertContains('User id: ', $resultAsText);
        $this->assertContains((string) $article->user_id, $resultAsText);

        $this->assertContains('User name: ', $resultAsText);
        $this->assertContains(User::findOrFail($article->user_id)->name, $resultAsText);
    }
}
