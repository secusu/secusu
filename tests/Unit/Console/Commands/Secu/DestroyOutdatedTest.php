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

namespace Tests\Unit\Console\Commands\Secu;

use App\Models\Secu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DestroyOutdatedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_fill_body()
    {
        $oldPackages = factory(Secu::class, 2)->create([
            'created_at' => Carbon::now()->subDay(31),
        ]);
        factory(Secu::class, 3)->create([
            'created_at' => Carbon::now()->subDay(30),
        ]);

        $this->artisan('secu:destroy-outdated');

        $this->assertSame(3, Secu::query()->count());
        $this->assertNull($oldPackages->get(0)->fresh());
        $this->assertNull($oldPackages->get(1)->fresh());
    }
}
