<?php

namespace Ergare17\Articles\Browser;

use App\User;
use Ergare17\Articles\Models\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * Class PHPArticlesTest.
 */
class PHPArticlesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
        initialize_articles_permissions();
//        Artisan::call('passport:install');
//        $this->withoutExceptionHandling();
    }

    /**
     * @return mixed
     */
    protected function loginAndAuthorize($browser)
    {
        $user = factory(User::class)->create();
        $user->assignRole('articles-manager');
        $browser->loginAs($user);

        return $user;
    }

    /**
     * List articles.
     *
     * @test
     *
     * @return void
     */
    public function list_articles()
    {
        $this->browse(function (Browser $browser) {
            $articles = factory(Article::class, 3)->create();
            $browser->maximize();
//            $browser->resize(1920, 1080);
            $this->loginAndAuthorize($browser);

            $browser->visit('/articles_php');
            $browser->assertTitleContains('Articles');
            //don't see alert message (only show when errors or ok messages)
            $browser->assertMissing('.alert');
            $browser->assertSeeLink('Create Article');

            // See articles box
            $browser->assertVisible('.box');
            //See box title
            $browser->assertSeein('.box .box-title', 'Articles:');
            //see table in box body
            $browser->assertVisible('.box .box-body .table');

            foreach ($articles as $article) {
                $browser->assertSee($article->id);
                $browser->assertSee($article->title);
                $browser->assertSee($article->user_id);
                $browser->assertSee(User::findOrFail($article->user_id)->name);
                $browser->assertVisible('#show-article-'.$article->id);
                $this->assertContains('Show', $browser->text('#show-article-'.$article->id));
                $browser->assertVisible('#edit-article-'.$article->id);
                $this->assertContains('Edit', $browser->text('#edit-article-'.$article->id));
                $browser->assertVisible('#delete-article-'.$article->id);
                $this->assertContains('Delete', $browser->text('#delete-article-'.$article->id));
            }
        });
    }

    /**
     * Create articles.
     *
     * @test
     *
     * @return void
     */
    public function create_article()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize();
            $user = factory(User::class)->create();
            $user->assignRole('articles-manager');
            $this->loginAndAuthorize($browser);

            $browser->visit('/articles_php');

            $browser->assertSeeLink('Create Article');
            $browser->clickLink('Create Article');
            $browser->assertMissing('.alert');
            //Test back button
            $browser->assertSeeLink('List Articles');
            $browser->clickLink('List Articles');
            $browser->clickLink('Create Article');

            // See create article box
            $browser->assertVisible('.box');
            //see form in box body
            $browser->assertVisible('.box form');

            //Assert see input for article title
            $browser->assertVisible('.box form input[name=title]');

            // Assert see select/dropdown for user
            $browser->assertVisible('.box form select[name=user_id]');

            //See box footer
            $browser->assertVisible('.box .box-footer .btn');
            $browser->assertInputValue('.box .box-footer .btn', 'Create');

            //Test validation
            $browser->press('Create');
            $browser->waitFor('.alert');
            $browser->waitForText('The title field is required.');
            $browser->waitForText('The description field is required.');

            //Create article
            $browser->type('title', 'Buy bread');
            $browser->type('description', 'At the bakery');
            //Select a random user in users dropdown
            $browser->select('user_id');
            $browser->press('Create');

            $browser->waitFor('.alert');
            $browser->waitForText('Created ok!');

            $browser->clickLink('Back');
            $browser->assertSee('Buy bread');
        });
    }

    /**
     * Show article.
     *
     * @test
     *
     * @return void
     */
    public function show_article()
    {
        $this->browse(function (Browser $browser) {
            $articles = factory(Article::class, 3)->create();

            $browser->maximize();
            $user = factory(User::class)->create();
            $user->assignRole('articles-manager');
            $this->loginAndAuthorize($browser);

            $browser->visit('/articles_php');

            $browser->click('#show-article-1');

            //Test back button
            $browser->assertSeeLink('Back');
            $browser->clickLink('Back');
            $browser->click('#show-article-1');

            //Test edit button
            $browser->assertSeeLink('Edit');
            $browser->clickLink('Edit');

            $browser->assertPathIs('/articles_php/edit/1');
            $browser->assertSeeLink('List Articles');
            $browser->clickLink('List Articles');

            //Test delete button
            $browser->assertVisible('#delete-article-1');

            $browser->assertSee($articles[0]->id);
            $browser->assertSee($articles[0]->title);
            $browser->assertSee($articles[0]->user_id);
            $browser->assertSee(User::findOrFail($articles[0]->user_id)->name);
        });
    }

    /**
     * Edit article.
     *
     * @test
     *
     * @return void
     */
    public function edit_article()
    {
        $this->browse(function (Browser $browser) {
            $articles = factory(Article::class, 2)->create();
            $browser->maximize();
            $user = factory(User::class)->create();
            $user->assignRole('articles-manager');
            $this->loginAndAuthorize($browser);

            $browser->visit('/articles_php');

            $browser->assertSee($articles[0]->title);

            $browser->click('#edit-article-1');

            $value = $browser->value('@title');
            $this->assertContains($articles[0]->title, $value);
            $value = $browser->value('@user_id');
            $this->assertContains(strval($articles[0]->user_id), $value);

            //Test Edit
            $article = $articles[0];
            $browser->visit('/articles_php');
            $browser->click('#edit-article-'.$article->id);

            $browser->type('title', 'Buy bread');
            //Select a random user in users dropdown
            $browser->select('user_id', $articles[1]->user_id);
            $browser->press('Update');

            $browser->waitFor('.alert');
            $browser->waitForText('Edited ok!');
            $browser->assertSee('Edited ok!');

            $browser->visit('/articles_php/'.$article->id);
            $browser->assertSee('Buy bread');
            $browser->assertDontSee($article->name);
            $browser->assertSee(User::findOrFail($articles[1]->user_id)->name);
            $browser->assertDontSee(User::findOrFail($article->user_id)->name);
        });
    }

    /**
     * Delete article.
     *
     * @test
     *
     * @return void
     */
    public function delete_article()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $article = Article::create([
                'title' => 'Comprar pa',
                'description' => 'Com sempre',
                'user_id' => $user->id
            ]);

            $browser->maximize();
            $user->assignRole('articles-manager');
            $this->loginAndAuthorize($browser);

            $browser->visit('/articles_php');

            $browser->click('#delete-article-'.$article->id);

            $browser->waitFor('.alert');
            $browser->waitForText('Article was deleted successful!');
            $browser->assertSee('Article was deleted successful!');

            $browser->assertDontSee($article->title);
        });
    }
}
