<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Services;

use GuzzleHttp\Client as GuzzleHttp;

/**
 * Class CryptService.
 * @package App\Services
 */
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
     * @param $password
     * @param $message
     * @return string
     */
    public function encrypt($password, $message)
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
     * @param $password
     * @param $message
     * @return string
     */
    public function decrypt($password, $message)
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
