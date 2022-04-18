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

namespace App\Repositories\Secu;

use App\Models\Secu;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

final class SecuRepositoryEloquent implements SecuRepository
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
     * @return string
     */
    public function getId(): string
    {
        return $this->instance->getAttribute('id');
    }

    /**
     * Get SЁCU hash.
     *
     * @return string
     */
    public function getHash(): string
    {
        return $this->instance->getAttribute('hash');
    }

    /**
     * Store data.
     *
     * @param string|array $data Data needed to be stored
     * @return void
     */
    public function store($data): void
    {
        $data = json_encode($data);

        $this->instance = $this->secu->query()->create([
            'data' => $data,
        ]);
    }

    /**
     * Retrieve record and destroy.
     *
     * @param string $hash
     * @return \App\Models\Secu $secu
     * @throws \Exception
     */
    public function findByHashAndDestroy(string $hash): Secu
    {
        /** @var \App\Models\Secu $secu */
        $secu = $this->secu->findByHash($hash);
        if (!$secu) {
            // TODO: Throw custom exception
            throw new \RuntimeException();
        }

        $secu->delete();

        return $secu;
    }

    /**
     * Get records older than timestamp.
     *
     * @param \Illuminate\Support\Carbon $timestamp
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function olderThan(Carbon $timestamp): Builder
    {
        return $this->secu->olderThan($timestamp);
    }

    /**
     * Get SЁCU total created count.
     *
     * @return int
     */
    public function getSecuTotalCreatedCount(): int
    {
        if (DB::getDriverName() === 'sqlite') {
            $schema = DB::table('SQLITE_SEQUENCE')
                ->where('name', $this->secu->getTable())
                ->select('seq')
                ->first();

            $sequence = intval($schema->seq);

            return $sequence;
        }

        // TODO: Use config instead of `env`
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
