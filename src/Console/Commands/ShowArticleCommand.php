<?php

namespace Ergare17\Articles\Console\Commands;

use App\User;
use Ergare17\Articles\Console\Commands\Traits\AsksForArticles;
use Ergare17\Articles\Models\Article;
use Illuminate\Console\Command;
use Mockery\Exception;

class ShowArticleCommand extends Command
{
    use AsksForArticles;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:show {id? : The article id to show}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show an articl';

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
        $id = $this->argument('id') ? $this->argument('id') : $this->askForArticles();
        $article = Article::findOrFail($id);
        $user = User::findOrFail($article->user_id);

        try {
            $headers = ['Key', 'Value'];

            $fields = [
                ['Title:', $article->title],
                ['Description', $article->description],
                ['Read:', $article->read ? 'Yes' : 'No'],
                ['User id:', $article->user_id],
                ['User name:', $user->name],
            ];

            $this->table($headers, $fields);
        } catch (Exception $e) {
            $this->error('Error');
        }
    }
}
