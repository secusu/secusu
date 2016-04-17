<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Models;

use App\Events\SecuWasCreated;
use App\Services\Hasher;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Secu.
 * @package App\Models
 */
class Secu extends Model
{
    /**
     * Database table name.
     *
     * @var string
     */
    protected $table = 'secu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'data',
        'hash',
    ];

    /**
     * Model events.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function (Secu $secu) {
            $secu->attributes['hash'] = $secu::generateHash();
        });

        static::created(function (Secu $secu) {
            event(new SecuWasCreated($secu));
        });
    }

    /**
     * Retrieve record.
     *
     * @param string $hash Unique Hash of encrypted record.
     * @return Secu $secu
     */
    public function findByHash($hash)
    {
        return $this->where('hash', $hash)->first();
    }

    /**
     * Scope a query to only include active users.
     *
     * @param $query
     * @param $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOlderThan($query, $date)
    {
        return $query->where('created_at', '<', $date);
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
