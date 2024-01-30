<?php

use App\Models\logistic\Material;
use App\Models\logistic\Supplier;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\planner\WoController;
use App\Http\Controllers\planner\BomController;
use App\Http\Controllers\planner\MpsController;
use App\Http\Controllers\logistic\RakController;
use App\Http\Controllers\purchaser\mrController;
use App\Http\Controllers\purchaser\poController;
use App\Http\Controllers\logistic\BpnbController;
use App\Http\Controllers\logistic\ScanController;
use App\Http\Controllers\planner\StockController;
use App\Http\Controllers\logistic\OrderController;
use App\Http\Controllers\planner\GPADryController;
use App\Http\Controllers\planner\GPAOilController;
use App\Http\Controllers\logistic\CuttingController;
use App\Http\Controllers\logistic\PickingController;
use App\Http\Controllers\logistic\StorageController;
use App\Http\Controllers\logistic\IncomingController;
use App\Http\Controllers\logistic\MaterialController;
use App\Http\Controllers\logistic\ServicesController;
use App\Http\Controllers\logistic\ShippingController;
use App\Http\Controllers\logistic\SupplierController;
use App\Http\Controllers\logistic\TransferController;
use App\Http\Controllers\planner\DetailbomController;
use App\Http\Controllers\planner\FinishgoodController;
use App\Http\Controllers\logistic\CycleCountController;
use App\Http\Controllers\logistic\MaterialRakController;
use App\Http\Controllers\produksi\DryNonResinController;
use App\Http\Controllers\logistic\FinishedgoodController;
use App\Http\Controllers\logistic\StokProduksiController;
use App\Http\Controllers\produksi\DryCastResinController;
use App\Http\Controllers\produksi\StandardizeWorkController;
use App\Http\Controllers\planner\WorkcenterDryTypeController;
use App\Http\Controllers\planner\WorkcenterOilTrafoController;
use App\Http\Controllers\produksi\ResourceWorkPlanningController;


Auth::routes();
Route::get('/', [loginController::class, 'showLogin'])->name('showlogin');
Route::post('/login', [loginController::class, 'verifyLogin'])->name('login');
Route::post('/logout', [loginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'logistic'])->group(function () {
    Route::get('logistic', [DashboardController::class, 'index']);
    // Dashboard logistic

    // master data
    // material
    route::resource('datamaster/material', MaterialController::class);
    Route::get('datamaster/material/print/{kd_material}', [MaterialController::class, 'print']);
    Route::get('datamaster/material/addstock/{kd_material}', [MaterialController::class, 'addStock']);
    Route::put('datamaster/material/addstock/{id}', [MaterialController::class, 'updateStock']);
    // material end

    // supplier
    Route::resource('datamaster/supplier', SupplierController::class);
    // supplier end

    // rak
    Route::resource('datamaster/rak', RakController::class);
    Route::get('datamaster/rak/print/{id}', [RakController::class, 'print']);
    // rak end

    // finished good
    Route::resource('datamaster/finishedgood', FinishedgoodController::class);

    // receiving
    Route::resource('receiving/incoming', IncomingController::class);
    Route::get('receiving/incoming/print/{id}', [IncomingController::class, 'print']);

    // BPNB
    route::resource('receiving/bpnb', BpnbController::class); // BPNB
    Route::get('receiving/bpnb/print/{no_bon}', [BpnbController::class, 'print']);
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

    // order
    Route::resource('services/transaksigudang/order', OrderController::class);
    Route::get('services/transaksigudang/order/{nama_workcenter}', [OrderController::class, 'show']);

    // picking
    Route::get('services/transaksigudang/picking/scan', [PickingController::class, 'pickingScan']);
    Route::get('services/transaksigudang/picking/cutstock/{id}', [PickingController::class, 'cutStock']);
    Route::put('services/transaksigudang/picking/cutstock/{id}', [PickingController::class, 'updateStock']);

    // cutting 
    Route::resource('services/transaksigudang/cutting', CuttingController::class);
    Route::get('services/transaksigudang/cutting/{bon_f}', [OrderController::class, 'show']);

    // Transaksi produksi show trasfer material
    Route::get('/services/transaksiproduksi/listpending', [CuttingController::class, 'pendingList']);
    Route::get('/services/transaksiproduksi/listpending/show/{nama_workcenter}', [CuttingController::class, 'showPendingList']);
    Route::get('/services/transaksiproduksi/listpending/cut/{nama_workcenter}', [CuttingController::class, 'cutMaterial']);

    // Transaksi produksi show transfer material
    route::get('/services/transaksiproduksi/transfer', [TransferController::class, 'index']);
    route::get('/services/transaksiproduksi/trasnfer/create', [TransferController::class, 'create']);

    // stok produksi
    Route::resource('/services/transaksiproduksi/stok', StokProduksiController::class);

    route::resource('/services/transaksiproduksi/transfer', TransferController::class);
    route::get('/services/transaksiproduksi/transfer/lacak/{no_bon}', [TransferController::class, 'tracker']);
    route::put('/services/transaksiproduksi/transfer/lacak/update/{no_bon}', [TransferController::class, 'updateStatus']);
    route::post('/services/transaksiproduksi/transfer/lacak/addStock', [TransferController::class, 'addToStock']);


    // Shipping
    Route::get('shipping/createpackinglist', [ShippingController::class, 'indexPack']);
    Route::get('shipping/createpackinglist/create', [ShippingController::class, 'createPack']);
    Route::post('shipping/createpackinglist', [ShippingController::class, 'storePack']);
    Route::get('shipping/createpackinglist/print/id', [ShippingController::class, 'printPack']);
    Route::get('shipping/deliveryreceipt', [ShippingController::class, 'indexDelivery']);
    Route::get('shipping/deliveryreceipt/create', [ShippingController::class, 'createDelivery']);
    Route::post('shipping/deliveryreceipt', [ShippingController::class, 'storeDelivery']);
    Route::get('shipping/deliveryreceipt/print/{no_delivery}', [ShippingController::class, 'printDelivery']);

    // cycle count
    Route::resource('cyclecount', CycleCountController::class);

    // logistic end

});



// Planner Start

Route::middleware(['auth', 'planner'])->group(function () {

    // MENU BOM
    Route::get('/BOM/IndexBom', [BomController::class, 'index'])->name('bom-index');

    // --CREATE BOM & UPLOAD BOM--
    Route::get('/bom/create', [BomController::class, 'create'])->name('bom-create');
    Route::post('/bom/store', [BomController::class, 'store'])->name('bom.store');
    Route::get('/bom/upload-excel/{idBom}', [DetailbomController::class, 'formUpload'])->name('bom-upload-excel');
    Route::post('/bom/upload-excel', [DetailbomController::class, 'upload'])->name('bom-upload-excel-post');

    // --EDIT & DETAIL BOM--
    Route::get('/BOM/DetailBOM/{id_bom}', [DetailbomController::class, 'bomDetail'])->name('bom.detailbom');
    Route::get('/bom/EditBOMInfo/{id_bom}', [BomController::class, 'infoBom'])->name('bom.editbom');
    Route::put('/bom/updatebom/{id_bom}', [BomController::class, 'updateBom'])->name('bom.updatebom');
    Route::get('/DetailBom/cek-material/{idBom}', [DetailbomController::class, 'CekMaterial']);
    // web.php
    Route::get('/DetailBom/get-status-and-keterangan/{id_bom}', 'DetailbomController@ajaxGetStatusAndKeterangan');

    //Route::post('/DetailBom/get-status-and-keterangan/{id_bom}', 'DetailbomController@getStatusAndKeterangan');

    // --EDIT MATERIAL & ADD NEW MATERIAL--
    Route::get('/bom/addmaterial/{id_bom}', [DetailbomController::class, 'addmaterial'])->name('bom-addmaterial');
    Route::post('/bom/storematerial', [DetailbomController::class, 'storematerial'])->name('bom.storematerial');
    Route::get('/bom/editmaterial/{id_materialbom}/{id_bom}', [DetailbomController::class, 'edit'])->name('bom.edit');
    Route::put('/bom/updatematerial/{id_materialbom}/{id_bom}', [DetailbomController::class, 'update'])->name('bom.update');

    // --DELETE BOM--
    Route::delete('/bom/delete/{id_bom}/{id_boms}', [BomController::class, 'destroy'])->name('bom.delete');

    // --EXPORT BOM--
    Route::get('/bom/download-excel', [BomController::class, 'downloadExcel'])->name('download-excel');

    // --EXPORT DETAIL BOM--
    Route::get('/DetailBom/ExportExcel', [DetailbomController::class, 'exportToExcel'])->name('dbom.exportExcel');


    //DELETE MATERIAL & RESTORE MATERIAL
    Route::delete('/bommaterial/delete/{id_materialbom}/{id_bom}', [DetailbomController::class, 'deleteMaterial'])->name('bommaterial.delete');
    Route::post('/restore-material/{id_materialbom}/{id_bom}', [DetailbomController::class, 'restoreMaterial'])->name('bommaterial.restore');

    //SUBMIT MATERIAL (USAGE MATERIAL - JUMLAH)
    Route::post('/bom/submit', [DetailbomController::class, 'submit'])->name('bom.submit');

    // MENU WORK ORDER
    Route::get('/WorkOrder/IndexWorkOrder', [WoController::class, 'index'])->name('workorder-index');
    Route::delete('/WorkOrder/delete/{id_wo}}', [WoController::class, 'destroy'])->name('wo.delete');

    // --CREATE WORK ORDER--
    Route::get('/wo/create', [WoController::class, 'create'])->name('wo-create');
    Route::post('/wo/store', [WoController::class, 'store'])->name('wo.store');

    // --EDIT WORK ORDER--
    Route::get('/bom/editWO/{id_wo}', [WoController::class, 'edit'])->name('wo.editwo');
    Route::put('/bom/updateWO/{id_wo}', [WoController::class, 'update'])->name('wo.updatewo');

    // --EXPORT WORK ORDER--
    Route::get('/WO/ExportExcel', [WoController::class, 'exportToExcel'])->name('wo.exportExcel');
    Route::get('/WO/ExportPdf', [WoController::class, 'exportToPdf'])->name('wo.exportPdf');

    // MENU MPS
    Route::get('/MPS/IndexMPS', [MpsController::class, 'index'])->name('mps-index');
    // --UPLOAD MPS--
    Route::get('/MPS/UploadMPS', [MpsController::class, 'upload'])->name('mps-upload');
    Route::post('/MPS/UploadMPS', [MpsController::class, 'store'])->name('mps.store');
    Route::get('/MPS/getManHour/{id}', [MpsController::class, 'getTotalHour']);
    Route::get('/getdataid-wo/{idWo}', [MpsController::class, 'getDataByIdWo']);

    // --EXPORT MPS--
    Route::get('/MPS/ExportExcel', [MpsController::class, 'exportToExcel'])->name('mps.exportExcel');
    Route::get('/MPS/ExportPdf', [MpsController::class, 'exportToPdf'])->name('mps.exportPdf');

    // MENU GPA
    // --GPA DRY---
    Route::get('/GPA/IndexGPA-Dry', [GPADryController::class, 'index'])->name('gpa-indexgpadry');
    Route::get('/GPA/Detail-GPA-Dry/{id_wo}', [GPADryController::class, 'gpaDryDetail'])->name('gpa.detail-gpa-dry');

    // --EXPORT GPA DRY--
    Route::get('/GPA/ExportExcel', [GPADryController::class, 'exportToExcel'])->name('gpa.exportExcel');
    Route::get('/GPA/ExportPdf', [GPADryController::class, 'exportToPdf'])->name('gpa.exportPdf');
    Route::get('/GPA/ExportPdfDetail/{id_wo}', [GPADryController::class, 'exportToPdfDetail'])->name('gpa.exportPdfDetail');

    // --GPA OIL--
    Route::get('/GPA/IndexGPA-Oil', [GPAOilController::class, 'index'])->name('gpa-indexgpaoil');
    Route::get('/GPA/Detail-GPA-Oil/{id_wo}', [GPAOilController::class, 'gpaOilDetail'])->name('gpa.detail-gpa-oil');

    // MENU STOCK
    Route::get('/Stock/IndexStock', [StockController::class, 'indexSt'])->name('st-index');
    Route::get('/Stock/upload-excel', [StockController::class, 'formUpload'])->name('stock-upload-excel');
    Route::post('/Stock/upload-excel-post', [StockController::class, 'upload'])->name('stock-upload-excel-post');
    // --DELETE STOCK--
    Route::delete('/Stock/delete', [StockController::class, 'destroy'])->name('stock.delete');

    // MENU WORK CENTER OIL
    Route::get('/WorkCenter/IndexWorkcenter-OilTrafo', [WorkcenterOilTrafoController::class, 'index'])->name('wc-indexworkcenteroil');
    Route::get('/WorkCenter/Detail-Workcenter-Oil/{nama_workcenter}', [WorkcenterOilTrafoController::class, 'wcoildetail'])->name('wc-detailworkcenteroil');

    // MENU WORK CENTER DRY TYPE
    Route::get('/WorkCenter/IndexWorkcenter-DryType', [WorkcenterDryTypeController::class, 'index'])->name('wc-indexworkcenterdrytype');
    Route::get('/WorkCenter/Detail-Workcenter-DryType/{nama_workcenter}', [WorkcenterDryTypeController::class, 'wcdrytypedetail'])->name('wc-detailworkcenterdry');

    // MENU FINISH GOOD
    Route::get('/FinishGood/IndexFG', [FinishgoodController::class, 'indexFg'])->name('fg-index');
    Route::get('/FinishGood/upload-excel', [FinishgoodController::class, 'formUpload'])->name('fg-upload-excel');
    Route::post('/FinishGood/upload-excel-post', [FinishgoodController::class, 'upload'])->name('fg-upload-excel-post');
    Route::get('/FinishGood/EditFG/{kode_fg}', [FinishgoodController::class, 'edit'])->name('fg.editfg');
    Route::put('/FinishGood/updatefg/{kode_fg}', [FinishgoodController::class, 'updatefg'])->name('fg.updatefg');
    // --DELETE STOCK--
    Route::delete('/FinishGood/delete', [FinishgoodController::class, 'destroy'])->name('fg.delete');
    Route::get('/FinishGood/ExportExcel', [FinishgoodController::class, 'exportToExcel'])->name('fg.exportExcel');

    //NGAMBIL DATA si BOM & STANDARDIZE WORK (id_fg_)
    Route::get('/getdataid-fg/{idFg}', [WoController::class, 'getDataByIdFg']);
    Route::get('/getdatawo/{id_fg}', [WoController::class, 'getDataWO']);

    //NYOBA EMAIL 2 HARI & 7 HARI
    // Route::post('/send-email-notif', [DetailbomController::class, 'emailNotif']);
    Route::get('/run-email-reminder', [DetailbomController::class, 'manualEmailReminder']);
    // routes/web.php
    // Route::get('/manual-email-reminder', 'planner\DetailbomController@manualEmailReminder');


});

// Planner End

Route::middleware(['auth', 'resourceworkplanning'])->group(function () {
    Route::get('/', [ResourceWorkPlanningController::class, 'dashboard']);
    Route::get('resource_work_planning/dashboard', [ResourceWorkPlanningController::class, 'dashboard'])->name('dashboard');


    Route::post('resource_work_planning/dashboard/data/process-periode', [ResourceWorkPlanningController::class, 'dashboard'])->name('process.periode');
    Route::get('resource_work_planning/Work-Load', [ResourceWorkPlanningController::class, 'Workload']);

    // Route::get('resource_work_planning/PL2/Work-Load', [ResourceWorkPlanningController::class, 'pl2Workload']);
    Route::get('resource_work_planning/PL2/Rekomendasi', [ResourceWorkPlanningController::class, 'pl2Rekomendasi']);
    Route::get('resource_work_planning/PL2/Kebutuhan', [ResourceWorkPlanningController::class, 'pl2Kebutuhan']);
    // Route::get('resource_work_planning/PL3/Work-Load', [ResourceWorkPlanningController::class, 'pl3Workload']);
    Route::get('resource_work_planning/PL3/Rekomendasi', [ResourceWorkPlanningController::class, 'pl3Rekomendasi']);
    Route::get('resource_work_planning/PL3/Kebutuhan', [ResourceWorkPlanningController::class, 'pl3Kebutuhan']);
    // Route::get('resource_work_planning/CT-VT/Work-Load', [ResourceWorkPlanningController::class, 'ctvtWorkload']);
    Route::get('resource_work_planning/CT-VT/Rekomendasi', [ResourceWorkPlanningController::class, 'ctvtRekomendasi']);
    Route::get('resource_work_planning/CT-VT/Kebutuhan', [ResourceWorkPlanningController::class, 'ctvtKebutuhan']);
    // Route::get('resource_work_planning/Dry/Work-Load', [ResourceWorkPlanningController::class, 'dryWorkload']);
    Route::get('resource_work_planning/Dry/Rekomendasi', [ResourceWorkPlanningController::class, 'dryRekomendasi']);
    Route::post('resource_work_planning/Dry/Rekomendasi/data/proses-workcenter-rekomendasi', [ResourceWorkPlanningController::class, 'dryRekomendasi'])->name('process.workcenter_rekomendasi');
    Route::get('resource_work_planning/Dry/Kebutuhan', [ResourceWorkPlanningController::class, 'dryKebutuhan'])->name('dryKebutuhan');
    Route::post('resource_work_planning/Dry/Kebutuhan/data/proses-workcenter', [ResourceWorkPlanningController::class, 'dryKebutuhan'])->name('process.workcenter');
    // Route::get('resource_work_planning/Repair/Work-Load', [ResourceWorkPlanningController::class, 'repairWorkload']);
    Route::get('resource_work_planning/Repair/Rekomendasi', [ResourceWorkPlanningController::class, 'repairRekomendasi']);
    Route::get('resource_work_planning/Repair/Kebutuhan', [ResourceWorkPlanningController::class, 'repairKebutuhan']);
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
    Route::get('/standardized_work/Edit-Data/Dry-Cast-Resin/{id}', [DryCastResinController::class, 'edit'])->name('dryresin.edit');
    Route::put('/standardized_work/Edit-Data/Dry-Cast-Resin/{id}', [DryCastResinController::class, 'update'])->name('dryresin.update');
    Route::get('/standardized_work/Detail-Data/Dry-Cast-Resin/{id}', [DryCastResinController::class, 'detail'])->name('dryresin.detail');

    Route::get('/standardized_work/Create-Data/Dry-Non-Resin', [DryNonResinController::class, 'create'])->name('create.drynonresin');
    Route::get('/standardized_work/Create-Data/Dry-Non-Resin/kapasitas/{id}', [DryNonResinController::class, 'createManhour'])->name('create.drynonresin.createManhour');
    Route::post('/standardized_work/Create-Data/Dry-Non-Resin/Store', [DryNonResinController::class, 'store'])->name('store.drynonresin');
    Route::get('/standardized_work/Create-Data/Dry-Non-Resin/{id}/edit', [DryNonResinController::class, 'edit'])->name('drynonresin.edit');
    Route::put('/standardized_work/Create-Data/Dry-Non-Resin/{id}', [DryNonResinController::class, 'update'])->name('drynonresin.update');
});

//MR & PO
//Material Request
Route::middleware(['auth', 'materialrequest'])->group(function () {
    Route::get('/', [mrController::class, 'index'])->name('home');
    Route::get('/materialrequest', [mrController::class, 'index']);
    // Route::get('/materialrequest', [mrController::class, 'materialRequest']);
    Route::get('/materialrequest/add', [mrController::class, 'createmr']);
    Route::get('/materialrequest/{id_mr}', [mrController::class, 'editmr']);
    Route::post('/materialrequest/{id_mr}', [mrController::class, 'storeEditmr']);
    Route::post('/materialstore', [mrController::class, 'storemr']);
    Route::get('/materialrequest/delete/{id_mr}', [mrController::class, 'destroymr']);
    Route::get('/reportmr', [mrController::class, 'reportmr']);
});

//Purchase Order
Route::middleware(['auth', 'purchaseorder'])->group(function () {
    Route::get('/', [poController::class, 'index'])->name('home');
    Route::get('/purchaseorder', [poController::class, 'index']);
    // Route::get('/purchaseorder', [poController::class, 'purchaseorder']);
    Route::get('/purchaseorder/createPo/{id_mr}', [poController::class, 'createpo']);
    Route::post('/purchaseorder/{id_mr}/add', [poController::class, 'storepo']);
    Route::get('/purchaseorder/{id_po}', [poController::class, 'editpo']);
    Route::post('/purchaseorder/editPo/{id_po}', [poController::class, 'storeEditpo']);

    Route::get('/reportpo', [poController::class, 'reportPo']);

});
