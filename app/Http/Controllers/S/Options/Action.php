<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <open@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\S\Options;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nocarrier\Hal;

class Action extends Controller
{
    public function __invoke(Request $request)
    {
        $hal = new Hal($request->route()->uri());
        $hal->setData([
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
        ]);

        return $hal->asJson();
    }
}
