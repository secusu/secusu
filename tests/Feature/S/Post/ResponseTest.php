<?php

declare(strict_types=1);

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <open@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Feature\S\Post;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResponseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_hash_on_post()
    {
        $data = 'test-data';

        $response = $this->postJson('s', [
            'data' => $data,
        ]);

        $response->assertStatus(201);
        $secu = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('hash', $secu);
        $this->assertSame(6, strlen($secu['hash']));
    }
}
