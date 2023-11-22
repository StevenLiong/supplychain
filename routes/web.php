<?php

use App\Models\logistic\Material;
use App\Models\logistic\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\planner\WoController;
use App\Http\Controllers\planner\BomController;
use App\Http\Controllers\planner\MpsController;
use App\Http\Controllers\logistic\RakController;
use App\Http\Controllers\logistic\BpnbController;
use App\Http\Controllers\logistic\ScanController;
use App\Http\Controllers\planner\GPADryController;
use App\Http\Controllers\logistic\StorageController;
use App\Http\Controllers\logistic\IncomingController;
use App\Http\Controllers\logistic\MaterialController;
use App\Http\Controllers\logistic\SupplierController;
<<<<<<< HEAD
use App\Http\Controllers\logistic\MaterialRakController;
use App\Http\Controllers\logistic\ServicesController;
use App\Http\Controllers\planner\BomController;
=======
>>>>>>> 80bc89722793100dcb8378874e4952d7c338c6ee
use App\Http\Controllers\planner\DetailbomController;
use App\Http\Controllers\logistic\MaterialRakController;
use App\Http\Controllers\produksi\DryCastResinController;
use App\Http\Controllers\produksi\StandardizeWorkController;
use App\Http\Controllers\produksi\ResourceWorkPlanningController;

// Route::get('/', function () {
//     return view('index');
// });

Auth::routes();
Route::get('/', [loginController::class, 'showLogin'])->name('showlogin');
Route::post('/login', [loginController::class, 'verifyLogin'])->name('login');
Route::post('/logout', [loginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'logistic'])->group(function () {
    Route::get('logistic', [DashboardController::class, 'index']);

    // master data
    // material
    route::resource('datamaster/material', MaterialController::class);
    Route::get('datamaster/material/print/{id}', [MaterialController::class, 'print']);
    Route::get('datamaster/material/addstock/{id}', [MaterialController::class, 'addStock']);
    Route::put('datamaster/material/addstock/{id}', [MaterialController::class, 'updateStock']);
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

    // BPNB
    route::resource('receiving/bpnb', BpnbController::class); // BPNB
    Route::get('receiving/incoming/bpnb/print', [BpnbController::class, 'print']);
    // BPNB end

    //storage index material dan finishgood
    Route::get('storage/rawmaterial', [StorageController::class, 'indexHome']);
    Route::get('storage/finishedgood', [StorageController::class, 'indexFinishedGood']);


    // Scan All
    Route::get('scan/information', [ScanController::class, 'scanInformationMaterial']);
    Route::get('receiving/scan', [ScanController::class, 'receivingScan']);
    Route::get('receiving/scan/stockin', [ScanController::class, 'stockIn']);
    Route::get('scan/stockin/add/{$id}', [MaterialController::class, 'addStock']);
    // rawmat
    Route::get('storage/rawmaterial/scan', [ScanController::class, 'storageScan']);


    // untuk rackchecking
    Route::resource('storage/rawmaterial/listmaterial', MaterialRakController::class);

    Route::get('storage/rawmaterial/listmaterial/addstock/{id}', [MaterialRakController::class, 'addStock']);
    Route::put('storage/rawmaterial/listmaterial/addstock/{id}', [MaterialRakController::class, 'updateStock']);

    // logistic end

});

<<<<<<< HEAD
// Dashboard logistic
Route::get('dashboard', [DashboardController::class, 'index']);

// master data
// material
route::resource('datamaster/material', MaterialController::class);
Route::get('datamaster/material/print/{id}', [MaterialController::class, 'print']);
Route::get('datamaster/material/addstock/{id}', [MaterialController::class, 'addStock']);
Route::put('datamaster/material/addstock/{id}', [MaterialController::class, 'updateStock']);
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

// BPNB
route::resource('receiving/bpnb', BpnbController::class); // BPNB
Route::get('receiving/incoming/bpnb/print', [BpnbController::class, 'print']);
// BPNB end

//storage index material dan finishgood
Route::get('storage/rawmaterial', [StorageController::class, 'indexHome']);
Route::get('storage/finishedgood', [StorageController::class, 'indexFinishedGood']);


// Scan All
Route::get('scan/information', [ScanController::class, 'scanInformationMaterial']);
Route::get('receiving/scan', [ScanController::class, 'receivingScan']);
Route::get('receiving/scan/stockin', [ScanController::class, 'stockIn']);
Route::get('scan/stockin/add/{$id}', [MaterialController::class, 'addStock']);
// rawmat
Route::get('storage/rawmaterial/scan', [ScanController::class, 'storageScan']);


// untuk rackchecking
Route::resource('storage/rawmaterial/listmaterial', MaterialRakController::class);

Route::get('storage/rawmaterial/listmaterial/addstock/{id}', [MaterialRakController::class, 'addStock']);
Route::put('storage/rawmaterial/listmaterial/addstock/{id}', [MaterialRakController::class, 'updateStock']);

// Services index transaksi gudang dan transaksi produksi
Route::get('services/transaksigudang', [ServicesController::class, 'indexGudang']);
Route::get('services/transaksiproduksi', [ServicesController::class, 'indexProduksi']);


// logistic end
=======
>>>>>>> 80bc89722793100dcb8378874e4952d7c338c6ee

// Planner Start

// MENU BOM
Route::get('/BOM/IndexBom', [BomController::class, 'index'])->name('bom-index');

// --CREATE BOM & UPLOAD BOM--
Route::get('/bom/create', [BomController::class, 'create'])->name('bom-create');
Route::post('/bom/store', [BomController::class, 'store'])->name('bom.store');
Route::get('/bom/upload-excel/{idBom}', [DetailbomController::class, 'formUpload'])->name('bom-upload-excel');
Route::post('/bom/upload-excel', [DetailbomController::class, 'upload'])->name('bom-upload-excel-post');

// --EDIT & DETAIL BOM--
Route::get('/BOM/DetailBOM/{id_bom}', [DetailbomController::class, 'bomDetail'])->name('bom.detailbom');
Route::get('/bom/EditBOMInfo/{id_bom}', [DetailbomController::class, 'infoBom'])->name('bom.editbom');
Route::put('/bom/updatebom/{id_bom}', [DetailbomController::class, 'updateBom'])->name('bom.updatebom');

// --EDIT MATERIAL & ADD NEW MATERIAL--
Route::get('/bom/addmaterial/{id_bom}', [DetailbomController::class, 'addmaterial'])->name('bom-addmaterial');
Route::post('/bom/storematerial', [DetailbomController::class, 'storematerial'])->name('bom.storematerial');
Route::get('/bom/editmaterial/{id_materialbom}/{id_bom}', [DetailbomController::class, 'edit'])->name('bom.edit');
Route::put('/bom/updatematerial/{id_materialbom}/{id_bom}', [DetailbomController::class, 'update'])->name('bom.update');

// --DELETE BOM--
Route::delete('/bom/delete/{id_bom}/{id_boms}', [BomController::class, 'destroy'])->name('bom.delete');

// --EXPORT BOM--
Route::get('/bom/download-excel', [BomController::class, 'downloadExcel'])->name('download-excel');

//DELETE MATERIAL & RESTORE MATERIAL
Route::delete('/bommaterial/delete/{id_materialbom}/{id_bom}', [DetailbomController::class, 'deleteMaterial'])->name('bommaterial.delete');
Route::post('/restore-material/{id_materialbom}/{id_bom}', [DetailbomController::class, 'restoreMaterial'])->name('bommaterial.restore');

//SUBMIT MATERIAL (USAGE MATERIAL - JUMLAH)
Route::post('/bom/submit', [DetailbomController::class, 'submit'])->name('bom.submit');

// MENU WORK ORDER
Route::get('/WorkOrder/IndexWorkOrder', [WoController::class, 'index'])->name('workorder-index');

// --CREATE WORK ORDER--
Route::get('/wo/create', [WoController::class, 'create'])->name('wo-create');
Route::post('/wo/store', [WoController::class, 'store'])->name('wo.store');

// --EDIT WORK ORDER--
Route::get('/bom/editWO/{id_wo}', [WoController::class, 'edit'])->name('wo.editwo');
Route::put('/bom/updateWO/{id_wo}', [WoController::class, 'update'])->name('wo.updatewo');

// --EXPORT WORK ORDER--
Route::get('/wo/export/excel', [WoController::class, 'exportToExcel'])->name('wo.exportExcel');
Route::get('/wo/export/pdf', [WoController::class, 'exportToPdf'])->name('wo.exportPdf');

// MENU MPS
Route::get('/MPS/IndexMPS', [MpsController::class, 'index'])->name('mps-index');
// --UPLOAD MPS--
Route::get('/MPS/UploadMPS', [MpsController::class, 'upload'])->name('mps-upload');
Route::post('/MPS/UploadMPS', [MpsController::class, 'store'])->name('mps.store');

// --EXPORT MPS--
Route::get('/MPS/ExportExcel', [MpsController::class, 'exportToExcel'])->name('mps.exportExcel');
Route::get('/MPS/ExportPdf', [MpsController::class, 'exportToPdf'])->name('mps.exportPdf');

// MENU GPA
// --GPA DRY---
Route::get('/GPA/IndexGPA-Dry', [GPADryController::class, 'index'])->name('gpa-indexgpadry');

// --GPA OIL--
Route::get('/GPA/IndexGPA-Oil', [GPADryController::class, 'indexOil'])->name('gpa-indexgpaoil');

// Planner End


Route::middleware(['auth', 'resourceworkplanning'])->group(function () {
    Route::get('/', [ResourceWorkPlanningController::class, 'dashboard']);
    Route::get('resource_work_planning/dashboard', [ResourceWorkPlanningController::class, 'dashboard']);
    Route::get('resource_work_planning/PL2/Work-Load', [ResourceWorkPlanningController::class, 'pl2Workload']);
    Route::get('resource_work_planning/PL2/Rekomendasi', [ResourceWorkPlanningController::class, 'pl2Rekomendasi']);
    Route::get('resource_work_planning/PL2/Jumlah', [ResourceWorkPlanningController::class, 'pl2Jumlah']);
    Route::get('resource_work_planning/PL3/Work-Load', [ResourceWorkPlanningController::class, 'pl3Workload']);
    Route::get('resource_work_planning/PL3/Rekomendasi', [ResourceWorkPlanningController::class, 'pl3Rekomendasi']);
    Route::get('resource_work_planning/PL3/Jumlah', [ResourceWorkPlanningController::class, 'pl3Jumlah']);
    Route::get('resource_work_planning/CT-VT/Work-Load', [ResourceWorkPlanningController::class, 'ctvtWorkload']);
    Route::get('resource_work_planning/CT-VT/Rekomendasi', [ResourceWorkPlanningController::class, 'ctvtRekomendasi']);
    Route::get('resource_work_planning/CT-VT/Jumlah', [ResourceWorkPlanningController::class, 'ctvtJumlah']);
    Route::get('resource_work_planning/Dry/Work-Load', [ResourceWorkPlanningController::class, 'dryWorkload']);
    Route::get('resource_work_planning/Dry/Rekomendasi', [ResourceWorkPlanningController::class, 'dryRekomendasi']);
    Route::get('resource_work_planning/Dry/Jumlah', [ResourceWorkPlanningController::class, 'dryJumlah']);
    Route::get('resource_work_planning/Repair/Work-Load', [ResourceWorkPlanningController::class, 'repairWorkload']);
    Route::get('resource_work_planning/Repair/Rekomendasi', [ResourceWorkPlanningController::class, 'repairRekomendasi']);
    Route::get('resource_work_planning/Repair/Jumlah', [ResourceWorkPlanningController::class, 'repairJumlah']);
    Route::get('resource_work_planning/Kalkulasi-SDM', [ResourceWorkPlanningController::class, 'kalkulasiSDM']);
});


Route::middleware(['auth', 'standardizedwork'])->group(function () {
    Route::get('/', [StandardizeWorkController::class, 'index'])->name('home');
    Route::get('/home', [StandardizeWorkController::class, 'index'])->name('home');
    Route::get('/standardized_work/home', [StandardizeWorkController::class, 'index'])->name('home');
    Route::delete('/standardized_work/{id}', [StandardizeWorkController::class, 'destroy'])->name('delete');

    Route::get('/standardized_work/Create-Data/Dry-Cast-Resin', [DryCastResinController::class, 'create'])->name('create.dryresin');
    Route::get('/standardized_work/Create-Data/Dry-Cast-Resin/kapasitas/{id}', [DryCastResinController::class, 'createManhour'])->name('create.dryresin.createManhour');
    Route::post('/standardized_work/Create-Data/Dry-Cast-Resin/Store', [DryCastResinController::class, 'store'])->name('store.dryresin');
    Route::get('/standardized_work/Create-Data/Dry-Cast-Resin/{id}/edit', [DryCastResinController::class, 'edit'])->name('dryresin.edit');
    Route::put('/standardized_work/Create-Data/Dry-Cast-Resin/{id}', [DryCastResinController::class, 'update'])->name('dryresin.update');

    Route::get('/standardized_work/Create-Data/Dry-Non-Resin', [DryNonResinController::class, 'create'])->name('create.drynonresin');
    Route::get('/standardized_work/Create-Data/Dry-Non-Resin/kapasitas/{id}', [DryNonResinController::class, 'createManhour'])->name('create.drynonresin.createManhour');
    Route::post('/standardized_work/Create-Data/Dry-Non-Resin/Store', [DryNonResinController::class, 'store'])->name('store.drynonresin');
    Route::get('/standardized_work/Create-Data/Dry-Non-Resin/{id}/edit', [DryNonResinController::class, 'edit'])->name('drynonresin.edit');
    Route::put('/standardized_work/Create-Data/Dry-Non-Resin/{id}', [DryNonResinController::class, 'update'])->name('drynonresin.update');


});



Route::middleware(['auth', 'materialrequest'])->group(function () {
    Route::get('/', [StandardizeWorkController::class, 'index'])->name('home');
});

Route::middleware(['auth', 'purchaseorder'])->group(function () {
    Route::get('/', [StandardizeWorkController::class, 'index'])->name('home');
    Route::get('/home', [StandardizeWorkController::class, 'index'])->name('home');
    Route::get('/', [StandardizeWorkController::class, 'index'])->name('home');
});

