<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <open@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\Feedback\Options;

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
                'description' => 'Post a feedback',
                'parameters' => [
                    'email' => [
                        'type' => 'string',
                        'description' => 'Sender e-mail',
                        'required' => 'false',
                    ],
                    'body' => [
                        'type' => 'string',
                        'description' => 'Message body',
                        'required' => 'true',
                    ],
                ],
                'example' => [
                    'email' => 'example@mail.com',
                    'body' => 'Hello guys! Your project is very SЁCUred!',
                ],
            ],
        ]);

        return $hal->asJson();
    }
}
