<?php

use App\Http\Middleware\LoggedUser;
use App\Http\Middleware\NeedUserInfo;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\InsertedUserInfo;

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome')->middleware(LoggedUser::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::middleware(NeedUserInfo::class)->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
        Route::get('blogs' , [BlogController::class , 'index'])->name('blogs.all');
    });
    Route::middleware(InsertedUserInfo::class)->group(function() {
        Route::get('additional/information', [UserController::class, 'info'])->name('user.info');
        Route::post('add/additional/info', [UserController::class, "addInfo"])->name('add.information');
    });
});






