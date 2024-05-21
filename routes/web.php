<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\runnerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
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

Route::get('/runnerregistered', function () {
    return view('auth.runnerregistered');
})->name('runnerregistered');

Route::get('/requestdelivery', function () {
    return view('RequestDelivery.requestdelivery');
})->name('requestdelivery');

Route::get('/requested', function () {
    return view('RequestDelivery.requested');
})->name('requested');

Route::get('/runnerapproval', function () {
    return view('auth.runnerapproval');
})->name('runnerapproval');

Route::controller(App\Http\Controllers\DeliveryController::class)->group(function(){
    Route::post('/requestdelivery','store')->name('requestdelivery');
});

Route::post('/runnerregistration', [runnerController::class, 'storerunner'])->name('runnerregistration');
Route::get('/check-delivery-request', [DeliveryController::class, 'hasDeliveryRequest']);
Route::get('/fetch-coordinates', [DeliveryController::class, 'showLocation'])->name('fetch-coordinates');
Route::delete('/canceldelivery', [DeliveryController::class, 'cancelDelivery'])->name('canceldelivery');
Route::get('/deliverystatus', [DeliveryController::class, 'status'])->name('deliverystatus');
Route::get('/approval', [runnerController::class, 'approval'])->name('approval');
Route::get('/check-runner-registration', [runnerController::class, 'hasRunnerRegistration']);
Route::delete('/cancelregistration', [RunnerController::class, 'cancelregistration'])->name('cancelregistration');
Route::get('/listcustomer', [RegisteredUserController::class, 'listcustomer'])->name('listcustomer');
Route::get('/listrunnerregistration', [runnerController::class, 'listrunnerregistration'])->name('listrunnerregistration');
Route::get('/runnerapproval/{id}', [runnerController::class, 'showRunnerRegistration'])->name('runnerapproval');

require __DIR__.'/auth.php';
