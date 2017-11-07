<?php

namespace Ergare17\Articles\Console\Commands;

use Ergare17\Articles\Models\Article;
use http\Exception;
use Illuminate\Console\Command;

class DeleteArticleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:delete {id? : The article id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
            $id = $this->argument('id') ? $this->argument('id') : $this->ask('Article id?');
            $article = Article::findOrFail($id);
            $article->delete();
        } catch (Exception $e) {
            $this->error('Error');
        }
        $this->info('Article has been deleted to database succesfully');
    }
}
