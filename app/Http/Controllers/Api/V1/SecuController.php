<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <open@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SecuRequest;
use App\Repositories\Secu\SecuRepository;
use Nocarrier\Hal;

/**
 * Class SecuController.
 * @package App\Http\Controllers\Api\V1
 */
class SecuController extends Controller
{
    /**
     * @var \App\Repositories\Secu\SecuRepository
     */
    private $secu;

    /**
     * @param \App\Repositories\Secu\SecuRepository $secu
     */
    public function __construct(SecuRepository $secu)
    {
        $this->secu = $secu;
    }

    /**
     * Store data container.
     *
     * @param SecuRequest $request
     * @return string
     */
    public function store(SecuRequest $request)
    {
        $this->secu->store($request->input('data'));
        $hash = $this->secu->getHash();

        $hal = new Hal(route($this->getRouter()->currentRouteName()));
        $hal->setData([
            'hash' => $hash,
        ]);
        $hal->addLink('show', route('secu.show', $hash));

        return $hal->asJson();
    }

    /**
     * Get data container by hash.
     *
     * @param $hash
     * @return string
     */
    public function show($hash)
    {
        $hal = new Hal(route($this->getRouter()->currentRouteName(), $hash));

        $secu = $this->secu->findByHashAndDestroy($hash);
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

    /**
     * Show secu options.
     *
     * @return string
     */
    public function options()
    {
        $hal = new Hal(route($this->getRouter()->currentRouteName()));
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
