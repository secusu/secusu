<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <oss@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repositories\Secu;

use App\Models\Secu;
use Illuminate\Support\Facades\DB;

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
     * @var \App\Models\Secu
     */
    private $instance;

    public function __construct(Secu $secu)
    {
        $this->secu = $secu;
    }

    /**
     * Get SЁCU id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->instance->id;
    }

    /**
     * Get SЁCU hash.
     *
     * @return string
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

    /**
     * Get SЁCU total created count.
     *
     * @return int
     */
    public function getSecuTotalCreatedCount()
    {
        if (DB::getDriverName() == 'sqlite') {
            $schema = DB::table('SQLITE_SEQUENCE')
                ->where('name', $this->secu->getTable())
                ->select('seq')
                ->first();

            $sequence = intval($schema->seq);

            return $sequence;
        }

        $schema = DB::table('INFORMATION_SCHEMA.TABLES')
                    ->where('TABLE_SCHEMA', env('DB_DATABASE'))
                    ->where('TABLE_NAME', $this->secu->getTable())
                    ->select('AUTO_INCREMENT')
                    ->first();

        if (!$schema) {
            return 0;
        }

        $sequence = intval($schema->AUTO_INCREMENT);
        $sequence = $sequence - 1;

        return $sequence;
    }
}
