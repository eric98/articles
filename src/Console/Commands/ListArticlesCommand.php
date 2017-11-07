<?php

namespace Ergare17\Articles\Console\Commands;

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
            $headers = ['id','Title','Description'];

            $users = Article::all(['id','title','description'])->toArray();
        } catch (Exception $e) {
            $this->error('Error');
        }
        $this->table($headers, $users);
    }
}
