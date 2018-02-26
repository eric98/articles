<?php

namespace Ergare17\Articles\Console\Commands;

use Ergare17\Articles\Models\Article;
use Illuminate\Console\Command;
use Mockery\Exception;
use Ergare17\Articles\Console\Commands\Traits\AsksForUsers;

class CreateArticleCommand extends Command
{
    use AsksForUsers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:create {title? : The article title} {description? : The article description} {user_id? : The user id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an article';

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
            Article::create([
                'title' => $this->argument('title') ? $this->argument('title') : $this->ask('Article title?'),
                'user_id'     => $this->argument('user_id') ? $this->argument('user_id') : $this->askForUsers(),
                'description' => $this->argument('description') ? $this->argument('description') : $this->ask('Article description?'),
                'read' => false,
            ]);
        } catch (Exception $e) {
            $this->error('Error');
        }
        $this->info('Article has been added to database succesfully');
    }
}
