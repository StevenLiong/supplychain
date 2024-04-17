<div class="row ">
    <div class="col-md-12 m-0 ">
        <div class="card rounded m-0" style="border-left-color: red; border-left-width: 10px;">
            <div class="card-body shadow">
                <div class="row">
                    <div class="col-lg-2 col-sm-6">
                        <h6>Total Hour</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-total_hour">
                            <b>
                                    {{ $detail->oil_custom->total_hour }}
                            </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>Category</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-category">
                            <b>
                                {{ $detail->oil_custom->nama_product }}
                            </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>Kapasitas</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-ukuran_kapasitas">
                            <b>
                                {{ $detail->oil_custom->ukuran_kapasitas }}
                            </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>SO/No.Proyek</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-so">
                            <b>
                                {{ $detail->oil_custom->nomor_so }}
                            </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>Kode Manhour</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-so">
                            <b>
                                {{ $detail->oil_custom->kd_manhour }}
                            </b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row px-2 mt-0" !important>
    <div class="col-lg-12  mb-0">
        <div class="row">
            <div class="col-lg-6" style="padding-right: 5px">
                <div class="card card-body my-1 py-1">
                    <div style="padding: 5px;">
                        <div class="row align-items-center ">
                            <div class="input-group input-group-md justify-content-center">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">COIL MAKING</span>
                                </div>
                                <div class="input-group-append">
                                    <span type="text" class="input-group-text bg-warning" style="width: 3rem"
                                        id="preview-totalHour_coil_making">
                                        {{ $detail->oil_custom->totalHour_coil_making }}

                                    </span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">HOUR</span>
                                </div>
                            </div>
                        </div>
                        <div class="align-items-center justify-content-left pt-1 px-1">
                            <table class="w-100">
                                <tr !important>
                                    <td class="w-20">
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_coil_lv">
                                            {{ $detail->oil_custom->hour_coil_lv }}


                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">Coil LV
                                        </h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-coil_lv">
                                            {{ $detail->oil_custom->coil_lv }}

                                        </h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_coil_hv">
                                            {{ $detail->oil_custom->hour_coil_hv }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Coil HV
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-coil_hv">
                                            {{ $detail->oil_custom->coil_hv }}

                                        </h6>

                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card card-body my-1 py-1">
                    <div style="padding: 5px;">
                        <div class="row align-items-center">
                            <div class="input-group input-group-md justify-content-center">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">CONNECTION</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-warning"
                                        id="preview-totalHour_Conect">{{ $detail->oil_custom->totalHour_Conect }}
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">HOUR</span>
                                </div>
                            </div>
                        </div>
                        <div class="align-items-center justify-content-left pt-1 px-1">
                            <table class="w-100">
                                <tr !important>
                                    <td class="w-20">
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_hour_connection">
                                            {{ $detail->oil_custom->hour_connection }}</h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">connection</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class="border bg-warning rounded p-1 text-center" id="preview-connection">
                                            {{ $detail->oil_custom->connection }}</h6>

                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card card-body my-1 py-1">
                    <div style="padding: 5px;">
                        <div class="row align-items-center ">
                            <div class="input-group input-group-md justify-content-center">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">CORE & ASSEMBLY</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-warning"
                                        id="preview-totalHour_CoreCoilAssembly">{{ $detail->oil_custom->totalHour_CoreCoilAssembly }}</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">HOUR</span>
                                </div>
                            </div>
                        </div>
                        <div class="align-items-center justify-content-left pt-1 px-1">
                            <table class="w-100">
                                <tr !important>
                                    <td class="w-20">
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_cca">
                                            {{ $detail->oil_custom->hour_cca }}
                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class="border border-dark rounded p-1 text-center">Core Coil Assembly</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                            id="preview-cca">
                                            {{ $detail->oil_custom->cca }}</h6>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" style="padding-left: 5px">

                <div class="card card-body my-1 py-1">
                    <div style="padding: 5px;">
                        <div class="row align-items-center">
                            <div class="input-group input-group-md justify-content-center">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">FINAL ASSEMBLY</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-warning"
                                        id="preview-totalHour_FinalAssembly">{{ $detail->oil_custom->totalHour_FinalAssembly }}
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">HOUR</span>
                                </div>
                            </div>
                        </div>
                        <div class="align-items-center justify-content-left pt-1 px-1">
                            <table class="w-100">
                                <tr !important>
                                    <td class="w-20">
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_final_assy">
                                            {{ $detail->oil_custom->hour_final_assy }}</h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">final_assembly</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class="border bg-warning rounded p-1 text-center" id="preview-final_assy">
                                            {{ $detail->oil_custom->final_assy }}</h6>

                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="align-items-center justify-content-left pt-1 px-1">
                            <table class="w-100">
                                <tr !important>
                                    <td class="w-20">
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_special_assembly">
                                            {{ $detail->oil_custom->hour_special_assembly }}</h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">Special Final Assembly
                                        </h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class="border bg-warning rounded p-1 text-center"
                                            id="preview-special_assembly">
                                            {{ $detail->oil_custom->special_assembly }}</h6>

                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card card-body my-1 py-1">
                    <div style="padding: 5px;">
                        <div class="row align-items-center ">
                            <div class="input-group input-group-md justify-content-center">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">FINISHING</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-warning"
                                        id="preview-hour_qctesting">{{ $detail->oil_custom->totalHour_Finishing }}</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">HOUR</span>
                                </div>
                            </div>
                        </div>
                        <div class="align-items-center justify-content-left pt-1 px-1">
                            <table class="w-100">
                                <tr !important>
                                    <td class="w-20">
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_finishing">
                                            {{ $detail->oil_custom->hour_finishing }}
                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class="border border-dark rounded p-1 text-center">Finishing</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-finishing">
                                            {{ $detail->oil_custom->finishing }}
                                        </h6>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card card-body my-1 py-1">
                    <div style="padding: 5px;">
                        <div class="row align-items-center ">
                            <div class="input-group input-group-md justify-content-center">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">QC Testing</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-warning"
                                        id="preview-hour_qctesting">{{ $detail->oil_custom->totalHour_QCTest }}</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">HOUR</span>
                                </div>
                            </div>
                        </div>
                        <div class="align-items-center justify-content-left pt-1 px-1">
                            <table class="w-100">
                                <tr !important>
                                    <td class="w-20">
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_qc_testing">
                                            {{ $detail->oil_custom->hour_qc_testing }}
                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class="border border-dark rounded p-1 text-center">QC</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                            id="preview-qc_testing">{{ $detail->oil_custom->qc_testing }}
                                        </h6>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>
