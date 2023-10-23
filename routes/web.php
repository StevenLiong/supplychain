<?php

use App\Models\logistic\Supplier;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logistic\BpnbController;
use App\Http\Controllers\logistic\IncomingController;
use App\Http\Controllers\logistic\MaterialController;
use App\Http\Controllers\logistic\RakController;
use App\Http\Controllers\logistic\SupplierController;

Route::get('/', function () {
    return view('index');
});

// Logistic
route::get('/logistic', function(){
    return view('logistic.dashboard.index');
});

// master data
// material
route::resource('datamaster/material', MaterialController::class);
Route::get('datamaster/material/print/{id}', [MaterialController::class, 'print']);
// Route::get('datamaster/material/{material}/print/{id}', [MaterialController::class, 'print']);
// material end

Route::resource('datamaster/supplier', SupplierController::class); 
Route::resource('datamaster/rak', RakController::class);


Route::get('datamaster/material/{kd_material}/print', [MaterialController::class, 'print']);


Route::get('datamaster/drytype', function(){
    return view ('logistic.dataMaster.drytype');
});

Route::get('datamaster/ctvt', function(){
    return view ('logistic.dataMaster.ctvt');
});

Route::get('datamaster/oil', function(){
    return view ('logistic.dataMaster.oil');
});

// receiving
route::resource('receiving/bpnb', BpnbController::class); // BPNB
Route::get('receiving/incoming/{bpnb}/scan', [BpnbController::class, 'print']);
Route::get('receiving/incoming', [IncomingController::class,'index']);
Route::get('receiving/incoming/create', [IncomingController::class,'create']);
Route::post('receiving/incoming/store', [IncomingController::class,'store']);
Route::get('receiving/scan', [IncomingController::class, 'scan']);
Route::get('receiving/incoming/print/{id}', [IncomingController::class, 'print']);

// logistic end




