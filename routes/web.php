<?php

use App\Http\Controllers\logistic\BpnbController;
use App\Http\Controllers\logistic\IncomingController;
use App\Http\Controllers\logistic\MaterialController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// Logistic
route::get('/logistic', function(){
    return view('logistic.dashboard.index');
});

// master material
route::resource('material', MaterialController::class);

Route::get('drytype', function(){
    return view ('logistic.dataMaster.drytype');
});

Route::get('ctvt', function(){
    return view ('logistic.dataMaster.ctvt');
});

Route::get('oil', function(){
    return view ('logistic.dataMaster.oil');
});


route::resource('bpnb', BpnbController::class); // BPNB
route::resource('incoming', IncomingController::class); //incoming
// logistic end




