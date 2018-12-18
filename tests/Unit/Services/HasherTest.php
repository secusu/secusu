<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <open@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Unit\Services;

use App\Services\Hasher;
use Tests\TestCase;

class HasherTest extends TestCase
{
    /** @test */
    public function it_can_generate_hash_of_length()
    {
        $length = 6;
        $hash = (new Hasher())->generate($length);
        $this->assertSame($length, strlen($hash));
    }

    /** @test */
    public function it_can_generate_unique_hash()
    {
        $length = 6;
        $hasher = new Hasher();
        $hash1 = $hasher->generate($length);
        $hash2 = $hasher->generate($length);
        $this->assertNotSame($hash1, $hash2);
    }
}
