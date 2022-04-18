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

namespace App\Http\Api;

use Illuminate\Contracts\Config\Repository as AppConfigRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

final class HomeController
{
    private Redirector $redirector;

    private AppConfigRepositoryInterface $appConfigRepository;

    public function __construct(
        Redirector $redirector,
        AppConfigRepositoryInterface $appConfigRepository
    ) {
        $this->redirector = $redirector;
        $this->appConfigRepository = $appConfigRepository;
    }

    public function __invoke(
        Request $request
    ): RedirectResponse {
        return $this->redirector->to(
            $this->appConfigRepository->get('app.web_url')
        );
    }
}
