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

namespace App\Http\Controllers\S\Post;

use App\Http\Controllers\Controller;
use App\Repositories\Secu\SecuRepository;
use Nocarrier\Hal;

class Action extends Controller
{
    public function __invoke(SecuRepository $secu, Request $request)
    {
        $secu->store($request->input('data'));
        $hash = $secu->getHash();

        $hal = new Hal($request->route()->uri());
        $hal->setData([
            'hash' => $hash,
        ]);
        $hal->addLink('show', route('secu.show', $hash));

        return response($hal->asJson(), 201);
    }
}
