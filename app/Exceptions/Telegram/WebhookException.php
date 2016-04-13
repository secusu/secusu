<?php

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
