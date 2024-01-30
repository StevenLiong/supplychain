<div class="modal fade preview" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <p class="p-2 bg-warning rounded "><strong><i class="fa-solid fa-warning mr-2"></i> Mohon cek
                            kembali data yang anda input!<strong></p>
                </div>

                <div class="row ">
                    <div class="col-md-12">
                        <div class="card rounded-4" style="border-left-color: red; border-left-width: 10px;">
                            <div class="card-body shadow">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h6>Category</h6>
                                        <p class="p-0 m-0" style="color: #d02424" id="preview-category"></p>
                                    </div>
                                    <div class="col-lg-4">
                                        <h6>Kapasitas</h6>
                                        <p class="p-0 m-0" style="color: #d02424" id="preview-ukuran_kapasitas"></p>
                                    </div>
                                    <div class="col-lg-4">
                                        <h6>SO/No.Proyek</h6>
                                        <p class="p-0 m-0" style="color: #d02424" id="preview-so"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row px-2">
                    <div class="col-lg-12  mb-0">
                        <div class="row">
                            <!-- kiri  -->
                            <div class="col-lg-6" style="padding-right: 5px">
                                <!--modal Coil Making  -->
                                <div class="card card-body my-1 py-1">
                                    <div style="padding: 5px;">
                                        <!-- tampilan total hour pada tiap work center  -->
                                        <div class="row align-items-center ">
                                            <div class="input-group input-group-md justify-content-center">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">COIL MAKING</span>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-warning"
                                                        id="preview-hour_coilmaking"> </span>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">HOUR</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- kolom isi  -->
                                        <div class="align-items-center justify-content-left pt-1 px-1">
                                            <table class="w-100">
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->
                                                    <td class="w-20">
                                                        <h6 class="border border-dark rounded p-1 text-center"
                                                            id="preview-hour_coillv">XX
                                                        </h6>
                                                    </td>
                                                    <!-- nama proses-->
                                                    <td class="w-30">
                                                        <h6 class=" border border-dark rounded p-1 text-center">Coil LV
                                                        </h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td class="w-50">
                                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                                            id="preview-coillv"></h6>
                                                    </td>
                                                </tr>
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center"
                                                            id="preview-hour_coilhv">XX
                                                        </h6>
                                                    </td>
                                                    <!-- nama proses-->
                                                    <td>
                                                        <h6 class=" border border-dark rounded p-1 text-center">Coil HV
                                                        </h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td>
                                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                                            id="preview-coilhv"></h6>

                                                    </td>
                                                </tr>
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->
                                                    <td>
                                                        <h6 class=" border border-dark rounded p-1 text-center"
                                                            id="preview-hour_potongleadwire">XX</h6>
                                                    </td>
                                                    <!-- nama proses-->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center">Potong
                                                            Lead Wire</h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td>
                                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                                            id="preview-potongleadwire"></h6>
                                                    </td>
                                                </tr>
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center"
                                                            id="preview-hour_potongisolasi"></h6>
                                                    </td>
                                                    <!-- nama proses-->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center">Potong
                                                            Isolasi</h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td>
                                                        <div class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center "
                                                            style="margin-bottom: 0rem">

                                                            <div class="row align-items-center ">
                                                                <input type="checkbox" class="checkbox-input mr-1"
                                                                    id="preview-potongisolasi_Dog_Bone" disabled>
                                                                <label for="preview-potongisolasi_Dog_Bone"
                                                                    class="m-0">Dog Bone</label>

                                                            </div>
                                                            <div class="row align-items-center">
                                                                <input type="checkbox" class="checkbox-input mr-1"
                                                                    id="preview-potongisolasi_Inner" disabled>
                                                                <label
                                                                    for="preview-potongisolasi_Inner"class="m-0">Inner</label>
                                                            </div>
                                                            <div class="row align-items-center">
                                                                <input type="checkbox" class="checkbox-input mr-1"
                                                                    id="preview-potongisolasi_Outer" disabled>
                                                                <label class="m-0"
                                                                    for="preview-potongisolasi_Outer">Outer</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- modal Moulding & Casting  -->
                                <div class="card card-body my-1 py-1">
                                    <div style="padding: 5px;">
                                        <!-- tampilan total hour pada tiap work center  -->
                                        <div class="row align-items-center">
                                            <div class="input-group input-group-md justify-content-center">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">MOULD & CASTING</span>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-warning"
                                                        id="preview-hour_mouldcasting"><b>05</b></span>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">HOUR</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- kolom isi  -->
                                        <div class="align-items-center justify-content-left pt-1 px-1">
                                            <table class="w-100">
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->
                                                    <td class="w-20">
                                                        <h6 class="border border-dark rounded p-1 text-center"
                                                            id="preview-hour_mouldingcasting">XX</h6>
                                                    </td>
                                                    <!-- nama proses-->
                                                    <td class="w-30">
                                                        <h6 class=" border border-dark rounded p-1 text-center">Moulding Casting</h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td class="w-50">
                                                        <h6 class="border bg-warning rounded p-1 text-center"
                                                            id="preview-mouldingcasting"></h6>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                {{-- qc testing  --}}
                                <div class="card card-body my-1 py-1">
                                    <div style="padding: 5px;">
                                        <!-- tampilan total hour pada tiap work center  -->
                                        <div class="row align-items-center ">
                                            <div class="input-group input-group-md justify-content-center">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">QC Testing</span>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-warning"
                                                        id="preview-hour_qctesting"></span>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">HOUR</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- kolom isi  -->
                                        <div class="align-items-center justify-content-left pt-1 px-1">
                                            <table class="w-100">
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->
                                                    <td class="w-20">
                                                        <h6 class="border border-dark rounded p-1 text-center"
                                                            id="preview-hour_routinetest">
                                                        </h6>
                                                    </td>
                                                    <!-- nama proses-->
                                                    <td class="w-30">
                                                        <h6 class="border border-dark rounded p-1 text-center">Routine
                                                            Test</h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td class="w-50">
                                                        <div class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center "
                                                            style="margin-bottom: 0rem">
                                                            <div class="row align-items-center">
                                                                <input type="checkbox" disabled
                                                                    class="checkbox-input mr-1"
                                                                    id="preview-qctesting_routine_test">
                                                                <label class="m-0"
                                                                    for="preview-qctesting_routine_test">Routine
                                                                    Test</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- kanan  -->
                            <div class="col-lg-6" style="padding-left: 5px">
                                {{-- core and Assembly  --}}
                                <div class="card card-body my-1 py-1">
                                    <div style="padding: 5px;">
                                        <!-- tampilan total hour pada tiap work center  -->
                                        <div class="row align-items-center ">
                                            <div class="input-group input-group-md justify-content-center">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">CORE & ASSEMBLY</span>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-warning"
                                                        id="preview-hour_coreassembly"></span>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">HOUR</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- kolom isi  -->
                                        <div class="align-items-center justify-content-left pt-1 px-1">
                                            <table class="w-100">
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->
                                                    <td class="w-20">
                                                        <h6 class="border border-dark rounded p-1 text-center"
                                                            id="preview-hour_typesusuncore">XX
                                                        </h6>
                                                    </td>
                                                    <!-- nama proses-->
                                                    <td class="w-30">
                                                        <h6 class="border border-dark rounded p-1 text-center">Type
                                                            Susun Core</h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td class="w-50">
                                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                                            id="preview-typesusuncore"></h6>
                                                    </td>
                                                </tr>
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->
                                                    <td class="w-20">
                                                        <h6 class="border border-dark rounded p-1 text-center"
                                                            id="preview-hour_hvconnection">XX
                                                        </h6>
                                                    </td>
                                                    <!-- nama proses-->
                                                    <td class="w-30">
                                                        <h6 class="border border-dark rounded p-1 text-center">HV Connection</h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td class="w-50">
                                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                                            id="preview-hvconnection"></h6>
                                                    </td>
                                                </tr>
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->
                                                    <td class="w-20">
                                                        <h6 class="border border-dark rounded p-1 text-center"
                                                            id="preview-hour_lvconnection">XX
                                                        </h6>
                                                    </td>
                                                    <!-- nama proses-->
                                                    <td class="w-30">
                                                        <h6 class="border border-dark rounded p-1 text-center">LV Connection</h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td class="w-50">
                                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                                            id="preview-lvconnection"></h6>
                                                    </td>
                                                </tr>
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center"
                                                            id="preview-hour_wiring">XX
                                                        </h6>
                                                    </td>
                                                    <!-- nama proses-->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center">Wiring
                                                        </h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td>
                                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                                            id="preview-wiring"></h6>
                                                    </td>
                                                </tr>
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center"
                                                            id="preview-hour_instalhousing">
                                                        </h6>
                                                    </td>
                                                    <!-- nama proses-->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center">Instal
                                                            Housing</h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td>
                                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                                            id="preview-instalhousing"></h6>

                                                    </td>
                                                </tr>
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->

                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center"
                                                            id="preview-hour_bongkarhousing">
                                                        </h6>
                                                    </td>
                                                    <!-- nama proses-->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center">Bongkar
                                                            Housing</h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td>
                                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                                            id="preview-bongkarhousing"></h6>

                                                    </td>
                                                </tr>
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center"
                                                            id="preview-hour_pembuatanculink">
                                                        </h6>
                                                    </td>
                                                    <!-- nama proses-->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center">
                                                            Pembuatan CU Link
                                                        </h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td>
                                                        <h6 class=" border bg-warning rounded p-1 text-center"
                                                            id="preview-pembuatanculink"></h6>
                                                    </td>
                                                </tr>
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center"
                                                            id="preview-hour_others"></h6>
                                                    </td>
                                                    <!-- nama proses-->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center">Others
                                                        </h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td style="width:500px ">
                                                        <div
                                                            class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center ">
                                                            <div class="row align-items-center">
                                                                <input type="checkbox" disabled
                                                                    class="checkbox-input mr-1"
                                                                    id="preview-others_pembuatancubar">
                                                                <label class="m-0"
                                                                    for="preview-others_pembuatancubar">Pembuatan CU
                                                                    Bar</label>
                                                            </div>
                                                            <div class="row align-items-center">
                                                                <input type="checkbox" disabled
                                                                    class="checkbox-input mr-1"
                                                                    id="preview-others_assemblystacking">
                                                                <label class="m-0"
                                                                    for="preview-others_assemblystacking">Assembly Stacking</label>
                                                            </div>
                                                            <div class="row align-items-center">
                                                                <input type="checkbox" disabled
                                                                    class="checkbox-input mr-1"
                                                                    id="preview-others_finishing">
                                                                <label class="m-0"
                                                                    for="preview-others_finishing">Finishing</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center"
                                                            id="preview-hour_accessories">Hour</h6>
                                                    </td>
                                                    <!-- nama proses-->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center">
                                                            Accessories</h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td style="width:500px ">
                                                        <div
                                                            class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center ">
                                                            <div class="row align-items-center">
                                                                <input type="checkbox" disabled
                                                                    class="checkbox-input mr-1"
                                                                    id="preview-accessories_fan">
                                                                <label class="m-0"
                                                                    for="preview-accessories_fan">Fan</label>
                                                            </div>
                                                            <div class="row align-items-center">
                                                                <input type="checkbox" disabled
                                                                    class="checkbox-input mr-1"
                                                                    id="preview-accessories_oltc">
                                                                <label class="m-0"
                                                                    for="preview-accessories_oltc">OLTC</label>
                                                            </div>
                                                            <div class="row align-items-center">
                                                                <input type="checkbox" disabled
                                                                    class="checkbox-input mr-1"
                                                                    id="preview-accessories_lem_spacer_block_airgap">
                                                                <label class="m-0"
                                                                    for="preview-accessories_lem_spacer_block_airgap">Lem
                                                                    Spacer
                                                                    Block/Air Gap</label>
                                                            </div>
                                                            <div class="row align-items-center">
                                                                <input type="checkbox" disabled
                                                                    class="checkbox-input mr-1"
                                                                    id="preview-accessories_pullingboard">
                                                                <label class="m-0"
                                                                    for="preview-accessories_pullingboard">Pulling Board</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr !important>
                                                    <!-- tampilan hour dari inputan  -->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center"
                                                            id="preview-hour_potongisolasifiber">
                                                        </h6>

                                                    </td>
                                                    <!-- nama proses-->
                                                    <td>
                                                        <h6 class="border border-dark rounded p-1 text-center">Potong
                                                            Isolasi Fiber</h6>
                                                    </td>
                                                    <!-- inputan spek -->
                                                    <td style="width:500px ">
                                                        <div class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center ">
                                                            <div class="row align-items-center">
                                                                <input type="checkbox" disabled
                                                                    class="checkbox-input mr-1"
                                                                    id="preview-potongisolasifiber_fixingpartinsulation">
                                                                <label class="m-0"
                                                                    for="preview-potongisolasifiber_fixingpartinsulation">Fixing
                                                                    Part
                                                                    Insulation</label>
                                                            </div>
                                                        </div>
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

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>