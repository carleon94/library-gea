<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ( $router ) {
    Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');
    Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [\App\Http\Controllers\Api\AuthController::class, 'refresh'])->name('refresh');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'book'
], function ( $router ) {
    Route::get('', [\App\Http\Controllers\Api\BookController::class, 'index'])->name('book.index');
    Route::get('create', [\App\Http\Controllers\Api\BookController::class, 'create'])->name('book.create');
    Route::get('{id}', [\App\Http\Controllers\Api\BookController::class, 'show'])->name('book.show');
    Route::post('', [\App\Http\Controllers\Api\BookController::class, 'store'])->name('book.store');
    Route::put('{id}', [\App\Http\Controllers\Api\BookController::class, 'update'])->name('book.update');
    Route::delete('{id}', [\App\Http\Controllers\Api\BookController::class, 'destroy'])->name('book.delete');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'book'
], function ( $router ) {
    Route::post('rent', [\App\Http\Controllers\Api\RentBookController::class, 'store'])->name('book.rent');
});