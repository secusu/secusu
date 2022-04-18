<?php

declare(strict_types=1);

use App\Http\Api\BotTelegram;
use App\Http\Api\Feedback;
use App\Http\Api\S;
use App\Http\Api\Stat;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::redirect(
    '/',
    config('app.web_url')
);

Route::options(
    's/',
    S\OptionsSController::class
)->name('secu.options');

Route::post(
    's/',
    S\PostSController::class
)->name('secu.store');

Route::get(
    's/{hash}',
    S\GetSController::class
)->name('secu.show');


Route::options(
    'feedback',
    Feedback\OptionsFeedbackController::class
)->name('feedback.options');

Route::post(
    'feedback',
    Feedback\PostFeedbackController::class
)->name('feedback.store');


Route::get(
    'stat',
    Stat\GetStatController::class
)->name('stat.index');


Route::post(
    'bot/telegram/{token}',
    BotTelegram\BotTelegramController::class
)->name('bot.telegram.listen');
