<?php

namespace Ergare17\Articles\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

/**
 * Class Home.
 */
class Home extends BasePage
{
    protected $links = [
        [
            'path'  => '/tasks_php',
            'name'  => 'Articles PHP',
        ],
        [
            'path'  => '/tasks',
            'name'  => 'Articles Vue',
        ],
    ];

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/home';
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
        $browser
            ->assertPathIs($this->url());

        foreach ($this->links as $link) {
            $name = $link['path'];
            $selector = "a[href='$name'";
            $browser
                ->assertSeeLink($link['name'])
                ->click($selector)
                ->assertPathIs($link['path']);
        }
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }
}
