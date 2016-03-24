<?php

Route::group(['middleware' => ['api', 'cors']], function () {
    Route::group(['prefix' => 's', 'as' => 'secu.'], function () {
        Route::options('/', ['as' => 'options', 'uses' => 'Api\V1\SecuController@options']);

        Route::post('/', ['as' => 'store', 'uses' => 'Api\V1\SecuController@store']);
        Route::get('{hash}', ['as' => 'show', 'uses' => 'Api\V1\SecuController@show']);
    });

    Route::options('feedback', ['as' => 'feedback.options', 'uses' => 'Api\V1\FeedbackController@options']);
    Route::post('feedback', ['as' => 'feedback.store', 'uses' => 'Api\V1\FeedbackController@store']);
});

Route::group(['middleware' => ['web']], function () {
    //
});
