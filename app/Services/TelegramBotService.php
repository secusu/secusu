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

use Telegram\Bot\Api;

/**
 * Class TelegramBotService.
 * @package App\Services
 */
class TelegramBotService
{
    /**
     * @var Api
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
     * @param $text
     * @param bool $disablePreview
     * @return \Telegram\Bot\Objects\Message
     */
    public function sendMessage($chatId, $text, $disablePreview = true)
    {
        $response = $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'Markdown',
            'disable_web_page_preview' => $disablePreview,
        ]);

        return $response;
    }

    public function getWebhookUpdates()
    {
        return $this->telegram->getWebhookUpdates();
    }
}
