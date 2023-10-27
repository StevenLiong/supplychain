<?php

use App\Models\logistic\Supplier;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logistic\BpnbController;
use App\Http\Controllers\logistic\IncomingController;
use App\Http\Controllers\logistic\MaterialController;
use App\Http\Controllers\logistic\RakController;
use App\Http\Controllers\logistic\StorageController;
use App\Http\Controllers\logistic\SupplierController;

Route::get('/', function () {
    return view('index');
});

// Logistic
route::get('/logistic', function () {
    return view('logistic.dashboard.index');
});

// master data
// material
route::resource('datamaster/material', MaterialController::class);
Route::get('datamaster/material/print/{id}', [MaterialController::class, 'print']);
// material end

// supplier
Route::resource('datamaster/supplier', SupplierController::class);
// supplier end

// rak
Route::resource('datamaster/rak', RakController::class);
Route::get('datamaster/rak/print/{id}', [RakController::class, 'print']);
// rak end


// receiving
Route::resource('receiving/incoming', IncomingController::class);
Route::get('receiving/incoming/print/{id}', [IncomingController::class, 'print']);
Route::get('receiving/incoming/scan', [IncomingController::class, 'scan']);

// BPNB
route::resource('receiving/bpnb', BpnbController::class); // BPNB
Route::get('receiving/incoming/{bpnb}/scan', [BpnbController::class, 'print']);
// BPNB end

//storage
Route::resource('storage/rawmaterial', StorageController::class);


// rute tambahan untuk "Put Away" dan "Rack Checking":
Route::get('storage/scan', [StorageController::class, 'scan']);
Route::get('storage/rackchecking', [StorageController::class, 'rackchecking']);


// logistic end
