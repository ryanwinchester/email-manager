<?php

Route::group(['middleware' => ['web']], function () {
    Route::auth();

    Route::group(['middleware' => ['auth']], function () {
        // Home
        Route::get('/', [
            'uses' => 'HomeController@index',
            'as' => 'home',
        ]);
        // Email
        Route::post('email', [
            'uses' => 'EmailController@email',
            'as'   => 'email',
        ]);
        Route::get('email/{email}', [
            'uses' => 'EmailController@status',
            'as'   => 'email.status',
        ]);
        Route::patch('email/{email}/change', [
            'uses' => 'EmailController@change',
            'as'   => 'email.change',
        ]);
        Route::patch('email/{email}/unsubscribe', [
            'uses' => 'EmailController@unsubscribe',
            'as'   => 'email.unsubscribe',
        ]);
        Route::patch('name/{email}/change', [
            'uses' => 'EmailController@changeName',
            'as'   => 'name.change',
        ]);
    });
});
