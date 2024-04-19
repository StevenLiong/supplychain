<div class="row ">
    <div class="col-md-12 m-0 ">
        <div class="card rounded m-0" style="border-left-color: red; border-left-width: 10px;">
            <div class="card-body shadow">
                <div class="row">
                    <div class="col-lg-2 col-sm-6">
                        <h6>Total Hour</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-total_hour">
                            <b>
                                    {{ $detail->repair->total_hour }}
                            </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>Category</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-category">
                            <b>
                                {{ $detail->repair->nama_product }} </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>Kapasitas</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-ukuran_kapasitas">
                            <b>
                                {{ $detail->repair->ukuran_kapasitas }} </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>SO/No.Proyek</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-so">
                            <b>
                                {{ $detail->repair->nomor_so }} </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>Kode Manhour</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-so">
                            <b>
                                {{ $detail->repair->kd_manhour }} </b>
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
                                    <span class="input-group-text">BONGKAR</span>
                                </div>
                                <div class="input-group-append">
                                    <span type="text" class="input-group-text bg-warning" style="width: 3rem"
                                        id="preview-totalHour_bongkar">
                                        {{ $detail->repair->totalHour_bongkar }}

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
                                            id="preview-hour_untanking">
                                            {{ $detail->repair->hour_untanking }}


                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">Untanking
                                        </h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-untanking">
                                            {{ $detail->repair->untanking }}

                                        </h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_bongkar_conservator">
                                            {{ $detail->repair->hour_bongkar_conservator }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Bongkar Conservator
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-bongkar_conservator">
                                            {{ $detail->repair->bongkar_conservator }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_bongkar_cable_box">
                                            {{ $detail->repair->hour_bongkar_cable_box }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Bongkar Cable Box
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-bongkar_cable_box">
                                            {{ $detail->repair->bongkar_cable_box }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_bongkar_radiator_panel">
                                            {{ $detail->repair->hour_bongkar_radiator_panel }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Bongkar Radiator Panel
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-bongkar_radiator_panel">
                                            {{ $detail->repair->bongkar_radiator_panel }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_bongkar_accesories">
                                            {{ $detail->repair->hour_bongkar_accesories }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Bongkar Accessories
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-bongkar_accesories">
                                            {{ $detail->repair->bongkar_accesories }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_bongkar_core">
                                            {{ $detail->repair->hour_bongkar_core }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Bongkar Core
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-bongkar_core">
                                            {{ $detail->repair->bongkar_core }}

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
                                    <span class="input-group-text">COIL MAKING</span>
                                </div>
                                <div class="input-group-append">
                                    <span type="text" class="input-group-text bg-warning" style="width: 3rem"
                                        id="preview-totalHour_coil_making">
                                        {{ $detail->repair->totalHour_coil_making }}

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
                                            {{ $detail->repair->hour_coil_lv }}


                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">Coil LV
                                        </h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-coil_lv">
                                            {{ $detail->repair->coil_lv }}

                                        </h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_coil_hv">
                                            {{ $detail->repair->hour_coil_hv }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Coil HV
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-coil_hv">
                                            {{ $detail->repair->coil_hv }}

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
                                        id="preview-totalHour_Conect">{{ $detail->repair->totalHour_Conect }}
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
                                            id="preview-hour_hour_connect">
                                            {{ $detail->repair->hour_connect }}</h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">Connection</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class="border bg-warning rounded p-1 text-center" id="preview-connect">
                                            {{ $detail->repair->connect }}</h6>

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
                                    <span class="input-group-text">CORE COIL ASSEMBLY</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-warning"
                                        id="preview-totalHour_CCA">{{ $detail->repair->totalHour_CCA }}</span>
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
                                            {{ $detail->repair->hour_cca }}
                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class="border border-dark rounded p-1 text-center">Core Coil Assembly</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                            id="preview-cca">
                                            {{ $detail->repair->cca }}</h6>
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
                                        id="preview-totalHour_FinalAssembly">{{ $detail->repair->totalHour_FinalAssembly }}
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
                                            id="preview-hour_hv_connect">
                                            {{ $detail->repair->hour_hv_connect }}</h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">HV Connection</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class="border bg-warning rounded p-1 text-center" id="preview-hv_connect">
                                            {{ $detail->repair->hv_connect }}</h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td class="w-20">
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_lv_connect">
                                            {{ $detail->repair->hour_lv_connect }}</h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">LV Connection</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class="border bg-warning rounded p-1 text-center" id="preview-lv_connect">
                                            {{ $detail->repair->lv_connect }}</h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td class="w-20">
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_final_assembly">
                                            {{ $detail->repair->hour_final_assembly }}</h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">Final Assembly
                                        </h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class="border bg-warning rounded p-1 text-center"
                                            id="preview-final_assembly">
                                            {{ $detail->repair->final_assembly }}</h6>

                                    </td>
                                </tr>
                            </table>
                        </div>
                        {{-- <div class="align-items-center justify-content-left pt-1 px-1">
                            <table class="w-100">

                            </table>
                        </div> --}}
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
                                        id="preview-hour_qctesting">{{ $detail->repair->totalHour_Finishing }}</span>
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
                                            id="preview-hour_accessories">
                                            {{ $detail->repair->hour_accessories }}
                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class="border border-dark rounded p-1 text-center">Accessories</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-accessories">
                                            {{ $detail->repair->accessories }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td class="w-20">
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_wiring">
                                            {{ $detail->repair->hour_wiring }}
                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class="border border-dark rounded p-1 text-center">Wiring</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-wiring">
                                            {{ $detail->repair->wiring }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td class="w-20">
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_copper_link">
                                            {{ $detail->repair->hour_copper_link }}
                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class="border border-dark rounded p-1 text-center">Copper Link</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-copper_link">
                                            {{ $detail->repair->copper_link }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td class="w-20">
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_cable_box">
                                            {{ $detail->repair->hour_cable_box }}
                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class="border border-dark rounded p-1 text-center">Cable Box</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-cable_box">
                                            {{ $detail->repair->cable_box }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td class="w-20">
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_radiator_panel">
                                            {{ $detail->repair->hour_radiator_panel }}
                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class="border border-dark rounded p-1 text-center">Radiator Panel</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-radiator_panel">
                                            {{ $detail->repair->radiator_panel }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td class="w-20">
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_conservator">
                                            {{ $detail->repair->hour_conservator }}
                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class="border border-dark rounded p-1 text-center">Conservator</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-conservator">
                                            {{ $detail->repair->conservator }}
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
                                        id="preview-hour_qctesting">{{ $detail->repair->totalHour_QCTest }}</span>
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
                                            id="preview-hour_qc">
                                            {{ $detail->repair->hour_qc }}
                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class="border border-dark rounded p-1 text-center">QC Test</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                            id="preview-qc">{{ $detail->repair->qc }}
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
