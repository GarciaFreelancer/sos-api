<?php

Route::group(['prefix' => 'v1', 'middleware' => 'cors'], function(){

    Route::post('/user/register', 'AuthController@register');

    Route::post('/user/login', 'AuthController@login');

    Route::post('/user/recover', 'AuthController@recover');
});

Route::group(['prefix' => 'v1', 'middleware' =>  ['jwt.auth','cors']], function(){

    Route::get('/user/logout', 'AuthController@logout');

    Route::resource('situation', 'SituationController', [
        'except' => ['create', 'edit']
    ]);

    Route::resource('comment', 'CommentController', [
        'only' => ['store', 'destroy', 'update']
    ]);

});
