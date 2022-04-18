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

namespace App\Models;

use App\Traits\HasUniqueHashTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

final class Secu extends Model
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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
    ];

    // TODO: Extract to SecuObserver
    public static function boot()
    {
        parent::boot();

        static::creating(function (Secu $secu) {
            $secu->setAttribute('hash', $secu::generateHash());
        });
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder$query
     * @param \Illuminate\Support\Carbon $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOlderThan(Builder $query, Carbon $date): Builder
    {
        return $query->where('created_at', '<', $date);
    }
}
