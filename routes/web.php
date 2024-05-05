<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/runnerregister', function () {
    return view('auth.runnerregister');
})->name('runnerregister');

Route::get('/requestdelivery', function () {
    return view('RequestDelivery.requestdelivery');
})->name('requestdelivery');

Route::get('/requested', function () {
    return view('RequestDelivery.requested');
})->name('requested');

Route::controller(App\Http\Controllers\deliveryController::class)->group(function(){
    Route::post('/requestdelivery','store')->name('requestdelivery');
});

require __DIR__.'/auth.php';
