<?php

use App\Http\Controllers\Api\CreateUser;
use App\Http\Controllers\Api\UpdateUser;
use App\Http\Controllers\DeleteUser;
use App\Http\Controllers\DetailUser;
use App\Http\Controllers\FetchUsers;
use App\Http\Controllers\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->as('v1.')->group(function () {
    Route::get('/listUser', FetchUsers::class);
    Route::post('/createUser', CreateUser::class);
    Route::get('/{user}/userDetail', UserDetail::class);
    Route::put('/{user}/updateUser', UpdateUser::class);
    Route::delete('/{user}/deleteUser', DeleteUser::class);
});
