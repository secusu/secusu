<?php

/*
 * This file is part of Sёcu.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Models;

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
    }

    /**
     * Store data.
     *
     * @param string $data Data needed to be secured
     * @return string Unique hash of record
     */
    public function store($data)
    {
        $secu = $this->create([
            'data' => $data,
        ]);

        return $secu->attributes['hash'];
    }

    /**
     * Retrieve record and destroy.
     *
     * @param $hash
     * @return Secu $secu
     */
    public function findByHashAndDestroy($hash)
    {
        $secu = $this->findByHash($hash);
        if (!$secu) {
            return false;
        }

        $secu->delete();

        return $secu;
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
     * Retrieve record.
     *
     * @param string $hash Unique Hash of encrypted record.
     * @return Secu $secu
     */
    private function findByHash($hash)
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
