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

namespace App\Http\Api\Stat;

use Illuminate\Contracts\Support\Responsable as ResponsableContract;
use Illuminate\Http\Request;

final class OptionsStatController
{
    public function __invoke(
        Request $request
    ): ResponsableContract {
        $data = [
            'GET' => [
                'description' => 'Get SЁCU statistics',
            ],
        ];

        return new OptionsStatResponse($data);
    }
}
