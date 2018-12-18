<?php

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
use Tests\TestCase;

class ActionTest extends TestCase
{
    /** @test */
    public function it_can_store_secu()
    {
        $data = 'test-data';
        $secuCount = Secu::query()->count();

        $this->postJson('s', [
            'data' => $data,
        ]);

        $this->assertSame($secuCount + 1, Secu::query()->count());
    }

    /** @test */
    public function it_can_return_hash_on_store()
    {
        $data = 'test-data';

        $response = $this->postJson('s', [
            'data' => $data,
        ]);

        $secu = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('hash', $secu);
        $this->assertEquals(6, strlen($secu['hash']));
    }

    /** @test */
    public function it_can_destroy_secu_on_retrieve()
    {
        $data = 'test-data';
        $secuCount = Secu::query()->count();
        $response = $this->postJson('s', [
            'data' => $data,
        ]);
        $secu = json_decode($response->getContent(), true);

        $this->get("s/{$secu['hash']}");

        $this->assertSame($secuCount, Secu::query()->count());
    }

    /** @test */
    public function it_can_preserve_string_content_integrity()
    {
        $data = 'test-data';
        $response = $this->postJson('s', [
            'data' => $data,
        ]);
        $secu = json_decode($response->getContent(), true);

        $response = $this->get("s/{$secu['hash']}");

        $retrievedSecu = json_decode($response->getContent(), true);
        $this->assertSame($data, $retrievedSecu['data']);
    }

    /** @test */
    public function it_can_preserve_array_content_integrity()
    {
        $data = [
            'level1' => [
                'level2' => [
                    'level3' => 'test-data',
                ],
            ],
            'author' => "Tom's data",
        ];
        $response = $this->postJson('s', [
            'data' => $data,
        ]);
        $secu = json_decode($response->getContent(), true);

        $response = $this->get("s/{$secu['hash']}");

        $retrievedSecu = json_decode($response->getContent(), true);
        $this->assertSame($data, $retrievedSecu['data']);
    }
}
