<?php

Route::group(['prefix' => 'v1', 'middleware' => 'cors'], function(){

    Route::post('/user/register', 'AuthController@register');

    Route::post('/user/login', 'AuthController@login');

    Route::post('/user/recover', 'AuthController@recover');

    Route::resource('/situation', 'SituationController', [
        'only' => ['index', 'show']
    ]);
});

Route::group(['prefix' => 'v1', 'middleware' =>  ['jwt.auth','cors']], function(){

    Route::get('/user/logout', 'AuthController@logout');

    Route::resource('/user/comment', 'CommentController', [
        'only' => ['store', 'destroy', 'update']
    ]);

    Route::get('/users', [
        'uses' => 'UserController@index'
    ]);

    Route::resource('/user/situation', 'UserSituationController', [
        'except' => ['create', 'edit']
    ]);

});

