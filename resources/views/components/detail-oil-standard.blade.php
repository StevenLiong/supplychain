<div class="row ">
    <div class="col-md-12 m-0 ">
        <div class="card rounded m-0" style="border-left-color: red; border-left-width: 10px;">
            <div class="card-body shadow">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <h6>Category</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-category">
                            <b>
                                    {{ $detail->oil_standard->nama_product }}
                            </b>
                        </p>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h6>Kapasitas</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-ukuran_kapasitas">
                            <b>
                                    {{ $detail->oil_standard->ukuran_kapasitas }}
                            </b>
                        </p>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h6>SO/No.Proyek</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-so">
                            <b>
                                    {{ $detail->oil_standard->nomor_so }}
                            </b>
                        </p>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h6>Kode Manhour</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-so">
                            <b>
                                    {{ $detail->oil_standard->kd_manhour }}
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
                                        {{ $detail->oil_standard->totalHour_coil_making }}

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
                                            {{ $detail->oil_standard->hour_coil_lv }}


                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">Coil LV
                                        </h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-coil_lv">
                                            {{ $detail->oil_standard->coil_lv }}

                                        </h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_coil_hv">
                                            {{ $detail->oil_standard->hour_coil_hv }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Coil HV
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-coil_hv">
                                            {{ $detail->oil_standard->coil_hv }}

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
                                        id="preview-totalHour_Conect">{{ $detail->oil_standard->totalHour_Conect }}
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
                                            id="preview-hour_hv_moulding">
                                            {{ $detail->oil_standard->hour_connect }}</h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">connect</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class="border bg-warning rounded p-1 text-center" id="preview-connect">
                                            {{ $detail->oil_standard->connect }}</h6>

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
                        <div class="row align-items-center ">
                            <div class="input-group input-group-md justify-content-center">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">CORE & ASSEMBLY</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-warning"
                                        id="preview-totalHour_CoreCoilAssembly">{{ $detail->oil_standard->totalHour_CoreCoilAssembly }}</span>
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
                                            id="preview-hour_core_coil_assembly">
                                            {{ $detail->oil_standard->hour_core_coil_assembly }}
                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class="border border-dark rounded p-1 text-center">Core Coil Assembly</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                            id="preview-core_coil_assembly">
                                            {{ $detail->oil_standard->core_coil_assembly }}</h6>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card card-body my-1 py-1">
                            <div style="padding: 5px;">
                                <div class="row align-items-center">
                                    <div class="input-group input-group-md justify-content-center">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">FINAL ASSEMBLY</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-warning"
                                                id="preview-totalHour_FinalAssembly">{{ $detail->oil_standard->totalHour_FinalAssembly }}
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
                                                    id="preview-hour_hv_moulding">
                                                    {{ $detail->oil_standard->hour_final_assembly }}</h6>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">final_assembly</h6>
                                            </td>
                                            <td class="w-50">
                                                <h6 class="border bg-warning rounded p-1 text-center" id="preview-final_assembly">
                                                    {{ $detail->oil_standard->final_assembly }}</h6>

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
                                                id="preview-hour_qctesting">{{ $detail->oil_standard->totalHour_QCTest }}</span>
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
                                                    {{ $detail->oil_standard->hour_qc_testing }}
                                                </h6>
                                            </td>
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">QC</h6>
                                            </td>
                                            <td>
                                                <h6 class=" border bg-warning rounded p-1 text-center"
                                                    id="preview-qc_testing">{{ $detail->oil_standard->qc_testing }}
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
    </div>
</div>
