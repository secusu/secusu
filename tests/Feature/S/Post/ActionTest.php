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

namespace Tests\Feature\S\Post;

use App\Models\Secu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_secu()
    {
        $data = 'test-data';

        $response = $this->postJson('s', [
            'data' => $data,
        ]);

        $response->assertStatus(201);
        $secu = Secu::query()->latest()->first();
        $this->assertSame(json_encode($data), $secu->getAttribute('data'));
    }

    /** @test */
    public function it_can_store_secu_with_array_data()
    {
        $data = [
            'test' => 'array',
        ];

        $response = $this->postJson('s', [
            'data' => $data,
        ]);

        $response->assertStatus(201);
        $secu = Secu::query()->latest()->first();
        $this->assertSame(json_encode($data), $secu->getAttribute('data'));
    }
}
