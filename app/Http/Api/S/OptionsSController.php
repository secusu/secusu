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

namespace App\Http\Api\S;

use Illuminate\Contracts\Support\Responsable as ResponsableContract;
use Illuminate\Http\Request;

class OptionsSController
{
    public function __invoke(
        Request $request
    ): ResponsableContract {
        $data = [
            'POST' => [
                'description' => 'Create a SЁCU',
                'parameters' => [
                    'data' => [
                        'type' => 'string',
                        'description' => 'Any data to store',
                        'required' => 'true',
                    ],
                ],
                'example' => [
                    'data' => 'This is my super SЁCUre data!',
                ],
            ],
        ];

        return new OptionsSResponse($data);
    }
}
