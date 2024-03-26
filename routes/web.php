<?php

use App\Http\Controllers\InstalllAppController;
use Illuminate\Support\Facades\Route;

Route::prefix('shopify/auth')->group(function () {
    Route::get('/', [InstalllAppController::class, 'startInstallApp']);

    Route::get('redirect', [InstalllAppController::class, 'handleRedirect'])->name('app_install_redirect');
});

Route::middleware(['auth'])->group(
    function () {
      
        
    }
);
Route::get('/home', function(){
    return view('app');
})->name('home');
Route::get('/login', function(){
    return view('login');
})->name('login');



