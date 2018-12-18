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

namespace App\Traits;

use App\Services\Hasher;
use Illuminate\Database\Eloquent\Model;

trait HasUniqueHashTrait
{
    /**
     * Retrieve record.
     *
     * @param string $hash Unique Hash of encrypted record.
     * @return \Illuminate\Database\Eloquent\Model $model
     */
    public function findByHash(string $hash): ?Model
    {
        return $this->where('hash', $hash)->first();
    }

    /**
     * Generates a unique hash.
     *
     * @return string 6 characters unique hash
     */
    private static function generateHash(): string
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
    private static function hashExists(string $hash): bool
    {
        return static::where('hash', $hash)->count() !== 0;
    }
}
