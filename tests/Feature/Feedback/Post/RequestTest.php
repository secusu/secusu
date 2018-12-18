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

namespace Tests\Feature\Feedback\Post;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_cannot_store_feedback_with_not_string_body()
    {
        $response = $this->postJson('feedback', [
            'body' => 4,
        ]);

        $response->assertStatus(422);
        $result = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('body', $result['errors']);
    }

    /** @test */
    public function it_cannot_send_invalid_email()
    {
        $response = $this->postJson('feedback', [
            'email' => 'invalid-email',
        ]);

        $response->assertStatus(422);
        $result = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('email', $result['errors']);
    }
}
