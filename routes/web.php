<?php

use App\Http\Middleware\LoggedUser;
use Illuminate\Support\Facades\App;
use App\Http\Middleware\NeedUserInfo;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\InsertedUserInfo;

route::get('/', function () {
    return view('hi');
});

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
        Route::resource('blogs', BlogController::class);
        Route::resource('user', UserController::class);
    });
    Route::middleware(InsertedUserInfo::class)->group(function () {
        Route::get('additional/information', [UserController::class, 'info'])->name('user.info');
        Route::post('add/additional/info', [UserController::class, "addInfo"])->name('add.information');
    });
    // Route::
});

Route::get('change', [LanguageController::class, 'change'])->name('lang.change');
