<?php

use App\Models\logistic\Supplier;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logistic\BpnbController;
use App\Http\Controllers\logistic\IncomingController;
use App\Http\Controllers\logistic\MaterialController;
use App\Http\Controllers\logistic\SupplierController;

Route::get('/', function () {
    return view('index');
});

// Logistic
route::get('/logistic', function(){
    return view('logistic.dashboard.index');
});

// master data
route::resource('datamaster/material', MaterialController::class);
Route::resource('datamaster/supplier', SupplierController::class); 


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
// route::resource('receiving/incoming', IncomingController::class); //incoming
Route::get('receiving/incoming', [IncomingController::class,'index']);
Route::get('receiving/incoming/print', [IncomingController::class, 'print']);

// logistic end




