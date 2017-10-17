<?php

namespace Ergare17\Articles\Providers;

use Illuminate\Support\ServiceProvider;
use Route;

class ArticlesServiceProvider extends ServiceProvider
{

    public function register()
    {
        if (!defined('ARTICLES_PATH')) {
            define('ARTICLES_PATH', realpath(__DIR__.'/../../'));
        }
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
        require ARTICLES_PATH.'/src/routes/web.php';
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
}