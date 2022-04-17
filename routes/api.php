<?php

declare(strict_types=1);

use App\Http\Api\Bot;
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

Route::options(
    's/',
    S\Options\Action::class
)->name('secu.options');

Route::post(
    's/',
    S\Post\Action::class
)->name('secu.store');

Route::get(
    's/{hash}',
    S\Get\Action::class
)->name('secu.show');


Route::options(
    'feedback',
    Feedback\Options\Action::class
)->name('feedback.options');

Route::post(
    'feedback',
    Feedback\Post\Action::class
)->name('feedback.store');


Route::get(
    'stat',
    Stat\Collect\Action::class
)->name('stat.index');


Route::post(
    'bot/telegram/{token}',
    Bot\Telegram\Action::class
)->name('bot.telegram.listen');
