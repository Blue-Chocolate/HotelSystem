<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminRevenueController;
use App\Http\Controllers\Admin\AdminRoomController;
use App\Http\Controllers\Admin\AdminGuestController;
use App\Http\Controllers\GuestController\RoomController;
use App\Http\Controllers\GuestController\ReservationController;
use App\Http\Controllers\ProfileController;
Route::get('ping', fn() => response()->json(['pong'=>true]));

require __DIR__.'/auth.php';

Route::get('/', fn() => redirect()->route('login'))->middleware('guest');

// Guest Routes
Route::name('guest.')->group(function() {
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
});

Route::prefix('admin')->middleware(['auth','role:admin'])->name('admin.')->group(function(){
    Route::get('dashboard', [AdminDashboardController::class,'index'])->name('dashboard');
    Route::get('welcome',   [AdminDashboardController::class,'welcome'])->name('welcome');

    Route::get('reserve',                 [AdminReservationController::class,'index'])->name('reserve.index');
    Route::get('reserve/create',          [AdminReservationController::class,'create'])->name('reserve.create');
    Route::post('reserve',                [AdminReservationController::class,'store'])->name('reserve.store');
    Route::get('reserve/{reservation}/edit',[AdminReservationController::class,'edit'])->name('reserve.edit');
    Route::put('reserve/{reservation}',   [AdminReservationController::class,'update'])->name('reserve.update');
    Route::delete('reserve/{reservation}',[AdminReservationController::class,'destroy'])->name('reserve.destroy');

    Route::get('guests',  [AdminGuestController::class,'index'])->name('guests.index');
    Route::get('rooms',   [AdminRoomController::class,'index'])->name('rooms.index');
    Route::get('revenue', [AdminRevenueController::class,'index'])->name('revenue.index');
    Route::resource('admin/rooms', AdminRoomController::class);
    Route::get('rooms/{room}/edit', [AdminRoomController::class,'edit'])->name('rooms.edit');
    Route::put('rooms/{room}', [AdminRoomController::class,'update'])->name('rooms.update');
    Route::delete('rooms/{room}', [AdminRoomController::class,'destroy'])->name('rooms.destroy');
    Route::get('rooms/create', [AdminRoomController::class,'create'])->name('rooms.create');
    Route::post('rooms', [AdminRoomController::class,'store'])->name('rooms.store');

});

// Authenticated user (Blade)
Route::middleware('auth')->group(function(){
    // Profile
    Route::get('profile', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('profile',[ProfileController::class,'update'])->name('profile.update');
    Route::delete('profile',[ProfileController::class,'destroy'])->name('profile.destroy');

    // Guest booking
    Route::get('home', fn() => Auth::user()->hasRole('admin')
        ? redirect()->route('admin.dashboard')
        : redirect()->route('rooms.index')
    )->name('home');

    Route::get('rooms',              [RoomController::class,'index'])->name('rooms.index');
    Route::get('rooms/{room}',       [RoomController::class,'show'])->name('rooms.show');
    Route::get('booking/{room}',     [ReservationController::class,'create'])->name('booking.create');
    Route::post('booking/{room}',    [ReservationController::class,'store'])->name('booking.store');
    Route::get('my-reservations',    [ReservationController::class,'myReservations'])->name('booking.my-reservations');
    Route::delete('reservations/{reservation}/cancel',
                                      [ReservationController::class,'cancel'])->name('booking.cancel');
});
Route::get('/rooms/{room}/calendar', [\App\Http\Controllers\GuestController\ReservationController::class, 'calendarData'])->name('rooms.calendar');
