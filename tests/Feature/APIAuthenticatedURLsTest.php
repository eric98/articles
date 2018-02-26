<?php

namespace Ergare17\Articles\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class AuthenticatedURLSTest.
 *
 * @package Tests\Feature
 */
class APIAuthenticatedURLsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
//        $this->withoutExceptionHandling();
    }

    /**
     * Authenticated URIs provider.
     *
     * @return array
     */
    public function authenticatedURIs()
    {
        return [
            ['get','/api/v1/articles'],
            ['get','/api/v1/articles/1'],
            ['post','/api/v1/articles'],
            ['put','/api/v1/articles/1'],
            ['delete','/api/v1/articles/1'],
            ['get','/api/v1/users'],
            ['get','/api/v1/users/1'],
            ['post','/api/v1/users'],
            ['put','/api/v1/users/1'],
            ['delete','/api/v1/users/1'],
        ];
    }

    /**
     * URI requires authenticated user.
     *
     * @test
     * @dataProvider authenticatedURIs
     */
    public function uri_requires_authenticated_user($method, $uri)
    {
        $response = $this->json($method, $uri);
        $response->assertStatus(401);
    }
}
