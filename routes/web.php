<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BreweryController;


Route::get('/', function () {
    return view('login');
})->name('login');

// Route::get('login', function () { return view('login'); })->name('login'); Route::post('login', [AuthController::class, 'login']); Route::middleware('auth:api')->group(function () { Route::get('/user', function (Request $request) { return $request->user(); }); Route::get('breweries', [BreweryController::class, 'index']); }); Route::get('breweries-view', function () { return view('breweries'); })->middleware('auth');

// Route::get('/breweries', [BreweryController::class, 'index']);
// Route::get('login', function () {
//     return view('login');
// })->name('login');

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('api/breweries', [BreweryController::class, 'index']);
});

Route::get('breweries-view', function () {
    return view('breweries');
})->middleware('auth');

Route::get('home', function () {
    return view('home');
})->name('home');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');