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

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Nocarrier\Hal;

class Response implements Responsable
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    public function toResponse($request)
    {
        return response($this->toJson($request), 201);
    }

    private function toJson(Request $request)
    {
        $hal = new Hal($request->url());
        $hal->setData($this->data);

        return $hal->asJson();
    }
}
