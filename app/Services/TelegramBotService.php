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

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

final class TelegramBotService
{
    /**
     * @var \Telegram\Bot\Api
     */
    private $telegram;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    /**
     * Send message to user.
     *
     * @param $chatId
     * @param string  $text
     * @param bool $disablePreview
     * @return \Telegram\Bot\Objects\Message
     */
    public function sendMessage($chatId, string $text, bool $disablePreview = true): Message
    {
        $response = $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'Markdown',
            'disable_web_page_preview' => $disablePreview,
        ]);

        return $response;
    }

    public function getWebhookUpdates(): Update
    {
        return $this->telegram->getWebhookUpdates();
    }
}
