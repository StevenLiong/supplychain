<?php

use App\Models\logistic\Supplier;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logistic\BpnbController;
use App\Http\Controllers\logistic\IncomingController;
use App\Http\Controllers\logistic\MaterialController;
use App\Http\Controllers\logistic\MaterialRakController;
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
Route::get('receiving/incoming/scan/find', [IncomingController::class, 'scan']);

// BPNB
route::resource('receiving/bpnb', BpnbController::class); // BPNB
// Route::get('receiving/incoming/{bpnb}/scan', [BpnbController::class, 'print']);
// BPNB end

//storage index
Route::get('storage/rawmaterial', [StorageController::class, 'indexHome']);

// storage rak checking dan scan
// Route::get('storage/rawmaterial/list', [StorageController::class, 'indexMaterial']);
// Route::get('storage/rawmaterial/list/create', [StorageController::class, 'createMaterial']);
// Route::post('storage/rawmaterial/list/add', [StorageController::class, 'storeMaterial'])->name('add-material-to-rak');
// Route::get('storage/rawmaterial/list/{id}/edit', [StorageController::class, 'editMaterial']);
// Route::put('storage/rawmaterial/list/{id}', [StorageController::class, 'updateMaterialRak']);
// Route::get('storage/scan', [StorageController::class, 'scan']);


Route::resource('storage/listmaterial', MaterialRakController::class);




// logistic end
