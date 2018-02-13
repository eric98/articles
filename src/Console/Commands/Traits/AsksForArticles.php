<?php

namespace Ergare17\Articles\Console\Commands\Traits;

use Ergare17\Articles\Models\Article;

/**
 * Trait AsksForArticles.
 */
trait AsksForArticles
{
    /**
     * Ask for articles.
     *
     * @return mixed
     */
    protected function askForArticles()
    {
        $articles = Article::all();
        $article_titles = $articles->pluck('title')->toArray();
        $article_title = $this->choice('Article id?', $article_titles);

        return $articles->where('title', $article_title)->first()->id;
    }
}
