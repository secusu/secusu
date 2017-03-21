<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <oss@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Models\Secu;

/**
 * Class SecuApiTest.
 */
class SecuApiTest extends TestCase
{
    /**
     * @var Secu
     */
    private $secu;

    /**
     * SetUp test case environment.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->secu = new Secu();
    }

    /** @test */
    public function it_can_store_secu()
    {
        $data = 'test-data';
        $secuCount = $this->secu->count();
        $this->post('s', ['data' => $data]);
        $this->assertCount($secuCount + 1, $this->secu->get());
    }

    /** @test */
    public function it_can_return_hash_on_store()
    {
        $data = 'test-data';
        $secu = $this->post('s', ['data' => $data])->response->content();
        $secu = json_decode($secu, true);
        $this->assertArrayHasKey('hash', $secu);
        $this->assertEquals(6, strlen($secu['hash']));
    }

    /** @test */
    public function it_can_destroy_secu_on_retrieve()
    {
        $data = 'test-data';
        $secuCount = $this->secu->count();
        $secu = $this->post('s', ['data' => $data])->response->content();
        $secu = json_decode($secu, true);
        $this->get("s/{$secu['hash']}");
        $this->assertEquals($secuCount, $this->secu->count());
    }

    /** @test */
    public function it_can_preserve_string_content_integrity()
    {
        $data = 'test-data';
        $secu = $this->post('s', ['data' => $data])->response->content();
        $secu = json_decode($secu, true);

        $retrievedSecu = $this->get("s/{$secu['hash']}")->response->content();
        $retrievedSecu = json_decode($retrievedSecu, true);

        $this->assertEquals($data, $retrievedSecu['data']);
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
        $secu = $this->post('s', ['data' => $data])->response->content();
        $secu = json_decode($secu, true);

        $retrievedSecu = $this->get("s/{$secu['hash']}")->response->content();
        $retrievedSecu = json_decode($retrievedSecu, true);

        $this->assertEquals($data, $retrievedSecu['data']);
    }

    /** @test */
    public function it_can_get_stat_secu_total_created_count()
    {
        $data = 'test-data';
        $this->post('s', ['data' => $data]);
        $this->post('s', ['data' => $data]);

        $stat = $this->get('stat')->response->content();
        $stat = json_decode($stat, true);

        // :TODO: Fix issue with mysql non empty db
        $this->assertEquals(2, $stat['secu']['count']);
    }
}
