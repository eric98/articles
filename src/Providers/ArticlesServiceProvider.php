<?php

namespace Ergare17\Articles\Providers;

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
//        $this->loadFactories();
    }

    public function defineRoutes()
    {
        require ARTICLES_PATH.'/routes/web.php';
    }

    private function loadViews(){
        $this->loadViewsFrom(ARTICLES_PATH.'/resources/views','articles');
    }

    private function loadMigrations(){
        $this->loadMigrationsFrom(ARTICLES_PATH.'/database/migrations');
    }

//    private function loadFactories(){
//        $factory->define(App\Article::class, function (Faker $faker) {
//            return [
//                'title' => $faker->sentence,
//                'description' => $faker->text
//            ];
//        });
//    }

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