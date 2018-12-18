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

namespace Tests\Feature\S\Get;

use App\Models\Secu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_destroy_secu_on_retrieve()
    {
        $secu = factory(Secu::class)->create();

        $response = $this->get("s/{$secu->hash}");

        $response->assertStatus(200);
        $this->assertNull($secu->fresh());
    }

    /** @test */
    public function it_not_destroy_other_secus_on_retrieve()
    {
        $secu1 = factory(Secu::class)->create();
        $secu2 = factory(Secu::class)->create();
        $secu3 = factory(Secu::class)->create();

        $response = $this->get("s/{$secu2->hash}");

        $response->assertStatus(200);
        $this->assertNotNull($secu1->fresh());
        $this->assertNull($secu2->fresh());
        $this->assertNotNull($secu3->fresh());
    }

    /** @test */
    public function it_preserve_string_content_integrity()
    {
        $data = 'test-data';
        $secu = factory(Secu::class)->create([
            'data' => json_encode($data),
        ]);

        $response = $this->get("s/{$secu->hash}");

        $response->assertStatus(200);
        $retrievedSecu = json_decode($response->getContent(), true);
        $this->assertSame($data, $retrievedSecu['data']);
    }

    /** @test */
    public function it_preserve_array_content_integrity()
    {
        $data = [
            'level1' => [
                'level2' => [
                    'level3' => 'test-data',
                ],
            ],
            'author' => "Tom's data",
        ];
        $secu = factory(Secu::class)->create([
            'data' => json_encode($data),
        ]);

        $response = $this->get("s/{$secu->hash}");

        $response->assertStatus(200);
        $retrievedSecu = json_decode($response->getContent(), true);
        $this->assertSame($data, $retrievedSecu['data']);
    }

    /** @test */
    public function it_generates_fake_data_for_unknown_hash()
    {
        $response = $this->get("s/any-random-hash");

        $response->assertStatus(200);
        $result = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('ct', $result['data']);
        $this->assertNotEmpty($result['data']['ct']);
    }
}
