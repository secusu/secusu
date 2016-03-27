<?php

/*
 * This file is part of Sёcu.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Services\Hasher;

/**
 * Class HasherTest.
 */
class HasherTest extends TestCase
{
    /**
     * @var Hasher
     */
    private $hasher;

    /**
     * SetUp test case environment.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->hasher = new Hasher();
    }

    /** @test */
    public function it_can_generate_hash_of_length()
    {
        $length = 6;
        $hash = $this->hasher->generate($length);
        $this->assertEquals($length, strlen($hash));
    }

    /** @test */
    public function it_can_generate_unique_hash()
    {
        $length = 6;
        $hash1 = $this->hasher->generate($length);
        $hash2 = $this->hasher->generate($length);
        $this->assertNotEquals($hash1, $hash2);
    }
}
