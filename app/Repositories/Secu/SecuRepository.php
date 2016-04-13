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

/**
 * Interface SecuRepository.
 * @package App\Repositories\Secu
 */
interface SecuRepository
{
    /**
     * Get SЁCU hash.
     *
     * @return mixed
     */
    public function getHash();

    /**
     * Store data.
     *
     * @param string $data Data needed to be stored
     * @return string Unique hash of record
     */
    public function store($data);

    /**
     * Retrieve record and destroy.
     *
     * @param $hash
     * @return mixed
     */
    public function findByHashAndDestroy($hash);

    /**
     * Get records older than timestamp.
     *
     * @param $timestamp
     * @return mixed
     */
    public function olderThan($timestamp);
}
