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

namespace App\Http\Api\BotTelegram;

use App\Exceptions\Telegram\WebhookException;
use App\Repositories\Secu\SecuRepository;
use App\Services\CryptService;
use App\Services\TelegramBotService;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

use function env;
use function resource_path;

class BotTelegramController
{
    private SecuRepository $secu;

    private TelegramBotService $telegram;

    private CryptService $crypt;

    private ?string $password;

    public function __construct(
        SecuRepository $secu,
        TelegramBotService $telegram,
        CryptService $crypt
    ) {
        $this->secu = $secu;
        $this->telegram = $telegram;
        $this->crypt = $crypt;
    }

    /**
     * Bot listener.
     *
     * @param string $token
     * @return \Telegram\Bot\Objects\Message
     */
    public function __invoke(string $token)
    {
        try {
            if ($token !== env('TELEGRAM_BOT_WEBHOOK_TOKEN')) {
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

            if (!$text) {
                return $this->telegram->sendMessage($fromId, $this->getEmptyTextReceivedResponse());
            }

            if ($text === '/stop') {
                // TODO: Should return Message
                return;
            }

            if ($text === '/start') {
                return $this->telegram->sendMessage($fromId, $this->getWelcomeTextResponse());
            }

            if ($this->password) {
                $text = $this->crypt->encrypt($this->password, $text);
            }

            $this->secu->store([
                'text' => $text,
            ]);
            // TODO: Use `config` instead of `env`
            $url = sprintf('%s/%s', env('APP_URL'), $this->secu->getHash());

            return $this->telegram->sendMessage($fromId, $this->getSuccessTextResponse($url));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            // TODO: Return Message that error has happened
        }
    }

    /**
     * Generate bot welcome text.
     */
    private function getWelcomeTextResponse(): string
    {
        return File::get(resource_path('views/bot/welcome.md'));
    }

    /**
     * Generate bot received empty text.
     */
    private function getEmptyTextReceivedResponse(): string
    {
        return File::get(resource_path('views/bot/empty-text-received.md'));
    }

    /**
     * Generate bot success proceed message.
     */
    private function getSuccessTextResponse(string $url): string
    {
        $file = File::get(resource_path('views/bot/success-text.md'));

        return sprintf($file, $url);
    }

    /**
     * Try to find password set in message string.
     */
    private function parsePassword(string $text): string
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
