<?php

use App\Http\Middleware\PasswordChanged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth', PasswordChanged::class], 'prefix' => '/admin', 'as' => 'admin.'], function () {

    Route::group(["prefix" => "settings", "as" => "settings."], function () {

        Route::get('/roles', [App\Http\Controllers\RolesController::class, 'index'])->name('roles.index');
        Route::post('/roles', [App\Http\Controllers\RolesController::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}', [App\Http\Controllers\RolesController::class, 'show'])->name('roles.show');
        Route::delete('/roles/{role}', [App\Http\Controllers\RolesController::class, 'destroy'])->name('roles.destroy');


        Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users.index');
        Route::post('/users', [App\Http\Controllers\UsersController::class, 'store'])->name('users.store');
        Route::post('/users/{user}/toggle-activate', [App\Http\Controllers\UsersController::class, 'toggleActive'])->name('users.active-toggle');
        Route::delete('/users/{user}', [App\Http\Controllers\UsersController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/{user}', [App\Http\Controllers\UsersController::class, 'show'])->name('users.show');

        Route::get('/permissions', [App\Http\Controllers\PermissionsController::class, 'index'])->name('permissions.index');

    });

    Route::group(["prefix" => "buildings", "as" => "buildings."], function () {
        Route::get('/', [App\Http\Controllers\BuildingController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\BuildingController::class, 'store'])->name('store');
        Route::get('/{building}', [App\Http\Controllers\BuildingController::class, 'show'])->name('show');
        Route::delete('/{building}', [App\Http\Controllers\BuildingController::class, 'destroy'])->name('destroy');

        Route::get('/types/index', [App\Http\Controllers\BuildingTypeController::class, 'index'])->name('types.index');
        Route::get('/types/{buildingType}/show', [App\Http\Controllers\BuildingTypeController::class, 'show'])->name('types.show');
        Route::post('/types/store', [App\Http\Controllers\BuildingTypeController::class, 'store'])->name('types.store');
        Route::delete('/types/{buildingType}/destroy', [App\Http\Controllers\BuildingTypeController::class, 'destroy'])->name('types.destroy');


    });

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');


});
