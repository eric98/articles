<?php

namespace Ergare17\Articles\Providers;

use Ergare17\Articles\Console\Commands\CreateArticleCommand;
use Ergare17\Articles\Console\Commands\DeleteArticleCommand;
use Ergare17\Articles\Console\Commands\ListArticlesCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

class ArticlesServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (!defined('ARTICLES_PATH')) {
            define('ARTICLES_PATH', realpath(__DIR__.'/../../'));
        }
        $this->registerEloquentFactoriesFrom(ARTICLES_PATH . '/database/factories');
    }

    public function boot()
    {
//        dump('Booting Articles package');
        $this->defineRoutes();
        $this->loadViews();
        $this->loadMigrations();
        $this->loadCommands();
    }

    protected function loadCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateArticleCommand::class,
                ListArticlesCommand::class,
                DeleteArticleCommand::class
            ]);
        }
    }

    public function defineRoutes()
    {
        $this->defineWebRoutes();
        $this->defineApiRoutes();
    }

    public function defineWebRoutes()
    {
        require ARTICLES_PATH.'/routes/web.php';
    }

    public function defineApiRoutes()
    {
        require ARTICLES_PATH.'/routes/api.php';
    }

    private function loadViews()
    {
        $this->loadViewsFrom(ARTICLES_PATH.'/resources/views', 'articles');
    }

    private function loadMigrations()
    {
        $this->loadMigrationsFrom(ARTICLES_PATH.'/database/migrations');
    }

    /**
     * Register factories.
     *
     * @param  string  $path
     * @return void
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }
}
