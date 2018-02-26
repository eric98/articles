<?php

namespace Ergare17\Articles\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
