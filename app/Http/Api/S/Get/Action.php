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

namespace App\Http\Api\S\Get;

use App\Models\Secu;
use App\Repositories\Secu\SecuRepository;
use Illuminate\Contracts\Support\Responsable as ResponsableContract;

use function str_random;

class Action
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
        $hash = $request->getHash();

        try {
            $secu = $this->secuRepository->findByHashAndDestroy($hash);
            $data = $this->decodeRealData($secu);
        } catch (\Throwable $exception) {
            $data = $this->generateFakeData();
        }

        return new Response($data);
    }

    private function decodeRealData(
        Secu $secu
    ): array {
        return [
            'data' => json_decode($secu->getAttribute('data'), true),
        ];
    }

    private function generateFakeData(): array
    {
        return [
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
        ];
    }
}
