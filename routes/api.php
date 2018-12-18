<?php

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

Route::group(['prefix' => 's', 'as' => 'secu.'], function () {
    Route::options('/', ['as' => 'options'])
        ->uses('S\Options\Action');

    Route::post('/', ['as' => 'store'])
        ->uses('S\Post\Action');

    Route::get('{hash}', ['as' => 'show'])
        ->uses('S\Get\Action');
});


Route::options('feedback', ['as' => 'feedback.options'])
    ->uses('Feedback\Options\Action');

Route::post('feedback', ['as' => 'feedback.store'])
    ->uses('Feedback\Post\Action');


Route::get('stat', ['as' => 'stat.index'])
    ->uses('Stat\Collect\Action');


Route::post('bot/telegram/{token}', ['as' => 'bot.telegram.listen'])
    ->uses('Bot\Telegram\Action');
