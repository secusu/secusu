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

namespace App\Services;

use GuzzleHttp\Client as GuzzleHttp;

final class CryptService
{
    private string $baseUri;

    private GuzzleHttp $http;

    public function __construct(
        string $baseUri,
        GuzzleHttp $http
    ) {
        $this->baseUri = $baseUri;
        $this->http = $http;
    }

    /**
     * Encrypt data with provided password.
     */
    public function encrypt(
        string $password,
        string $message
    ): string {
        $response = $this->http->post(
            $this->buildUrl('/encrypt'),
            [
                'form_params' => [
                    'password' => $password,
                    'message' => $message,
                ],
            ]
        );

        $cipher = json_decode(
            $response->getBody()->getContents(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        return $cipher;
    }

    /**
     * Decrypt cipher using password.
     */
    public function decrypt(
        string $password,
        string $message
    ): string {
        $response = $this->http->post(
            $this->buildUrl('/decrypt'),
            [
                'form_params' => [
                    'password' => $password,
                    'message' => $message,
                ],
            ]
        );

        $data = $response->getBody()->getContents();

        return $data;
    }

    protected function buildUrl(
        string $uri
    ): string {
        return rtrim($this->baseUri, '/') . '/' . ltrim($uri, '/');
    }
}
