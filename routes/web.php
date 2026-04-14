<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/devices');
});

Route::resource('devices', App\Http\Controllers\DeviceController::class);
