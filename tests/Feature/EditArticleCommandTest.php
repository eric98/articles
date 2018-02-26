<?php

namespace Ergare17\Articles\Feature;

use App\User;
use Ergare17\Articles\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;

/**
 * Class EditArticleCommandTest.
 */
class EditArticleCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testItEditsAnArticle()
    {
        $article = factory(Article::class)->create();
        $this->artisan('article:edit', ['id' => $article->id, 'title' => 'Comprar pa', 'description' => 'Com sempre', 'user_id' => $article->user_id]);

        $resultAsText = Artisan::output();

        $this->assertDatabaseHas('articles', [
            'id'          => $article->id,
            'title'        => 'Comprar pa',
            'description' => 'Com sempre',
            'user_id'     => $article->user_id,
            'read'   => $article->read,
        ]);

        $this->assertDatabaseMissing('articles', [
            'id'          => $article->id,
            'title'        => $article->title,
            'description' => $article->description,
            'user_id'     => $article->user_id,
            'read'   => $article->read,
        ]);

        $this->assertContains('Article has been edited to database succesfully', $resultAsText);
    }

    public function testItEditsAArticleWithWizard()
    {
        $command = Mockery::mock('Ergare17\Articles\Console\Commands\\EditArticleCommand[ask,choice]');
        $article = factory(Article::class)->create();
        $newUser = factory(User::class)->create();
        $user = User::findOrFail('1');

        $command->shouldReceive('choice')
            ->once()
            ->with('Article id?', [0 => $article->title])
            ->andReturn($article->title);
        $command->shouldReceive('ask')
            ->once()
            ->with('Article title?', $article->title)
            ->andReturn('Nou nom');

        $command->shouldReceive('ask')
            ->once()
            ->with('Article description?', $article->description)
            ->andReturn('Nova descripcio');

        $command->shouldReceive('choice')
            ->once()
            ->with('User?', [0 => $user->name, 1 => $newUser->name])
            ->andReturn($newUser->name);

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        $this->artisan('article:edit');

        $this->assertDatabaseHas('articles', [
            'id'          => $article->id,
            'title'        => 'Nou nom',
            'description' => 'Nova descripcio',
            'user_id'     => $newUser->id,
            'read'   => $article->read,
        ]);

        $this->assertDatabaseMissing('articles', [
            'id'          => $article->id,
            'title'        => $article->title,
            'description'        => $article->description,
            'user_id'     => $article->user_id,
            'read'   => $article->read,
        ]);

        $resultAsText = Artisan::output();
        $this->assertContains('Article has been edited to database succesfully', $resultAsText);
    }
}
