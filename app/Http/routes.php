<?php

Route::group(['middleware' => ['web']], function () {
    Route::auth();

    Route::get('/', 'HomeController@index');

    Route::get('status/{email}', 'EmailController@status');
});
