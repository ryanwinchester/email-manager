<?php

Route::group(['middleware' => ['web']], function () {
    // Auth
    Route::auth();

    // Home
    Route::get('/', 'HomeController@index');

    // Email
    Route::post('email', [
        'uses' => 'EmailController@email',
        'as' => 'email',
    ]);
    Route::get('email/{email}', [
        'uses' => 'EmailController@status',
        'as' => 'email.status',
    ]);
    Route::patch('email/{email}/change', [
        'uses' => 'EmailController@change',
        'as' => 'email.change',
    ]);
    Route::patch('email/{email}/unsubscribe', [
        'uses' => 'EmailController@unsubscribe',
        'as' => 'email.unsubscribe',
    ]);
});
