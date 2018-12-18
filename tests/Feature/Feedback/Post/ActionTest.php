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

use App\Models\Feedback;
use Tests\TestCase;

class ActionTest extends TestCase
{
    /** @test */
    public function it_can_store_feedback_without_email()
    {
        $body = 'test-feedback-without-email';
        $count = Feedback::query()->count();

        $this->postJson('feedback', [
            'body' => $body,
        ]);

        $this->assertSame($count + 1, Feedback::query()->count());
    }

    /** @test */
    public function it_can_store_feedback_with_email()
    {
        $body = 'test-feedback-with-email';
        $email = 'unit@secu.su';
        $count = Feedback::query()->count();

        $this->postJson('feedback', [
            'body' => $body,
            'email' => $email,
        ]);

        $this->assertSame($count + 1, Feedback::query()->count());
    }
}
