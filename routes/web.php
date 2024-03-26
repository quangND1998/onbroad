<?php

use App\Http\Controllers\AuthShopifyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('authenticate', [AuthShopifyController::class,'auth']);
