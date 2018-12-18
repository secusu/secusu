<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <open@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Traits;

use App\Services\Hasher;

trait HasUniqueHashTrait
{
    /**
     * Retrieve record.
     *
     * @param string $hash Unique Hash of encrypted record.
     * @return \Illuminate\Database\Eloquent\Model $model
     */
    public function findByHash($hash)
    {
        return $this->where('hash', $hash)->first();
    }

    /**
     * Generates a unique hash.
     *
     * @return string 6 characters unique hash
     */
    private static function generateHash()
    {
        $hasher = new Hasher();
        do {
            $hash = $hasher->generate(6);
        } while (static::hashExists($hash));

        return $hash;
    }

    /**
     * Checks if hash exists.
     *
     * @param string $hash Hash that is to be checked for existence in database
     * @return bool true if the hash is found and false otherwise
     */
    private static function hashExists($hash)
    {
        return static::where('hash', $hash)->count() !== 0;
    }
}
