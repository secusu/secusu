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

namespace App\Exceptions\Telegram;

use Exception;

class WebhookException extends Exception
{
    public static function requestEmpty()
    {
        return new static('Request is empty');
    }

    public static function requestMalformed($reason, $request)
    {
        return new static("Request malformed ($reason): {$request}");
    }

    public static function tokenIncorrect($token)
    {
        return new static("Webhook token incorrect: {$token}");
    }
}
