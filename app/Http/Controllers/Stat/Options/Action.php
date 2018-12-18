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

namespace App\Http\Controllers\Stat\Options;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Responsable as ResponsableContract;
use Illuminate\Http\Request;

class Action extends Controller
{
    public function __invoke(Request $request): ResponsableContract
    {
        $data = [
            'GET' => [
                'description' => 'Get SЁCU statistics',
            ],
        ];

        return new Response($data);
    }
}
