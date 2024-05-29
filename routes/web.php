<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\runnerController;
use App\Http\Controllers\PaymentController;
use App\Models\delivery;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/runnerdashboard', function () {
    return view('runnerdashboard');
})->middleware(['auth', 'verified'])->name('runnerdashboard');

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

Route::get('/runnerapproval', function () {
    return view('auth.runnerapproval');
})->name('runnerapproval');

Route::get('/approvedrunner', function () {
    return view('auth.approvedrunner');
})->name('approvedrunner');


Route::post('/requestdelivery', [DeliveryController::class, 'store'])->name('requestdelivery');
Route::post('/runnerregistration', [runnerController::class, 'storerunner'])->name('runnerregistration');
Route::get('/check-delivery-request', [DeliveryController::class, 'hasDeliveryRequest']);
Route::get('/fetch-coordinates', [DeliveryController::class, 'showLocation'])->name('fetch-coordinates');
Route::delete('/canceldelivery', [DeliveryController::class, 'cancelDelivery'])->name('canceldelivery');
Route::get('/deliverystatus', [DeliveryController::class, 'status'])->name('deliverystatus');
Route::get('/approval', [runnerController::class, 'approval'])->name('approval');
Route::get('/check-runner-registration', [runnerController::class, 'hasRunnerRegistration']);
Route::delete('/cancelregistration', [RunnerController::class, 'cancelregistration'])->name('cancelregistration');
Route::get('/listcustomer', [RegisteredUserController::class, 'listcustomer'])->name('listcustomer');
Route::get('/listrunner', [runnerController::class, 'listrunner'])->name('listrunner');
Route::get('/listrunnerregistration', [runnerController::class, 'listrunnerregistration'])->name('listrunnerregistration');
Route::get('/runnerapproval/{id}', [runnerController::class, 'showRunnerRegistration'])->name('runnerapproval');
Route::post('/runnerapproval/{id}', [runnerController::class, 'updateApproval'])->name('runnerapprovalupdate');
Route::get('/approvedrunner/{id}', [RunnerController::class, 'showApprovedRunner'])->name('approvedrunner');
Route::post('/update-status', [RunnerController::class, 'updateStatus'])->name('runner.updateStatus');
Route::get('/runnerdashboard', [RunnerController::class, 'showDashboard'])->name('runnerdashboard');
Route::get('/requestdelivery', [DeliveryController::class, 'showOnlineRunner'])->name('requestdelivery.form');
Route::get('/listdeliveries', [DeliveryController::class, 'listDeliveries'])->name('listdeliveries')->middleware('auth');
Route::get('/acceptdelivery/{id}', [DeliveryController::class, 'acceptDelivery'])->name('acceptdelivery');
Route::post('/deliverystatusupdate/{id}', [DeliveryController::class, 'updateStatus'])->name('deliverystatusupdate');
Route::post('/submitpayment', [PaymentController::class, 'storepayment'])->name('submitpayment');
Route::get('/deliverylist', [DeliveryController::class, 'deliverylist'])->name('deliverylist');
Route::get('/requested/{id}', [DeliveryController::class, 'requested'])->name('requested');

require __DIR__.'/auth.php';
