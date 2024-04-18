<div class="row ">
    <div class="col-md-12 m-0 ">
        <div class="card rounded m-0" style="border-left-color: red; border-left-width: 10px;">
            <div class="card-body shadow">
                <div class="row">
                    <div class="col-lg-2 col-sm-6">
                        <h6>Total Hour</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-total_hour">
                            <b>
                                    {{ $detail->dry_cast_resin->total_hour }}
                            </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>Category</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-category">
                            <b>

                                {{ $detail->dry_cast_resin->nama_product }}

                            </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>Kapasitas</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-ukuran_kapasitas">
                            <b>
                                {{ $detail->dry_cast_resin->ukuran_kapasitas }}

                            </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>SO/No.Proyek</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-so">
                            <b>
                                {{ $detail->dry_cast_resin->nomor_so }}

                            </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>Kode Manhour</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-so">
                            <b>
                                {{ $detail->dry_cast_resin->kd_manhour }}

                            </b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row px-2 mt-0"!important>
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
                                        {{ $detail->dry_cast_resin->totalHour_coil_making }}

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
                                            {{ $detail->dry_cast_resin->hour_coil_lv }}


                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">Coil LV
                                        </h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-coil_lv">
                                            {{ $detail->dry_cast_resin->coil_lv }}

                                        </h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_coil_hv">
                                            {{ $detail->dry_cast_resin->hour_coil_hv }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Coil HV
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-coil_hv">
                                            {{ $detail->dry_cast_resin->coil_hv }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_coil_hv">
                                            {{ $detail->dry_cast_resin->hour_potong_leadwire }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Potong Leadwire
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-coil_hv">
                                            {{ $detail->dry_cast_resin->potong_leadwire }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_coil_hv">
                                            {{ $detail->dry_cast_resin->hour_potong_isolasi }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Potong Isolasi
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-coil_hv">
                                            {{ $detail->dry_cast_resin->potong_isolasi }}

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
                                    <span class="input-group-text">MOULD & CASTING</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-warning"
                                        id="preview-totalHour_MouldCasting">{{ $detail->dry_cast_resin->totalHour_MouldCasting }}
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
                                            {{ $detail->dry_cast_resin->hour_hv_moulding }}</h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">HV
                                            Moulding</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class="border bg-warning rounded p-1 text-center" id="preview-hv_moulding">
                                            {{ $detail->dry_cast_resin->hv_moulding }}</h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_hv_casting">
                                            {{ $detail->dry_cast_resin->hour_hv_casting }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">HV
                                            Casting</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class="border bg-warning rounded p-1 text-center" id="preview-hv_casting">
                                            {{ $detail->dry_cast_resin->hv_casting }}</h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center"
                                            id="preview-hour_hv_demoulding">
                                            {{ $detail->dry_cast_resin->hour_hv_demoulding }}</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">HV
                                            Demoulding</h6>
                                    </td>
                                    <td>
                                        <h6 class="border bg-warning rounded p-1 text-center"
                                            id="preview-hv_demoulding">
                                            {{ $detail->dry_cast_resin->hv_demoulding }}</h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center"
                                            id="preview-hour_lv_bobbin">
                                            {{ $detail->dry_cast_resin->hour_lv_bobbin }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">LV
                                            Bobbin</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-lv_bobbin">
                                            {{ $detail->dry_cast_resin->lv_bobbin }}</h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center"
                                            id="preview-hour_lv_moulding">
                                            {{ $detail->dry_cast_resin->hour_lv_moulding }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">LV
                                            Moulding</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-lv_moulding">
                                            {{ $detail->dry_cast_resin->lv_moulding }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center"
                                            id="preview-hour_touch_up">
                                            {{ $detail->dry_cast_resin->hour_touch_up }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Touch
                                            Up</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-touch_up">
                                            {{ $detail->dry_cast_resin->touch_up }}</h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center"
                                            id="preview-hour_oven">{{ $detail->dry_cast_resin->hour_oven }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Oven</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-oven">
                                            {{ $detail->dry_cast_resin->oven }}</h6>
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
                                        id="preview-totalHour_CoreCoilAssembly">{{ $detail->dry_cast_resin->totalHour_CoreCoilAssembly }}</span>
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
                                            id="preview-hour_type_susun_core">
                                            {{ $detail->dry_cast_resin->hour_type_susun_core }}
                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class="border border-dark rounded p-1 text-center">Type
                                            Susun Core</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                            id="preview-type_susun_core">
                                            {{ $detail->dry_cast_resin->type_susun_core }}</h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_wiring">{{ $detail->dry_cast_resin->hour_wiring }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center">Wiring
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-wiring">
                                            {{ $detail->dry_cast_resin->wiring }}</h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_instal_housing">
                                            {{ $detail->dry_cast_resin->hour_instal_housing }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center">Instal
                                            Housing</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                            id="preview-instal_housing">
                                            {{ $detail->dry_cast_resin->instal_housing }}</h6>

                                    </td>
                                </tr>
                                <tr !important>

                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_bongkar_housing">
                                            {{ $detail->dry_cast_resin->hour_bongkar_housing }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center">Bongkar
                                            Housing</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                            id="preview-bongkar_housing">
                                            {{ $detail->dry_cast_resin->bongkar_housing }}</h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_pembuatan_cu_link">
                                            {{ $detail->dry_cast_resin->hour_pembuatan_cu_link }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center">
                                            Pembuatan CU Link
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                            id="preview-pembuatan_cu_link">
                                            {{ $detail->dry_cast_resin->pembuatan_cu_link }}</h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_others">{{ $detail->dry_cast_resin->hour_others }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center">Others
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-others">
                                            {{ $detail->dry_cast_resin->others }}</h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_accesories">
                                            {{ $detail->dry_cast_resin->hour_accesories }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center">
                                            Accessories</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                            id="preview-accesories">{{ $detail->dry_cast_resin->accesories }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_potong_isolasi_fiber">
                                            {{ $detail->dry_cast_resin->hour_potong_isolasi_fiber }}
                                        </h6>

                                    </td>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center">Potong
                                            Isolasi Fiber</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                            id="preview-potong_isolasi_fiber">
                                            {{ $detail->dry_cast_resin->potong_isolasi_fiber }}
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
                                        id="preview-hour_qctesting">{{ $detail->dry_cast_resin->totalHour_QCTest }}</span>
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
                                            {{ $detail->dry_cast_resin->hour_qc_testing }}
                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class="border border-dark rounded p-1 text-center">QC</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                            id="preview-qc_testing">{{ $detail->dry_cast_resin->qc_testing }}
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
