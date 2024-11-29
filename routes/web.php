<?php

use App\Http\Controllers\Iclock;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/iclock/cdata', [Iclock::class, 'cdata']);
Route::get('/iclock/cdata', [Iclock::class, 'GetCdata']);
Route::get('/iclock/getrequest', [Iclock::class, 'GetRequest']);
