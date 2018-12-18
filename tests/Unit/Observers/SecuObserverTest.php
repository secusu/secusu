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

namespace Tests\Unit\Observers;

use App\Events\SecuWasCreated;
use App\Models\Secu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecuObserverTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_fires_secu_was_created_on_created()
    {
        $this->expectsEvents(SecuWasCreated::class);

        factory(Secu::class)->create();
    }
}
