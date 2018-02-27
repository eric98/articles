<?php

namespace Ergare17\Articles\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Home;
use Tests\DuskTestCase;

/**
 * Class SendEmailTest.
 */
class HomeTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Login.
     *
     * @return mixed
     */
    protected function login($browser)
    {
        $user = factory(User::class)->create();
        $browser->loginAs($user);

        return $user;
    }

    /**
     * Show send email.
     *
     * @test
     *
     * @return void
     */
    public function show_home()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            $browser->visit(new Home());
        });
    }
}
