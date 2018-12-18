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

namespace Tests\Feature\Stat\Collect;

use App\Models\Secu;
use App\Repositories\Secu\SecuRepositoryEloquent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_stat_secu_total_created_count()
    {
        factory(Secu::class, 2)->create();
        $repository = (new SecuRepositoryEloquent(new Secu()));
        $count = $repository->getSecuTotalCreatedCount();

        $response = $this->getJson('stat');

        $response->assertStatus(200);
        $stat = json_decode($response->getContent(), true);
        $this->assertSame($count, $stat['secu']['count']);
    }
}
