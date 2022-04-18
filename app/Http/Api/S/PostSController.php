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

namespace App\Http\Api\S;

use App\Repositories\Secu\SecuRepository;
use Illuminate\Contracts\Support\Responsable as ResponsableContract;

class PostSController
{
    private SecuRepository $secuRepository;

    public function __construct(
        SecuRepository $secuRepository
    ) {
        $this->secuRepository = $secuRepository;
    }

    public function __invoke(
        PostSRequest $request
    ): ResponsableContract {
        $this->secuRepository->store($request->input('data'));
        $hash = $this->secuRepository->getHash();

        return new PostSResponse($hash);
    }
}
