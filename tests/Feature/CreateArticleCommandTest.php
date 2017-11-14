<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateArticleCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testItCreatesNewArticle()
    {
        //1) Prepare

        //2) Execute

        $this->artisan('article:create', ['title' => 'Comprar','description' => 'Comprar pa al super']);

        //3)Assert
        // If you need result of console output
        $resultAsText = Artisan::output();

        $this->assertDatabaseHas('articles',['title' => 'Comprar','description' => 'Comprar pa al super']);

        //Receive "Article has been added to database succesfully."
//        $this->assertTrue(str_contains($resultAsText, 'Article has been added to database succesfully'));
        $this->assertContains('Article has been added to database succesfully',$resultAsText);
    }

    public function testItAsksForAnArticleAndThenCreatesNewArticle2()
    {
        //1) Prepare
        $command = Mockery::mock('Ergare17\Articles\Console\Commands\CreateArticleCommand[ask]');

        $command->shouldReceive('ask')
            ->once()
            ->with('Article title?')
            ->andReturn('Comprar llet');

        $command->shouldReceive('ask')
            ->once()
            ->with('Article description?')
            ->andReturn('Anar a comprar la llet');

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        //2) Execute
        $this->artisan('article:create');

        $this->assertDatabaseHas('articles',['title' => 'Comprar llet']);

        //3) Assert
        $resultAsText = Artisan::output();
        $this->assertContains('Article has been added to database succesfully',$resultAsText);
    }

    public function testItAsksForAnArticleAndThenCatchTheError()
    {
        try {
            $this->artisan('article:create');
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }

}
