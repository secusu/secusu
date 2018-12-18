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

namespace App\Http\Controllers\Bot\Telegram;

use App\Exceptions\Telegram\WebhookException;
use App\Http\Controllers\Controller;
use App\Repositories\Secu\SecuRepository;
use App\Services\CryptService;
use App\Services\TelegramBotService;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class Action extends Controller
{
    /**
     * @var \App\Repositories\Secu\SecuRepository
     */
    private $secu;

    /**
     * @var \App\Services\TelegramBotService
     */
    private $telegram;

    /**
     * @var
     */
    private $password;

    /**
     * @var \App\Services\CryptService
     */
    private $crypt;

    /**
     * @param \App\Repositories\Secu\SecuRepository $secu
     * @param \App\Services\TelegramBotService $telegram
     * @param \App\Services\CryptService $crypt
     */
    public function __construct(SecuRepository $secu, TelegramBotService $telegram, CryptService $crypt)
    {
        $this->secu = $secu;
        $this->telegram = $telegram;
        $this->crypt = $crypt;
    }

    /**
     * Bot listener.
     *
     * @param $token
     * @return \Telegram\Bot\Objects\Message
     */
    public function __invoke($token)
    {
        try {
            if ($token != env('TELEGRAM_BOT_WEBHOOK_TOKEN')) {
                throw WebhookException::tokenIncorrect($token);
            }

            $request = $this->telegram->getWebhookUpdates();

            $message = $request->getMessage();
            if (!$message) {
                throw WebhookException::requestEmpty();
            }

            $text = $message->getText();
            $from = $message->getFrom();

            if (!$from) {
                throw WebhookException::requestMalformed('`from` array empty', $request);
            }
            $fromId = $from->getId();

            $text = $this->parsePassword($text);

            if ($text == '/start') {
                return $this->telegram->sendMessage($fromId, $this->getWelcomeTextResponse());
            } elseif ($text == '/stop') {
                return;
            } elseif (!$text) {
                return $this->telegram->sendMessage($fromId, $this->getEmptyTextReceivedResponse());
            }

            if ($this->password) {
                $text = $this->crypt->encrypt($this->password, $text);
            }

            $this->secu->store([
                'text' => $text,
            ]);
            $url = sprintf('%s/%s', env('APP_URL'), $this->secu->getHash());

            return $this->telegram->sendMessage($fromId, $this->getSuccessTextResponse($url));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Generate bot welcome text.
     *
     * @return string
     */
    private function getWelcomeTextResponse()
    {
        return File::get(resource_path('views/bot/welcome.md'));
    }

    /**
     * Generate bot received empty text.
     *
     * @return string
     */
    private function getEmptyTextReceivedResponse()
    {
        return File::get(resource_path('views/bot/empty-text-received.md'));
    }

    /**
     * Generate bot success proceed message.
     *
     * @param $url
     * @return string
     */
    private function getSuccessTextResponse($url)
    {
        $file = File::get(resource_path('views/bot/success-text.md'));

        return sprintf($file, $url);
    }

    /**
     * Try to find password set in message string.
     *
     * @param string $text
     * @return string
     */
    private function parsePassword($text)
    {
        $pattern = '/^(\/p)\s+(\S+)\s+(.+)$/';
        $subject = ltrim($text);
        preg_match($pattern, $subject, $matches);
        if (isset($matches[1], $matches[2], $matches[3])) {
            $this->password = $matches[2];
            $text = $matches[3];
        }

        return $text;
    }
}
