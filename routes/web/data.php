<?php

/*
*   prefix:data
*   namespace: Data
*/
use App\Http\Controllers\Data\Users\UsersController;

Route::prefix('users')->namespace('Users')->group(function(){
    Route::get('/', [UsersController::class,'index']);
    Route::post('/',[UsersController::class,'store']);
    Route::delete('/{user}',[UsersController::class,'delete']);
    Route::put('{user}',[UsersController::class,'update']);
});