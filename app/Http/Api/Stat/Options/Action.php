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

namespace App\Http\Api\Stat\Options;

use Illuminate\Contracts\Support\Responsable as ResponsableContract;
use Illuminate\Http\Request;

class Action
{
    public function __invoke(
        Request $request
    ): ResponsableContract {
        $data = [
            'GET' => [
                'description' => 'Get SЁCU statistics',
            ],
        ];

        return new Response($data);
    }
}
