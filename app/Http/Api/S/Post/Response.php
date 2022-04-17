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

namespace App\Http\Api\S\Post;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Nocarrier\Hal;

use function response;
use function route;

class Response implements Responsable
{
    private string $hash;

    public function __construct(
        string $hash
    ) {
        $this->hash = $hash;
    }

    public function toResponse(
        $request
    ) {
        return response($this->toJson($request), 201);
    }

    private function toJson(
        Request $request
    ) {
        $hal = new Hal($request->route()->uri());
        $hal->setData([
            'hash' => $this->hash,
        ]);
        $hal->addLink('show', route('secu.show', $this->hash));

        return $hal->asJson();
    }
}
