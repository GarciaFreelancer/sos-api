<?php

Route::group(['prefix' => 'v1', 'middleware' => 'cors'], function(){
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('recover', 'AuthController@recover');
});

Route::group(['prefix' => 'v1', 'middleware' =>  ['jwt.auth','cors']], function(){

    Route::get('logout', 'AuthController@logout');
    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });

    Route::resource('situation', 'SituationController', [
        'except' => ['create', 'edit']
    ]);

    Route::resource('comment', 'CommentController', [
        'only' => ['store', 'destroy', 'update']
    ]);

});

