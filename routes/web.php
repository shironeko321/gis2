<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\UserController;
use App\Models\Map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return view('welcome', ['markers' => Map::with(['image', 'detail'])->get()]);
});


// dashboard
Route::prefix('dashboard')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');

    Route::middleware(['auth'])->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('category', CategoryController::class);
        Route::resource('user', UserController::class);
        Route::resource('map', MapController::class);

        Route::delete('/map/image/{id}', [MapController::class, 'deleteImage'])->name('map.deleteImage');
    });
});
