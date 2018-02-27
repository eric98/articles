<?php

namespace Ergare17\Articles\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

/**
 * Class VueArticlesPage.
 */
class VueArticlesPage extends BasePage
{
    const TITLE = 'Articles';

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/articles';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser
     *
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@articles'                => '#articles',
            '@reload'               => '#reload',
            '@read'            => '#read-articles',
            '@pending'              => '#pending-articles',
            '@all'                  => '#all-articles',
            '@store-article'           => '#store-article',       // Add article button or link or...
            '@update-article'          => '#update-article',      // Update article button or link or... Update update article in database
            '@destroy-article'         => '#destroy-article',     // Destroy article button or link or... Destroy delete
            '@cancel-delete-article'   => '#cancel-delete-article',  // Cancel delete article button or link or... Destroy delete
            '@toogle-complete-article' => '#complete-article',    // Toogle complete article button or link or...

            // TODO : sort and pagination
        ];
    }

    /**
     * See title.
     *
     * @param Browser $browser
     */
    public function seeTitle(Browser $browser)
    {
        $browser->assertTitleContains(self::TITLE);
    }

    /**
     * See box.
     *
     * @param Browser $browser
     */
    public function seeBox(Browser $browser, $title)
    {
        $browser->assertVisible('.box');
        $browser->assertSeein('.box .box-title', $title);
        $browser->assertVisible('.box .box-body td');
    }

    /**
     * See articles on page.
     *
     * @param Browser $browser
     * @param $articles
     */
    public function seeArticles(Browser $browser, $articles)
    {
        foreach ($articles as $article) {
            $this->seeArticle($browser, $article);
        }
        $browser->assertSee('Articles filtrats: '.count($articles));
    }

    /**
     * See articles on page.
     *
     * @param Browser $browser
     * @param $articles
     */
    public function dontSeeArticles(Browser $browser, $articles)
    {
        foreach ($articles as $article) {
            $this->dontSeeArticle($browser, $article);
        }
    }

    /**
     * Don't see article.
     *
     * @param Browser $browser
     * @param $article
     */
    public function dontSeeArticle(Browser $browser, $article)
    {
        $browser->assertDontSee($article->title);
    }

    /**
     * Apply read filter.
     *
     * @param Browser $browser
     */
    public function applyCompletedFilter(Browser $browser)
    {
        $browser->press('@read');
    }

    /**
     * Apply pending filter.
     *
     * @param Browser $browser
     */
    public function applyPendingFilter(Browser $browser)
    {
        $browser->press('@pending');
    }

    /**
     * Apply all filter.
     *
     * @param Browser $browser
     */
    public function applyAllFilter(Browser $browser)
    {
        $browser->press('@all');
    }

    /**
     * See article.
     *
     * @param Browser $browser
     * @param $article
     */
    public function seeArticle(Browser $browser, $article)
    {
        $browser->assertSee($article->title);
    }

    /**
     * Dont see alert.
     *
     * @param Browser $browser
     */
    public function dontSeeAlert(Browser $browser)
    {
        $browser->assertMissing('.alert');
    }

    /**
     * Press reload button.
     */
    public function reload(Browser $browser)
    {
        $browser->press('@reload');
    }

    /**
     * Store article.
     *
     * @param Browser $browser
     * @param $article
     */
    public function store_article(Browser $browser, $article)
    {
        $browser->type('title', $article->title);
//        $browser->type('description', $article->description); faria falta javascript ja que no es un element html normal
//        $browser->select('user_id'); faria falta javascript ja que no es un element html normal
        $this->store($browser);
    }

    /**
     * Update article.
     *
     * @param Browser $browser
     * @param $newArticle
     */
    public function update_article(Browser $browser, $newArticle)
    {
        //Init edit
        $this->edit($browser);
        $this->type('new-title', $newArticle->title);
        //Confirm edit
        $this->update($browser);
    }

    /**
     * Cancel update article.
     *
     * @param Browser $browser
     * @param $newArticle
     */
    public function cancel_update_article(Browser $browser, $newArticle)
    {
        //Init edit
        $this->edit($browser);
        $this->type('new-title', $newArticle->title);
        //Cancel edit
        $this->cancel_update($browser); // TODO
    }

    /**
     * Press create button.
     */
    public function store(Browser $browser)
    {
        $browser->press('@store-article');
    }

    /**
     * Press edit button.
     */
    public function edit(Browser $browser, $article)
    {
        $browser->press('#edit-article-'.$article->id);
    }

    /**
     * Press update button.
     */
    public function update(Browser $browser)
    {
        $browser->press('@update-article');
    }

    /**
     * Destroy article.
     *
     * @param Browser $browser
     * @param $article
     */
    public function destroy_article(Browser $browser, $article)
    {
        //Init delete
        $this->delete($browser, $article);
        sleep(1);
        //Confirm delete
        $this->destroy($browser); // No need of article-> only one visible confirm exists
    }

    /**
     * Cancel Destroy article.
     *
     * @param Browser $browser
     * @param $article
     */
    public function cancel_destroy_article(Browser $browser, $article)
    {
        //Init delete
        $this->delete($browser, $article);
        //Cancel delete
        $this->cancel_destroy($browser); // TODO
    }

    public function toogle_complete() // TODO
    {
    }

    /**
     * Press delete button.
     */
    public function delete(Browser $browser, $article)
    {
        $browser->press('#delete-article-'.$article->id);
    }

    /**
     * Press destroy button.
     */
    public function destroy(Browser $browser)
    {
        $browser->press('@destroy-article');
    }

    /**
     * Press cancel delete button.
     */
    public function cancel_delete(Browser $browser)
    {
        $browser->press('@cancel-delete-article');
    }
}
