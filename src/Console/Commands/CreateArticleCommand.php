<?php

namespace Ergare17\Articles\Console\Commands;

use Ergare17\Articles\Models\Article;
use Illuminate\Console\Command;
use Mockery\Exception;

class CreateArticleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:create {title? : The article title} {description? : The article description}';

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
        //TODO fer un test que provoque l'error i que mire si surt l'error
        try {
            Article::create([
                'title' => $this->argument('title') ? $this->argument('title') : $this->ask('Article title?'),
                'description' => $this->argument('description') ? $this->argument('description') : $this->ask('Article description?')
            ]);
        } catch (Exception $e) {
            $this->error('Error');
        }
        $this->info('Article has been added to database succesfully');
    }
}
