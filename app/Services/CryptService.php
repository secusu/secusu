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

class CryptService
{
    /**
     * @var GuzzleHttp
     */
    private $http;

    public function __construct()
    {
        $this->http = new GuzzleHttp();
    }

    /**
     * Encrypt data with provided password.
     *
     * @param string $password
     * @param string $message
     * @return string
     */
    public function encrypt(string $password, string $message): string
    {
        $response = $this->http->post(
            env('CRYPT_URL', 'http://127.0.0.1:3000') . '/encrypt',
            [
                'form_params' => [
                    'password' => $password,
                    'message' => $message,
                ],
            ]
        );
        $cipher = json_decode($response->getBody()->getContents(), true);

        return $cipher;
    }

    /**
     * Decrypt cipher using password.
     *
     * @param string $password
     * @param string $message
     * @return string
     */
    public function decrypt(string $password, string $message): string
    {
        $response = $this->http->post(
            env('CRYPT_URL', 'http://127.0.0.1:3000') . '/decrypt',
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
}
