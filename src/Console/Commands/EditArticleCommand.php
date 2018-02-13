<?php

namespace Ergare17\Articles\Console\Commands;

use Ergare17\Articles\Console\Commands\Traits\AsksForArticles;
use Ergare17\Articles\Console\Commands\Traits\AsksForUsers;
use Ergare17\Articles\Models\Article;
use Illuminate\Console\Command;
use Mockery\Exception;

/**
 * Class EditArticleCommand.
 */
class EditArticleCommand extends Command
{
    use AsksForArticles;
    use AsksForUsers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:edit {id? : The article id} {title? : The article title} {user_id? : The user id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Edit an article';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $id = $this->argument('id') ? $this->argument('id') : $this->askForArticles();
            $article = Article::findOrFail($id);
            $article->update([
                'title'        => $this->argument('title') ? $this->argument('title') : $this->ask('Article title?', $article->title),
                'user_id'     => $this->argument('user_id') ? $this->argument('user_id') : $this->askForUsers(),
            ]);
        } catch (Exception $e) {
            $this->error('Error');
        }
        $this->info('Article has been edited to database succesfully');
    }
}
