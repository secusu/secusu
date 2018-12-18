<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <open@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\S\Get;

use App\Http\Controllers\Controller;
use App\Repositories\Secu\SecuRepository;
use Illuminate\Http\Request;
use Nocarrier\Hal;

class Action extends Controller
{
    public function __invoke(string $hash, SecuRepository $secu, Request $request)
    {
        $hal = new Hal(route($request->route()->getName(), $hash));

        $secu = $secu->findByHashAndDestroy($hash);
        if (!$secu) {
            $hal->setData([
                'data' => [
                    'iv' => str_random(22) . '==',
                    'v' => 1,
                    'iter' => 4096,
                    'ks' => 256,
                    'ts' => 128,
                    'mode' => 'gcm',
                    'adata' => 'U8OLQ1U=',
                    'cipher' => 'aes',
                    'salt' => str_random(11) . '=',
                    'ct' => str_random(mt_rand(2, 5000)) . '==',
                ],
            ]);
        } else {
            $hal->setData([
                'data' => json_decode($secu->data, true),
            ]);
        }

        $hal->addLink('store', route('secu.store'));

        return $hal->asJson();
    }
}
