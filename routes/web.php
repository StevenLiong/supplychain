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
use App\Http\Controllers\planner\BomControllerV2;
use App\Http\Controllers\planner\MpsController;
use App\Http\Controllers\produksi\StandardizedWork\CtController;
use App\Http\Controllers\produksi\StandardizedWork\VtController;
use App\Http\Controllers\logistic\RakController;
use App\Http\Controllers\planner\Mps2Controller;
use App\Http\Controllers\purchaser\mrController;
use App\Http\Controllers\purchaser\poController;
use App\Http\Controllers\logistic\BpnbController;
use App\Http\Controllers\logistic\ScanController;
use App\Http\Controllers\planner\StockController;
use App\Http\Controllers\logistic\OrderController;
use App\Http\Controllers\planner\GPADryController;
use App\Http\Controllers\planner\GPAOilController;
use App\Http\Controllers\produksi\StandardizedWork\RepairController;
use App\Http\Controllers\logistic\CuttingController;
use App\Http\Controllers\logistic\PickingController;
use App\Http\Controllers\logistic\StorageController;
use App\Http\Controllers\planner\CalendarController;
use App\Http\Controllers\logistic\IncomingController;
use App\Http\Controllers\logistic\MaterialController;
use App\Http\Controllers\logistic\ServicesController;
use App\Http\Controllers\logistic\ShippingController;
use App\Http\Controllers\logistic\SupplierController;
use App\Http\Controllers\logistic\TransferController;
use App\Http\Controllers\planner\FinishgoodController;
use App\Http\Controllers\produksi\StandardizedWork\OilCustomController;
use App\Http\Controllers\logistic\CycleCountController;
use App\Http\Controllers\logistic\MaterialRakController;
use App\Http\Controllers\produksi\StandardizedWork\DryNonResinController;
use App\Http\Controllers\produksi\StandardizedWork\OilStandardController;
use App\Http\Controllers\produksi\ResourceWorkPlanning\ResourcePl2Controller;
use App\Http\Controllers\produksi\ResourceWorkPlanning\ResourcePl3Controller;
use App\Http\Controllers\logistic\FinishedgoodController;
use App\Http\Controllers\logistic\StokProduksiController;
use App\Http\Controllers\planner\DetailbomController;
use App\Http\Controllers\planner\DetailbomControllerV2;
use App\Http\Controllers\produksi\StandardizedWork\DryCastResinController;
use App\Http\Controllers\produksi\ResourceWorkPlanning\ResourceCtVtController;
use App\Http\Controllers\produksi\ResourceWorkPlanning\ResourceRepairController;
use App\Http\Controllers\produksi\StandardizedWork\StandardizeWorkController;
use App\Http\Controllers\planner\KapasitasProduksiController;
use App\Http\Controllers\planner\MaterialController as PlannerMaterialController;
use App\Http\Controllers\planner\WoControllerV2;
use App\Http\Controllers\planner\WorkcenterDryTypeController;
use App\Http\Controllers\produksi\ResourceWorkPlanning\ResourceWorkloadController;
use App\Http\Controllers\planner\WorkcenterOilTrafoController;
use App\Http\Controllers\produksi\ResourceWorkPlanning\ResourceDashboardController;
use App\Http\Controllers\produksi\ResourceWorkPlanning\ResourceDryKebutuhanController;
use App\Http\Controllers\produksi\ResourceWorkPlanning\ResourceKalkulasiSDMrController;
use App\Http\Controllers\produksi\ResourceWorkPlanning\ResourceDryRekomendasiController;

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

    // --EDIT MATERIAL & ADD NEW MATERIAL--
    Route::get('/bom/addmaterial/{id_bom}', [DetailbomController::class, 'addmaterial'])->name('bom-addmaterial');
    Route::post('/bom/storematerial', [DetailbomController::class, 'storematerial'])->name('bom.storematerial');
    Route::get('/bom/editmaterial/{id_materialbom}/{id_bom}', [DetailbomController::class, 'edit'])->name('bom.edit');
    Route::put('/bom/updatematerial/{id_materialbom}/{id_bom}', [DetailbomController::class, 'update'])->name('bom.update');

    // --DELETE BOM--
    Route::delete('/bom/delete/{id_bom}', [BomController::class, 'destroy'])->name('bom.delete');

    // --EXPORT BOM--
    Route::get('/bom/download-excel', [BomController::class, 'downloadExcel'])->name('download-excel');

    // --EXPORT DETAIL BOM--
    Route::get('/DetailBom/ExportExcel', [DetailbomController::class, 'ExportExcel'])->name('dbom.exportExcel');
    Route::get('/DetailBom/ExportPdf', [DetailbomController::class, 'ExportPdf'])->name('dbom.exportPdf');

    //DELETE MATERIAL & RESTORE MATERIAL
    Route::delete('/bommaterial/delete/{id_materialbom}/{id_bom}', [DetailbomController::class, 'deleteMaterial'])->name('bommaterial.delete');
    Route::post('/restore-material/{id_materialbom}/{id_bom}', [DetailbomController::class, 'restoreMaterial'])->name('bommaterial.restore');

    //SUBMIT MATERIAL (USAGE MATERIAL - JUMLAH)
    Route::post('/bom/submit', [DetailbomController::class, 'submit'])->name('bom.submit');

    //=======================================================BOM V2========================================================================
    // MENU BOM
    Route::get('/BOM_V2/IndexBom', [BomControllerV2::class, 'index'])->name('bom_v2-index');

    // --CREATE BOM & UPLOAD BOM--
    Route::get('/bom_V2/create', [BomControllerV2::class, 'create'])->name('bom_v2-create');
    Route::post('/bom_V2/store', [BomControllerV2::class, 'store'])->name('bom_v2.store');
    Route::get('/bom_V2/upload-excel', [DetailbomControllerV2::class, 'formUpload'])->name('bom_v2-upload-excel');
    Route::post('/bom_V2/upload-excel', [DetailbomControllerV2::class, 'upload'])->name('bom_v2-upload-excel-post');

    // --EDIT & DETAIL BOM--
    Route::get('/BOM_V2/DetailBOM/{id_bom}', [DetailbomControllerV2::class, 'bomDetail'])->name('bom_v2.detailbom');
    Route::get('/bom_V2/EditBOMInfo/{id_bom}', [BomControllerV2::class, 'infoBom'])->name('bom_v2.editbom');
    Route::put('/bom_V2/updatebom/{id_bom}', [BomControllerV2::class, 'updateBom'])->name('bom_v2.updatebom');
    Route::get('/DetailBom_V2/cek-material/{idBom}', [DetailbomControllerV2::class, 'CekMaterial']);
    Route::get('/DetailBom_V2/get-status-and-keterangan/{id_bom}', 'DetailbomControllerV2@ajaxGetStatusAndKeterangan');

    // --EDIT MATERIAL & ADD NEW MATERIAL--
    Route::get('/bom_V2/addmaterial/{id_bom}', [DetailbomControllerV2::class, 'addmaterial'])->name('bom_v2-addmaterial');
    Route::post('/bom_V2/storematerial', [DetailbomControllerV2::class, 'storematerial'])->name('bom_v2.storematerial');
    Route::get('/bom_V2/editmaterial/{id_materialbom}/{id_bom}', [DetailbomControllerV2::class, 'edit'])->name('bom_v2.edit');
    Route::put('/bom_V2/updatematerial/{id_materialbom}/{id_bom}', [DetailbomControllerV2::class, 'update'])->name('bom_v2.update');

    // --DELETE BOM--
    Route::delete('/bom_V2/delete/{id_bom}', [BomControllerV2::class, 'destroy'])->name('bom_v2.delete');

    // --EXPORT BOM--
    Route::get('/bom_V2/download-excel', [BomControllerV2::class, 'downloadExcel'])->name('download_v2-excel');

    // --EXPORT DETAIL BOM--
    Route::get('/DetailBom_V2/ExportExcel', [DetailbomControllerV2::class, 'exportToExcel'])->name('dbom_v2.exportExcel');
    Route::get('/DetailBom_V2/ExportPdf', [DetailbomControllerV2::class, 'exportToPdf'])->name('dbom_v2.exportPdf');


    //DELETE MATERIAL & RESTORE MATERIAL
    Route::delete('/bommaterial_V2/delete/{id_materialbom}/{id_bom}', [DetailbomControllerV2::class, 'deleteMaterial'])->name('bommaterial_v2.delete');
    Route::post('/restore-material_V2/{id_materialbom}/{id_bom}', [DetailbomControllerV2::class, 'restoreMaterial'])->name('bommaterial_v2.restore');

    //SUBMIT MATERIAL (USAGE MATERIAL - JUMLAH)
    Route::post('/bom_V2/submit', [DetailbomControllerV2::class, 'submit'])->name('bom_v2.submit');
    //======================================================================================================================

    // MENU WORK ORDER
    Route::get('/WorkOrder/IndexWorkOrder', [WoController::class, 'index'])->name('workorder-index');
    Route::delete('/WorkOrder/delete/{id}}', [WoController::class, 'destroy'])->name('wo.delete');

    // --CREATE WORK ORDER--
    Route::get('/wo/create', [WoController::class, 'create'])->name('wo-create');
    Route::post('/wo/store', [WoController::class, 'store'])->name('wo.store');

    // --EDIT WORK ORDER--
    Route::get('/bom/editWO/{id_wo}', [WoController::class, 'edit'])->name('wo.editwo');
    Route::put('/bom/updateWO/{id_wo}', [WoController::class, 'update'])->name('wo.updatewo');

    // --EXPORT WORK ORDER--
    Route::get('/WO/ExportExcel', [WoController::class, 'exportToExcel'])->name('wo.exportExcel');
    Route::get('/WO/ExportPdf', [WoController::class, 'exportToPdf'])->name('wo.exportPdf');


    //=======================================================WO V2========================================================================
    // MENU WORK ORDER V2
    Route::get('/WorkOrderV2/IndexWorkOrder', [WoControllerV2::class, 'index'])->name('workorder_v2-index');
    Route::delete('/WorkOrderV2/delete/{id}}', [WoControllerV2::class, 'destroy'])->name('wo_v2.delete');

    // --CREATE WORK ORDER--
    // Route::get('/WorkOrderV2/create', [WoControllerV2::class, 'create'])->name('wo_v2-create');
    Route::post('/WorkOrderV2/store', [WoControllerV2::class, 'store'])->name('wo_v2.store');

    // --EDIT WORK ORDER--
    Route::get('/WorkOrderV2/editWO/{id_wo}', [WoControllerV2::class, 'edit'])->name('wo_v2.editwo');
    Route::put('/WorkOrderV2/updateWO/{id_wo}', [WoControllerV2::class, 'update'])->name('wo_v2.updatewo');

    // --EXPORT WORK ORDER--
    Route::get('/WorkOrderV2/ExportExcel', [WoControllerV2::class, 'exportToExcel'])->name('wo_v2.exportExcel');
    Route::get('/WorkOrderV2/ExportPdf', [WoControllerV2::class, 'exportToPdf'])->name('wo_v2.exportPdf');

    Route::get('/WorkOrderV2/upload-excel', [WoControllerV2::class, 'formUpload'])->name('wo_v2-upload-excel');
    Route::post('/WorkOrderV2/upload-excel', [WoControllerV2::class, 'upload'])->name('wo_v2-upload-excel-post');
    //======================================================================================================================
    // MENU MPS
    Route::get('/MPS/IndexMPS', [MpsController::class, 'index'])->name('mps-index');
    Route::get('/MPS2/IndexMPS2', [Mps2Controller::class, 'index'])->name('mps2-index');
    Route::post('/MPS2/UploadMPS', [Mps2Controller::class, 'store'])->name('mps2.store');
    // --UPLOAD MPS--
    Route::get('/MPS/UploadMPS', [MpsController::class, 'upload'])->name('mps-upload');
    Route::post('/MPS/UploadMPS', [MpsController::class, 'store'])->name('mps.store');
    Route::get('/MPS/getManHour/{id}', [MpsController::class, 'getTotalHour']);
    Route::get('/getdataid-wo/{idWo}', [MpsController::class, 'getDataByIdWo']);

    // --EXPORT MPS--
    Route::get('/MPS/ExportExcel', [MpsController::class, 'exportToExcel'])->name('mps.exportExcel');
    Route::get('/MPS/ExportPdf', [MpsController::class, 'exportToPdf'])->name('mps.exportPdf');
    Route::get('/get-holiday', [CalendarController::class, 'getHolidays'])->name('get-holiday');

    // MENU GPA
    // --CALENDAR--

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

    // --EXPORT GPA OIL--
    Route::get('/GPA/ExportPdfOil', [GPAOilController::class, 'exportToPdf'])->name('gpa.exportPdfoil');

    // MENU STOCK
    Route::get('/Stock/IndexStock', [StockController::class, 'indexSt'])->name('st-index');
    Route::get('/Stock/upload-excel', [StockController::class, 'formUpload'])->name('stock-upload-excel');
    Route::post('/Stock/upload-excel-post', [StockController::class, 'upload'])->name('stock-upload-excel-post');
    // --DELETE STOCK--
    Route::delete('/Stock/delete', [StockController::class, 'destroy'])->name('stock.delete');

    // MENU WORK CENTER OIL
    Route::get('/WorkCenter/IndexWorkcenter-OilTrafo', [WorkcenterOilTrafoController::class, 'index'])->name('wc-indexworkcenteroil');
    Route::get('/WorkCenter/Detail-Workcenter-Oil/{nama_workcenter}', [WorkcenterOilTrafoController::class, 'wcoildetail'])->name('wc-detailworkcenteroil');

    // EXPORT WORKCENTER OIL TRAFO
    Route::get('/WC/ExportPdfDetail/{nama_workcenter}', [WorkcenterOilTrafoController::class, 'exportToPDF'])->name('wc.exportPDFoil');

    // MENU WORK CENTER DRY TYPE
    Route::get('/WorkCenter/IndexWorkcenter-DryType', [WorkcenterDryTypeController::class, 'index'])->name('wc-indexworkcenterdrytype');
    Route::get('/WorkCenter/Detail-Workcenter-DryType/{nama_workcenter}', [WorkcenterDryTypeController::class, 'wcdrytypedetail'])->name('wc-detailworkcenterdry');

    // EXPORT WORKCENTER DRY TYPE
    Route::get('/WC/ExportPdfDetail/{nama_workcenter}', [WorkcenterDryTypeController::class, 'exportToPDF'])->name('wc.exportPDFdry');

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
    Route::get('/run-email-reminder', [DetailbomController::class, 'manualEmailReminder']);

    Route::get('/get-capacity-by-date', [MpsController::class, 'getCapacityByDate'])->name('get-capacity-by-date');

    //MENU KAPASITAS PRODUKSI
    Route::get('/KapasitasProduksi/Index', [KapasitasProduksiController::class, 'index'])->name('kp-index');
    ROute::get('/KapasitasProduksi/{nama_pl}', [KapasitasProduksiController::class, 'detailPl'])->name('kp-detail');
    Route::get('/KapasitasProduksi/EditKp/{id}', [KapasitasProduksiController::class, 'editData'])->name('kp.editkp');
    Route::put('/KapasitasProduksi/updateKp/{id}', [KapasitasProduksiController::class, 'updateData'])->name('kp.updatekp');
    Route::get('/getData/{id}', [KapasitasProduksiController::class, 'getData']);
    Route::post('KapasitasProduksi/Index/Periode', [KapasitasProduksiController::class, 'index'])->name('bulan.periode');

    //MENU MATERIAL
    Route::get('/Material/IndexMaterial', [PlannerMaterialController::class, 'index'])->name('material-index');
    Route::get('/Material/upload-excel', [PlannerMaterialController::class, 'formUpload'])->name('material-upload-excel');
    Route::post('/Material/upload-excel-post', [PlannerMaterialController::class, 'upload'])->name('material-upload-excel-post');
    Route::delete('/Material/delete', [PlannerMaterialController::class, 'destroy'])->name('material.delete');
});

// Planner End

Route::middleware(['auth', 'resourceworkplanning'])->group(function () {
    Route::get('/', [ResourceDashboardController::class, 'dashboard']);
    Route::get('resource_work_planning/dashboard', [ResourceDashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('resource_work_planning/dashboard/data/process-periode', [ResourceDashboardController::class, 'dashboard'])->name('process.periode');

    Route::get('resource_work_planning/Work-Load', [ResourceWorkloadController::class, 'Workload'])->name('Workload');
    Route::post('resource_work_planning/Work-Load/data/process-periodeWorkload', [ResourceWorkloadController::class, 'Workload'])->name('process.periodeWorkload');

    Route::get('resource_work_planning/PL2/Rekomendasi', [ResourcePl2Controller::class, 'pl2Rekomendasi']);
    Route::get('resource_work_planning/PL2/Kebutuhan', [ResourcePl2Controller::class, 'pl2Kebutuhan'])->name('pl2Kebutuhan');
    Route::post('resource_work_planning/PL2/Kebutuhan/data/process-periodePL2', [ResourcePl2Controller::class, 'pl2Kebutuhan'])->name('process.periodePL2');

    Route::get('resource_work_planning/PL3/Rekomendasi', [ResourcePl3Controller::class, 'pl3Rekomendasi']);
    Route::get('resource_work_planning/PL3/Kebutuhan', [ResourcePl3Controller::class, 'pl3Kebutuhan'])->name('pl2Kebutuhan');
    Route::post('resource_work_planning/PL3/Kebutuhan/data/process-periodePL3', [ResourcePl3Controller::class, 'pl3Kebutuhan'])->name('process.periodePL3');

    Route::get('resource_work_planning/CT-VT/Rekomendasi', [ResourceCtVtController::class, 'ctvtRekomendasi']);
    Route::get('resource_work_planning/CT-VT/Kebutuhan', [ResourceCtVtController::class, 'ctvtKebutuhan'])->name('ctvtKebutuhan');
    Route::post('resource_work_planning/CT-VT/Kebutuhan/data/process.periodeCTVT', [ResourceCtVtController::class, 'ctvtKebutuhan'])->name('process.periodeCTVT');

    Route::get('resource_work_planning/Dry/Rekomendasi', [ResourceDryRekomendasiController::class, 'dryRekomendasi']);
    Route::post('resource_work_planning/Dry/Rekomendasi/data/proses-workcenter-rekomendasi', [ResourceDryRekomendasiController::class, 'dryRekomendasi'])->name('process.workcenter_rekomendasi');
    Route::get('resource_work_planning/Dry/Rekomendasi/nama_mp/{id}}/edit', [ResourceDryRekomendasiController::class, 'edit'])->name('nama_mp.edit');
    Route::put('resource_work_planning/Dry/Rekomendasi/nama_mp/{id}', [ResourceDryRekomendasiController::class, 'update'])->name('nama_mp.update');
    Route::get('resource_work_planning/Dry/Kebutuhan', [ResourceDryKebutuhanController::class, 'dryKebutuhan'])->name('dryKebutuhan');
    Route::post('resource_work_planning/Dry/Kebutuhan/data/process-periodeDryKebutuhan', [ResourceDryKebutuhanController::class, 'dryKebutuhan'])->name('process.periodeDryKebutuhan');

    Route::get('resource_work_planning/Repair/Rekomendasi', [ResourceRepairController::class, 'repairRekomendasi']);
    Route::get('resource_work_planning/Repair/Kebutuhan', [ResourceRepairController::class, 'repairKebutuhan'])->name('repairKebutuhan');
    Route::post('resource_work_planning/Repair/Kebutuhan/data/process-periodeRepair', [ResourceRepairController::class, 'repairKebutuhan'])->name('process.periodeRepair');

    Route::get('resource_work_planning/Kalkulasi-SDM', [ResourceKalkulasiSDMrController::class, 'kalkulasiSDM']);
});

Route::middleware(['auth', 'standardizedwork'])->group(function () {
    Route::get('/', [StandardizeWorkController::class, 'index'])->name('home');
    Route::get('/home', [StandardizeWorkController::class, 'index'])->name('home');
    Route::get('/standardized_work/home', [StandardizeWorkController::class, 'index'])->name('home');
    Route::delete('/standardized_work/{kd_manhour}', [StandardizeWorkController::class, 'destroy'])->name('delete');

    Route::get('/standardized_work/Create-Data/Dry-Cast-Resin', [DryCastResinController::class, 'create'])->name('create.dryresin');
    Route::get('/standardized_work/Create-Data/Dry-Cast-Resin/kapasitas/{id}', [DryCastResinController::class, 'createManhour'])->name('create.dryresin.createManhour');
    Route::post('/standardized_work/Create-Data/Dry-Cast-Resin/Store', [DryCastResinController::class, 'store'])->name('store.dryresin');
    Route::get('/standardized_work/Edit-Data/Dry-Cast-Resin/{id}', [DryCastResinController::class, 'edit'])->name('dryresin.edit');
    Route::put('/standardized_work/Edit-Data/Dry-Cast-Resin/{id}', [DryCastResinController::class, 'update'])->name('dryresin.update');
    Route::get('/standardized_work/Detail-Data/Dry-Cast-Resin/{id}', [DryCastResinController::class, 'detail'])->name('dryresin.detail');

    Route::get('/standardized_work/Create-Data/Ct', [CtController::class, 'create'])->name('create.ct');
    Route::get('/standardized_work/Create-Data/Ct/kapasitas/{id}', [CtController::class, 'createManhour'])->name('create.ct.createManhour');
    Route::post('/standardized_work/Create-Data/Ct/Store', [CtController::class, 'store'])->name('store.ct');
    Route::get('/standardized_work/Create-Data/Ct/{id}/edit', [CtController::class, 'edit'])->name('ct.edit');
    Route::put('/standardized_work/Create-Data/Ct/{id}', [CtController::class, 'update'])->name('ct.update');

    Route::get('/standardized_work/Create-Data/Vt', [VtController::class, 'create'])->name('create.vt');
    Route::get('/standardized_work/Create-Data/Vt/kapasitas/{id}', [VtController::class, 'createManhour'])->name('create.vt.createManhour');
    Route::post('/standardized_work/Create-Data/Vt/Store', [VtController::class, 'store'])->name('store.vt');
    Route::get('/standardized_work/Create-Data/Vt/{id}/edit', [VtController::class, 'edit'])->name('vt.edit');
    Route::put('/standardized_work/Create-Data/Vt/{id}', [VtController::class, 'update'])->name('vt.update');

    Route::get('/standardized_work/Create-Data/Repair', [RepairController::class, 'create'])->name('create.repair');
    Route::get('/standardized_work/Create-Data/Repair/kapasitas/{id}', [RepairController::class, 'createManhour'])->name('create.repair.createManhour');
    Route::post('/standardized_work/Create-Data/Repair/Store', [RepairController::class, 'store'])->name('store.repair');
    Route::get('/standardized_work/Create-Data/Repair/{id}/edit', [RepairController::class, 'edit'])->name('repair.edit');
    Route::put('/standardized_work/Create-Data/Repair/{id}', [RepairController::class, 'update'])->name('repair.update');

    Route::get('/standardized_work/Create-Data/Oil-Custom', [OilCustomController::class, 'create'])->name('create.oil_custom');
    Route::get('/standardized_work/Create-Data/Oil-Custom/kapasitas/{id}', [OilCustomController::class, 'createManhour'])->name('create.oil_custom.createManhour');
    Route::post('/standardized_work/Create-Data/Oil-Custom/Store', [OilCustomController::class, 'store'])->name('store.oil_custom');
    Route::get('/standardized_work/Create-Data/Oil-Custom/{id}/edit', [OilCustomController::class, 'edit'])->name('oil_custom.edit');
    Route::put('/standardized_work/Create-Data/Oil-Custom/{id}', [OilCustomController::class, 'update'])->name('oil_custom.update');

    Route::get('/standardized_work/Create-Data/Oil-Standard', [OilStandardController::class, 'create'])->name('create.oil_standard');
    Route::get('/standardized_work/Create-Data/Oil-Standard/kapasitas/{id}', [OilStandardController::class, 'createManhour'])->name('create.oil_standard.createManhour');
    Route::post('/standardized_work/Create-Data/Oil-Standard/Store', [OilStandardController::class, 'store'])->name('store.oil_standard');
    Route::get('/standardized_work/Create-Data/Oil-Standard/{id}/edit', [OilStandardController::class, 'edit'])->name('oil_standard.edit');
    Route::put('/standardized_work/Create-Data/Oil-Standard/{id}', [OilStandardController::class, 'update'])->name('oil_standard.update');

    Route::get('/standardized_work/Create-Data/Dry-Non-Resin', [DryNonResinController::class, 'create'])->name('create.drynonresin');
    Route::get('/standardized_work/Create-Data/Dry-Non-Resin/kapasitas/{id}', [DryNonResinController::class, 'createManhour'])->name('create.drynonresin.createManhour');
    Route::post('/standardized_work/Create-Data/Dry-Non-Resin/Store', [DryNonResinController::class, 'store'])->name('store.drynonresin');
    Route::get('/standardized_work/Create-Data/Dry-Non-Resin/{id}/edit', [DryNonResinController::class, 'edit'])->name('drynonresin.edit');
    Route::put('/standardized_work/Create-Data/Dry-Non-Resin/{id}', [DryNonResinController::class, 'update'])->name('drynonresin.update');
    

    // Route::get('/standardized_work/FilterData', 'StandardizeWorkController@filterData')->name('filterData');

    Route::get('/standardized_work/FilterData', [StandardizeWorkController::class, 'filterData'])->name('filterData');
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
