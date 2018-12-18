<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <open@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Models;

use App\Events\SecuWasCreated;
use App\Traits\HasUniqueHashTrait;
use Illuminate\Database\Eloquent\Model;

class Secu extends Model
{
    use HasUniqueHashTrait;

    /**
     * The table associated with the model.
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
}
