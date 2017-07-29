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
use App\Repositories\Secu\SecuRepository;
use Nocarrier\Hal;

/**
 * Class StatController.
 * @package App\Http\Controllers\Api\V1
 */
class StatController extends Controller
{
    /**
     * @var SecuRepository
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
     * Get statistics.
     *
     * @return string
     */
    public function index()
    {
        $secuCreatedCount = $this->secu->getSecuTotalCreatedCount();

        $hal = new Hal(route($this->getRouter()->currentRouteName()));
        $hal->setData([
            'secu' => [
                'count' => $secuCreatedCount,
            ],
        ]);

        return $hal->asJson();
    }

    /**
     * Show /stat options.
     *
     * @return string
     */
    public function options()
    {
        $hal = new Hal(route($this->getRouter()->currentRouteName()));
        $hal->setData([
            'GET' => [
                'description' => 'Get SЁCU statistics',
            ],
        ]);

        return $hal->asJson();
    }
}
