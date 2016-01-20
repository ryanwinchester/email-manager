<?php

Route::group(['middleware' => ['web']], function () {
    Route::auth();

    Route::get('/', 'HomeController@index');

    Route::post('status', [
        'uses' => 'EmailController@status',
        'as' => 'email.check',
    ]);
    Route::get('status/{email}', [
        'uses' => 'EmailController@email',
        'as' => 'email.status',
    ]);
    Route::patch('status/{email}/unsubscribe', [
        'uses' => 'EmailController@unsubscribe',
        'as' => 'email.unsubscribe',
    ]);
});
