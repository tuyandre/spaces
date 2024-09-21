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

    Route::get('/bookings', [App\Http\Controllers\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [App\Http\Controllers\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/cancel', [App\Http\Controllers\BookingController::class, 'cancelBooking'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/checkout', [App\Http\Controllers\BookingController::class, 'checkout'])->name('bookings.checkout');
    Route::delete('/bookings/{booking}/destroy', [App\Http\Controllers\BookingController::class, 'destroy'])->name('bookings.destroy');

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
    // rooms
    Route::group(["prefix" => "rooms", "as" => "rooms."], function () {
        Route::get('/', [App\Http\Controllers\RoomController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\RoomController::class, 'store'])->name('store');
        Route::get('/{room}', [App\Http\Controllers\RoomController::class, 'show'])->name('show');
        Route::get('/{room}/details', [App\Http\Controllers\RoomController::class, 'details'])->name('details');
        Route::delete('/{room}', [App\Http\Controllers\RoomController::class, 'destroy'])->name('destroy');

        Route::get('/types/index', [App\Http\Controllers\RoomTypeController::class, 'index'])->name('types.index');
        Route::get('/types/{roomType}/show', [App\Http\Controllers\RoomTypeController::class, 'show'])->name('types.show');
        Route::post('/types/store', [App\Http\Controllers\RoomTypeController::class, 'store'])->name('types.store');
        Route::delete('/types/{roomType}/destroy', [App\Http\Controllers\RoomTypeController::class, 'destroy'])->name('types.destroy');

        Route::get('/{room}/maintenances', [App\Http\Controllers\RoomMaintenanceController::class, 'index'])->name('maintenances.index');
        Route::post('/{room}/maintenances', [App\Http\Controllers\RoomMaintenanceController::class, 'store'])->name('maintenances.store');
        Route::post('/maintenances/{maintenance}/complete', [App\Http\Controllers\RoomMaintenanceController::class, 'complete'])->name('maintenances.complete');
        Route::delete('/maintenances/{maintenance}', [App\Http\Controllers\RoomMaintenanceController::class, 'destroy'])->name('maintenances.destroy');

    });

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');


});
