<div class="row ">
    <div class="col-md-12 m-0 ">
        <div class="card rounded m-0" style="border-left-color: red; border-left-width: 10px;">
            <div class="card-body shadow">
                <div class="row">
                    <div class="col-lg-2 col-sm-6">
                        <h6>Total Hour</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-total_hour">
                            <b>
                                    {{ $detail->ctvt->total_hour }}
                            </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>Category</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-category">
                            <b>
                                    {{ $detail->ctvt->nama_product }}
                            </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>Kapasitas</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-ukuran_kapasitas">
                            <b>
                                    {{ $detail->ctvt->ukuran_kapasitas }}
                            </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>SO/No.Proyek</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-so">
                            <b>
                                    {{ $detail->ctvt->nomor_so }}
                            </b>
                        </p>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <h6>Kode Manhour</h6>
                        <p class="p-0 m-0" style="color: #d02424" id="preview-so">
                            <b>
                                    {{ $detail->ctvt->kd_manhour }}
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
                                        {{ $detail->ctvt->totalHour_coil_making }}

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
                                            id="preview-hour_balut_core_ct">
                                            {{ $detail->ctvt->hour_balut_core_ct }}


                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">Balut Core CT
                                        </h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-balut_core_ct">
                                            {{ $detail->ctvt->balut_core_ct }}

                                        </h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_cca_balutvt">
                                            {{ $detail->ctvt->hour_cca_balutvt }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Core coil assembly & balut VT
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-cca_balutvt">
                                            {{ $detail->ctvt->cca_balutvt }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_buat_pasang_shelding">
                                            {{ $detail->ctvt->hour_buat_pasang_shelding }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Buat Pasang Shelding
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-buat_pasang_shelding">
                                            {{ $detail->ctvt->buat_pasang_shelding }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_gulung_coil_sekunder_ct">
                                            {{ $detail->ctvt->hour_gulung_coil_sekunder_ct }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">gulung_coil_sekunder_ct
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-gulung_coil_sekunder_ct">
                                            {{ $detail->ctvt->gulung_coil_sekunder_ct }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_buat_coil_primer_ct_manual">
                                            {{ $detail->ctvt->hour_buat_coil_primer_ct_manual }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">buat_coil_primer_ct_manual
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-buat_coil_primer_ct_manual">
                                            {{ $detail->ctvt->buat_coil_primer_ct_manual }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_buat_coil_primer_ct_mesin">
                                            {{ $detail->ctvt->hour_buat_coil_primer_ct_mesin }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">buat_coil_primer_ct_mesin
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-buat_coil_primer_ct_mesin">
                                            {{ $detail->ctvt->buat_coil_primer_ct_mesin }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_conect_ct_vt">
                                            {{ $detail->ctvt->hour_conect_ct_vt }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">conect_ct_vt
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-conect_ct_vt">
                                            {{ $detail->ctvt->conect_ct_vt }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_solder">
                                            {{ $detail->ctvt->hour_solder }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">solder
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-solder">
                                            {{ $detail->ctvt->solder }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_gulung_coil_primer_cutcore">
                                            {{ $detail->ctvt->hour_gulung_coil_primer_cutcore }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">gulung_coil_primer_cutcore
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-gulung_coil_primer_cutcore">
                                            {{ $detail->ctvt->gulung_coil_primer_cutcore }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_gulung_coil_primer_nocutcor">
                                            {{ $detail->ctvt->hour_gulung_coil_primer_nocutcor }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">gulung_coil_primer_nocutcor
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-gulung_coil_primer_nocutcor">
                                            {{ $detail->ctvt->gulung_coil_primer_nocutcor }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_gulungcoil_vt_mesin">
                                            {{ $detail->ctvt->hour_gulungcoil_vt_mesin }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">gulungcoil_vt_mesin
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-gulungcoil_vt_mesin">
                                            {{ $detail->ctvt->gulungcoil_vt_mesin }}

                                        </h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_gulungcoil_vt_manual">
                                            {{ $detail->ctvt->hour_gulungcoil_vt_manual }}

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">gulungcoil_vt_manual
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-gulungcoil_vt_manual">
                                            {{ $detail->ctvt->gulungcoil_vt_manual }}

                                        </h6>

                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- <div class="card card-body my-1 py-1">
                    <div style="padding: 5px;">

                    </div>
                </div> --}}
            </div>

            <div class="col-lg-6" style="padding-left: 5px">
                <div class="card card-body my-1 py-1">
                    <div style="padding: 5px;">
                        <div class="row align-items-center">
                            <div class="input-group input-group-md justify-content-center">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">MOULD & CASTING</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-warning"
                                        id="preview-totalHour_MouldCasting">{{ $detail->ctvt->totalHour_MouldCasting }}
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
                                            id="preview-hour_mould_assembly_ct">
                                            {{ $detail->ctvt->hour_mould_assembly_ct }}</h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class=" border border-dark rounded p-1 text-center">HV
                                            Moulding</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class="border bg-warning rounded p-1 text-center" id="preview-mould_assembly_ct">
                                            {{ $detail->ctvt->mould_assembly_ct }}</h6>

                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_prosesmouldassembly_typevt">
                                            {{ $detail->ctvt->hour_prosesmouldassembly_typevt }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">prosesmouldassembly_typevt</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class="border bg-warning rounded p-1 text-center" id="preview-prosesmouldassembly_typevt">
                                            {{ $detail->ctvt->prosesmouldassembly_typevt }}</h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center"
                                            id="preview-hour_mould_assembly_rct">
                                            {{ $detail->ctvt->hour_mould_assembly_rct }}</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">mould_assembly_rct</h6>
                                    </td>
                                    <td>
                                        <h6 class="border bg-warning rounded p-1 text-center"
                                            id="preview-mould_assembly_rct">
                                            {{ $detail->ctvt->mould_assembly_rct }}</h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center"
                                            id="preview-hour_oven">
                                            {{ $detail->ctvt->hour_oven }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Pengovenan</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-oven">
                                            {{ $detail->ctvt->oven }}</h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center"
                                            id="preview-hour_pembuatan_material">
                                            {{ $detail->ctvt->hour_pembuatan_material }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">pembuatan_material</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-pembuatan_material">
                                            {{ $detail->ctvt->pembuatan_material }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center"
                                            id="preview-hour_casting">
                                            {{ $detail->ctvt->hour_casting }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">Casting</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-casting">
                                            {{ $detail->ctvt->casting }}</h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center"
                                            id="preview-hour_demoulding">{{ $detail->ctvt->hour_demoulding }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border border-dark rounded p-1 text-center">demoulding</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-demoulding">
                                            {{ $detail->ctvt->demoulding }}</h6>
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
                                    <span class="input-group-text">Final ASSEMBLY</span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-warning"
                                        id="preview-totalHour_FinalAssembly">{{ $detail->ctvt->totalHour_FinalAssembly }}</span>
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
                                            id="preview-hour_gerinda">
                                            {{ $detail->ctvt->hour_gerinda }}
                                        </h6>
                                    </td>
                                    <td class="w-30">
                                        <h6 class="border border-dark rounded p-1 text-center">Proses Gerinda</h6>
                                    </td>
                                    <td class="w-50">
                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                            id="preview-gerinda">
                                            {{ $detail->ctvt->gerinda }}</h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_cat">{{ $detail->ctvt->hour_cat }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center">Proses Cat
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center" id="preview-cat">
                                            {{ $detail->ctvt->cat }}</h6>
                                    </td>
                                </tr>
                                <tr !important>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_accessoris">
                                            {{ $detail->ctvt->hour_accessoris }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center">accessoris</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                            id="preview-accessoris">
                                            {{ $detail->ctvt->accessoris }}</h6>

                                    </td>
                                </tr>
                                <tr !important>

                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center"
                                            id="preview-hour_qc_testing">
                                            {{ $detail->ctvt->hour_qc_testing }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="border border-dark rounded p-1 text-center">QC</h6>
                                    </td>
                                    <td>
                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                            id="preview-qc_testing">
                                            {{ $detail->ctvt->qc_testing }}</h6>

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
