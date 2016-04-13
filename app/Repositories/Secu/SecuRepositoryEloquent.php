<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repositories\Secu;

use App\Models\Secu;

/**
 * Class SecuRepository.
 * @package App\Repositories\Secu
 */
class SecuRepositoryEloquent implements SecuRepository
{
    /**
     * @var \App\Models\Secu
     */
    private $secu;

    /**
     * @var Secu
     */
    private $instance;

    public function __construct(Secu $secu)
    {
        $this->secu = $secu;
    }

    /**
     * Get SЁCU hash.
     *
     * @return mixed
     */
    public function getHash()
    {
        return $this->instance->hash;
    }

    /**
     * Store data.
     *
     * @param string $data Data needed to be stored
     * @return string Unique hash of record
     */
    public function store($data)
    {
        $data = json_encode($data);

        $this->instance = $this->secu->create([
            'data' => $data,
        ]);
    }

    /**
     * Retrieve record and destroy.
     *
     * @param $hash
     * @return Secu $secu
     */
    public function findByHashAndDestroy($hash)
    {
        $secu = $this->secu->findByHash($hash);
        if (!$secu) {
            return false;
        }

        $secu->delete();

        return $secu;
    }

    /**
     * Get records older than timestamp.
     *
     * @param $timestamp
     * @return mixed
     */
    public function olderThan($timestamp)
    {
        return $this->secu->olderThan($timestamp);
    }
}
