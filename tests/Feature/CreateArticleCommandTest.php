<?php

namespace Ergare17\Articles\Feature;

use App\User;
use Ergare17\Articles\TestCase;
use Ergare17\Articles\Traits\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Mockery;

class CreateArticleCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testItCreatesNewArticle()
    {
        //1) Prepare
        $user = factory(User::class)->create();

        //2) Execute

        $this->artisan('article:create', [
            'title'           => 'Comprar pa',
            'description'    => 'Com sempre',
            'user_id'        => $user->id,
        ]);

        //3)Assert
        // If you need result of console output
        $resultAsText = Artisan::output();

        $this->assertDatabaseHas('articles', ['title' => 'Comprar pa', 'description' => 'Com sempre', 'user_id' => $user->id]);

        //Receive "Article has been added to database succesfully."
        $this->assertContains('Article has been added to database succesfully', $resultAsText);
    }

    public function testItAsksForAArticleNameAndThenCreatesNewArticle2()
    {
        $user = factory(User::class)->create();

        //1) Prepare
        $command = Mockery::mock('Ergare17\Articles\Console\Commands\CreateArticleCommand[ask,choice]');

        $command->shouldReceive('ask')
            ->once()
            ->with('Article title?')
            ->andReturn('Comprar llet');

        $command->shouldReceive('choice')
            ->once()
            ->with('User?', [0 => $user->name])
            ->andReturn($user->name);

        $command->shouldReceive('ask')
            ->once()
            ->with('Article description?')
            ->andReturn('Com sempre');


        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        //2) Execute
        $this->artisan('article:create');

        $this->assertDatabaseHas('articles', ['title' => 'Comprar llet', 'description' => 'Com sempre', 'user_id' => $user->id]);

        //3) Assert
        $resultAsText = Artisan::output();
        $this->assertContains('Article has been added to database succesfully', $resultAsText);
    }
}
