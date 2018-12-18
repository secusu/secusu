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

use App\Models\Secu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SecuTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_fill_data()
    {
        $secu = new Secu([
            'data' => 'Test Data',
        ]);

        $this->assertSame('Test Data', $secu->getAttribute('data'));
    }

    /** @test */
    public function it_cannot_fill_hash()
    {
        $secu = new Secu([
            'hash' => 'TestHash',
        ]);

        $this->assertNull($secu->getAttribute('hash'));
    }

    /** @test */
    public function it_casts_id_to_string()
    {
        $secu = factory(Secu::class)->create([
            'id' => 500,
        ]);

        $this->assertSame('500', $secu->getAttribute('id'));
    }

    /** @test */
    public function it_can_scope_secus_older_than()
    {
        $oldPackages = factory(Secu::class, 2)->create([
            'created_at' => Carbon::now()->subDay(2),
        ]);
        factory(Secu::class, 3)->create([
            'created_at' => Carbon::now()->subDay(1),
        ]);

        $assertOldPackages = Secu::olderThan(Carbon::now()->subDay(1))->get();
        $this->assertCount(2, $assertOldPackages);
        $this->assertTrue($assertOldPackages->get(0)->is($oldPackages->get(0)));
        $this->assertTrue($assertOldPackages->get(1)->is($oldPackages->get(1)));
    }
}
