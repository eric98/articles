<?php

namespace Ergare17\Articles\Console\Commands;

use App\User;
use Ergare17\Articles\Models\Article;
use http\Exception;
use Illuminate\Console\Command;

class ListArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List articles';

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
            $articles = Article::all();

            $headers = ['id', 'Title','Description', 'Read', 'User id', 'User Name'];
            $fields = [];
            foreach ($articles as $article) {
                $fields[] = [
                    'id:'               => $article->id,
                    'Title:'             => $article->title,
                    'Description:' => $article->description,
                    'Read:'        => $article->read ? 'Yes' : 'No',
                    'User id:'          => $article->user_id,
                    'User name:'        => User::findOrFail($article->user_id)->name,
                ];
            }
        } catch (Exception $e) {
            $this->error('Error');
        }
        $this->table($headers, $fields);
    }
}
