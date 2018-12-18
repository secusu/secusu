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

namespace App\Observers;

use App\Events\SecuWasCreated;
use App\Models\Secu;

class SecuObserver
{
    public function creating(Secu $secu): void
    {
//        $secu->setAttribute('hash', $secu::generateHash());
    }

    public function created(Secu $secu): void
    {
        event(new SecuWasCreated($secu));
    }
}
