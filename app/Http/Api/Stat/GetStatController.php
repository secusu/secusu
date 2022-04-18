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

use App\Repositories\Secu\SecuRepository;
use Illuminate\Contracts\Support\Responsable as ResponsableContract;
use Illuminate\Http\Request;

class GetStatController
{
    private SecuRepository $secuRepository;

    public function __construct(
        SecuRepository $secuRepository
    ) {
        $this->secuRepository = $secuRepository;
    }

    public function __invoke(
        Request $request
    ): ResponsableContract {
        $secuCreatedCount = $this->secuRepository->getSecuTotalCreatedCount();

        $data = [
            'secu' => [
                'count' => $secuCreatedCount,
            ],
        ];

        return new GetStatResponse($data);
    }
}
