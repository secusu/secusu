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

interface SecuRepository
{
    /**
     * Get SЁCU id.
     *
     * @return mixed
     */
    public function getId();

    /**
     * Get SЁCU hash.
     *
     * @return string
     */
    public function getHash(): string;

    /**
     * Store data.
     *
     * @param string $data Data needed to be stored
     * @return void
     */
    public function store(string $data): void;

    /**
     * Retrieve record and destroy.
     *
     * @param $hash
     * @return mixed
     *
     * @throws \Exception
     */
    public function findByHashAndDestroy(string $hash): Secu;

    /**
     * Get records older than timestamp.
     *
     * @param $timestamp
     * @return mixed
     */
    public function olderThan($timestamp);

    /**
     * Get SЁCU total created count.
     *
     * @return int
     */
    public function getSecuTotalCreatedCount(): int;
}
