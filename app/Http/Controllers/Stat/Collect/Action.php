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

namespace App\Http\Controllers\Stat\Collect;

use App\Http\Controllers\Controller;
use App\Repositories\Secu\SecuRepository;
use Illuminate\Contracts\Support\Responsable as ResponsableContract;
use Illuminate\Http\Request;

class Action extends Controller
{
    public function __invoke(SecuRepository $secu, Request $request): ResponsableContract
    {
        $secuCreatedCount = $secu->getSecuTotalCreatedCount();

        $data = [
            'secu' => [
                'count' => $secuCreatedCount,
            ],
        ];

        return new Response($data);
    }
}
