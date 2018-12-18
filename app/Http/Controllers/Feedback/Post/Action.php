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

namespace App\Http\Controllers\Feedback\Post;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Contracts\Support\Responsable as ResponsableContract;

class Action extends Controller
{
    public function __invoke(Request $request): ResponsableContract
    {
        Feedback::query()->create($request->validated());

        $data = [
            'success' => true,
        ];

        return new Response($data);
    }
}
