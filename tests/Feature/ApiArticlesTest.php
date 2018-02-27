<?php

namespace Ergare17\Articles\Feature;

use Ergare17\Articles\TestCase;
use Ergare17\Articles\Traits\RefreshDatabase;

/**
 * Class ApiEventsTest.
 *
 * @package Tests\Feature
 */
class ApiArticlesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test example.
     *
     * @group todo
     *
     * @test
     */
    public function testObvious()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
