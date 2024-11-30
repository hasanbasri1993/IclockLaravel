<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\iclockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('devices', [DeviceController::class, 'Index'])->name('devices.index');
Route::get('devices/create', [DeviceController::class, 'create'])->name('devices.create');
Route::post('devices/create', [DeviceController::class, 'store'])->name('devices.store');
Route::get('devices/{id}', [DeviceController::class, 'show'])->name('devices.edit');
Route::put('devices/{id}', [DeviceController::class, 'update'])->name('devices.update');
Route::delete('devices/{id}', [DeviceController::class, 'destroy'])->name('devices.destroy');
Route::get('devices-log', [DeviceController::class, 'DeviceLog'])->name('devices.DeviceLog');
Route::get('finger-log', [DeviceController::class, 'FingerLog'])->name('devices.FingerLog');
Route::get('attendance', [DeviceController::class, 'Attendance'])->name('devices.Attendance');

// handshake
Route::get('/iclock/cdata', [iclockController::class, 'handshake']);
// request dari device
Route::post('/iclock/cdata', [iclockController::class, 'receiveRecords']);

Route::get('/iclock/test', [iclockController::class, 'test']);
Route::get('/iclock/getrequest', [iclockController::class, 'getrequest']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
