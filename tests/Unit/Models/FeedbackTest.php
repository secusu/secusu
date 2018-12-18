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

namespace Tests\Unit\Models;

use App\Models\Feedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_fill_body()
    {
        $feedback = new Feedback([
            'body' => 'Test Body',
        ]);

        $this->assertSame('Test Body', $feedback->getAttribute('body'));
    }

    /** @test */
    public function it_can_fill_email()
    {
        $feedback = new Feedback([
            'email' => 'support@secu.su',
        ]);

        $this->assertSame('support@secu.su', $feedback->getAttribute('email'));
    }
}
