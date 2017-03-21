<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <oss@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Models\Feedback;

/**
 * Class FeedbackTest.
 */
class FeedbackTest extends TestCase
{
    /**
     * @var Feedback
     */
    private $feedback;

    /**
     * SetUp test case environment.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->feedback = new Feedback();
    }

    /** @test */
    public function it_can_store_feedback_without_email()
    {
        $body = 'test-feedback-without-email';
        $secuCount = $this->feedback->count();
        $this->post('feedback', [
            'body' => $body,
        ]);
        $this->assertCount($secuCount + 1, $this->feedback->get());
    }

    /** @test */
    public function it_can_store_feedback_with_email()
    {
        $body = 'test-feedback-with-email';
        $email = 'unit@secu.su';
        $secuCount = $this->feedback->count();
        $this->post('feedback', [
            'body' => $body,
            'email' => $email,
        ]);
        $this->assertCount($secuCount + 1, $this->feedback->get());
    }
}
