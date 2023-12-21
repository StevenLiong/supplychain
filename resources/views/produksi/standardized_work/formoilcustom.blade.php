@extends('produksi.standardized_work.layout')
@section('content')
    <style>
        label {
            font-weight: bold;
        }

        .col-lg-6 {
            padding: 2;
        }

        td {
            padding-left: 5px;
            padding-right: 5px;
        }

        tr {
            padding-bottom: 0px;
        }

        .label {
            margin-bottom: 0px;
        }
    </style>
    <h5 class="text-center my-3 header-title card-title " style="font-size: 40px;color:#d02424;"><b>PERHITUNGAN MAN HOUR</b>
    </h5>

    <form class="login-content floating-label " method="post" action="{{ route('store.drynonresin') }}">
        @csrf
        <div class="row px-2">
            <div class="col-lg-12">
                <!-- Total Hour -->
                <div class="card card-body my-1 py-1">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <div class="alert-title">`````````````````
                                <h4>Whoops!</h4>
                            </div>
                            There are some problems with your input.
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <!-- tampilan total hour pada tiap work center -->
                    <div class="row align-items-center justify-content-center px-3 ">
                        <div class="col-lg-6 col-md-6 col-sm-12 text-left input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-size-lg"><b>TOTAL HOUR</b></span>
                            </div>
                            <div class="input-group-append">
                                <input type="text" class="input-group-text font-size-lg bg-warning" id="total_hour"
                                    name="total_hour" value="{{ old('total_hour') }}">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                            <button type="reset" class="btn btn-warning m-2">
                                <i class="fa-solid fa-rotate-left mr-2"> </i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary m-2"> <i
                                    class="fa-regular fa-floppy-disk mr-2"></i>Save</button>
                            <a href="#" class="btn btn-info m-2" data-target=".preview" onclick="previewForm()"
                                data-toggle="modal">
                                <i class="fa-solid fa-circle-check"></i>Preview
                            </a>
                            <a href="/standardized_work/home" class="btn btn-primary m-2">
                                <i class="fa-solid fa-circle-xmark mr-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row px-2">
            <div class="col-lg-12">
                <div class="card card-body my-1 pt-3 pb-0">
                    <!-- head input  -->
                    <div class="row">
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <input class="floating-input form-control" type="text" placeholder=""
                                    name="nama_product" value="Dry Cast Non Resin" id="category" disabled>
                                <label>Category</label>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" name="kategori" id="kategori"
                                        value="6">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <select class="floating-input form-control form-select input"name="ukuran_kapasitas"
                                    id="ukuran_kapasitas">
                                    @php
                                        $selectedValue = old('ukuran_kapasitas');
                                        $manhourData = $manhour->where('id_kategori_produk', '5')->unique('ukuran_kapasitas');
                                    @endphp
                                    <option value="">Pilih</option>
                                    @foreach ($manhourData as $data)
                                        <option value="{{ $data->ukuran_kapasitas }}"
                                            {{ $selectedValue == $data->ukuran_kapasitas ? 'selected' : '' }}>
                                            {{ $data->ukuran_kapasitas }}
                                        </option>
                                    @endforeach
                                </select>
                                <label>Capacity</label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <input class="floating-input form-control" type="text" placeholder="" name="nomor_so"
                                    value="{{ old('nomor_so') }}" id="so">
                                <label>SO / No. Prospek</label>
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
                    <div class="col-lg-6">
                        <!--Coil Making  -->
                        <div class="card card-body">
                            <div style="padding: 5px;">
                                <!-- tampilan total hour pada tiap work center  -->
                                <div class="row align-items-center justify-content-center ">
                                    <div class="input-group input-group-md justify-content-center">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">COIL MAKING</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalJam_value"></span>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- kolom isi  -->
                                <div class="align-items-center justify-content-left p-2">
                                    <table>
                                        <tr style="height: 70px;" !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td style="width:10%">
                                                <p class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;"
                                                    id="selectedInfo_coil_lv">
                                                    0</p>
                                            </td>
                                            <!-- nama proses-->
                                            <td style=" width:40%">
                                                <h6 class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">
                                                    Coil LV</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td style="width:500px">
                                                <select class="form-control" id="validationCustom04" name="z"
                                                    id="z">

                                                </select>

                                            </td>
                                        </tr>
                                        <tr style="height: 70px;" !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td style="width:10%">
                                                <p class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;"
                                                    id="selectedInfo_coil_lv_plus">
                                                    0</p>
                                            </td>
                                            <!-- nama proses-->
                                            <td style=" width:40%">
                                                <h6 class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">
                                                    Coil LV</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td style="width:500px">
                                                <select class="form-control" id="validationCustom04" name="coil_lv_plus"
                                                    id="coil_lv_plus">

                                                </select>

                                            </td>
                                        </tr>
                                        <tr style="height: 70px;" !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td style="width:10%">
                                                <p class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;"
                                                    id="selectedInfo_coil_hv">
                                                    0</p>
                                            </td>
                                            <!-- nama proses-->
                                            <td style=" width:40%">
                                                <h6 class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">
                                                    Coil HV</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td style="width:500px">
                                                <select class="form-control" id="validationCustom04" name="coil_hv"
                                                    id="coil_hv">

                                                </select>

                                            </td>
                                        </tr>
                                        <tr style="height: 70px;" !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td style="width:10%">
                                                <p class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;"
                                                    id="selectedInfo_coil_hv_plus">
                                                    0</p>
                                            </td>
                                            <!-- nama proses-->
                                            <td style=" width:40%">
                                                <h6 class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">
                                                    Coil HV</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td style="width:500px">
                                                <select class="form-control" id="validationCustom04" name="coil_hv_plus"
                                                    id="coil_hv_plus">

                                                </select>

                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Core-Coil Assembly  -->
                        <div class="card card-body">
                            <div style="padding: 5px;">
                                <!-- tampilan total hour pada tiap work center  -->
                                <div class="row align-items-center justify-content-center ">
                                    <div class="input-group mb-3" style="width:60%; text-align: center;height:30px;">
                                        <div class="input-group-prepend">
                                            <span style="font-size: 18px;" class="input-group-text">CORE-COIL
                                                ASSEMBLY</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span style="font-size: 18px;"
                                                class="input-group-text bg-warning"><b>05</b></span>
                                        </div>
                                        <div class="input-group-append">
                                            <span style="font-size: 18px;" class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- kolom isi  -->
                                <div class="align-items-center justify-content-left p-2">
                                    <table>
                                        <tr style="height: 70px;" !important>
                                            <!-- inputan spek -->
                                            <td style="width:500px">
                                                <div class="checkbox d-inline-block mr-3">
                                                    <table>
                                                        <tr>
                                                            <td><input type="checkbox" class="checkbox-input"
                                                                    id="Transpose">
                                                                <label for="Transpose">Wound Kotak</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Press Coil">
                                                                <label for="Press Coil">Stacking Kotak</label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Connection -->
                        <div class="card card-body">
                            <div style="padding: 5px;">
                                <!-- tampilan total hour pada tiap work center  -->
                                <div class="row align-items-center justify-content-center ">
                                    <div class="input-group mb-3" style="width:50%; text-align: center;height:30px;">
                                        <div class="input-group-prepend">
                                            <span style="font-size: 18px;" class="input-group-text">CONNECTION</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span style="font-size: 18px;"
                                                class="input-group-text bg-warning"><b>05</b></span>
                                        </div>
                                        <div class="input-group-append">
                                            <span style="font-size: 18px;" class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- kolom isi  -->
                                <div class="align-items-center justify-content-left p-2">
                                    <table>
                                        <tr style="height: 70px;" !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td style="width:10%">
                                                <h6 class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">
                                                    XX</h6>
                                            </td>
                                            <!-- nama proses-->
                                            <td style=" width:40%">
                                                <h6 class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">
                                                    Connection</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td style="width:500px">
                                                <select class="form-control" id="validationCustom04" required="">
                                                    <option selected="" disabled="" value="">Off Load
                                                    </option>
                                                    <option>On Load</option>
                                                    <option>Chang Over Board</option>
                                                    <option>Double Tap</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr style="height: 70px;" !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td style="width:10%">
                                                <h6 class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">
                                                    XX</h6>
                                            </td>
                                            <!-- nama proses-->
                                            <td style=" width:40%">
                                                <h6 class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">
                                                    HV Connection</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td style="width:500px">
                                                <select class="form-control" id="validationCustom04" required="">
                                                    <option selected="" disabled="" value="">Flat</option>
                                                    <option>Rail</option>
                                                    <option>Wire Soft</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Final Assembly -->
                        <div class="card card-body">
                            <div style="padding: 5px;">
                                <!-- tampilan total hour pada tiap work center  -->
                                <div class="row align-items-center justify-content-center ">
                                    <div class="input-group mb-3" style="width:50%; text-align: center;height:30px;">
                                        <div class="input-group-prepend">
                                            <span style="font-size: 18px;" class="input-group-text">FINAL ASSEMBLY</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span style="font-size: 18px;"
                                                class="input-group-text bg-warning"><b>05</b></span>
                                        </div>
                                        <div class="input-group-append">
                                            <span style="font-size: 18px;" class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- kolom isi  -->
                                <div class="align-items-center justify-content-left p-2">
                                    <table>
                                        <tr style="height: 70px;" !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td style="width:10%">
                                                <h6 class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">
                                                    XX</h6>
                                            </td>
                                            <!-- nama proses-->
                                            <td style=" width:40%">
                                                <h6 class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">
                                                    Final Assy</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td style="width:500px">
                                                <select class="form-control" id="validationCustom04" required="">
                                                    <option selected="" disabled="" value="">Flat</option>
                                                    <option>Rail</option>
                                                    <option>Wire Soft</option>
                                                </select>
                                                <div class="checkbox d-inline-block mr-3">
                                                    <table>
                                                        <tr>
                                                            <td><input type="checkbox" class="checkbox-input"
                                                                    id="Leadwire">
                                                                <label for="Leadwire">Standard</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Groundshield">
                                                                <label for="Groundshield">Non Standard</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Transpose">
                                                                <label for="Transpose">Pengisian Oli</label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- kanan  -->
                    <div class="col-lg-6">
                        <!-- Special Assembly For Final Assembly-->
                        <div class="card card-body">
                            <div style="padding: 5px;">
                                <!-- tampilan total hour pada tiap work center  -->
                                <div class="row align-items-center justify-content-center ">
                                    <div class="input-group mb-3" style="width:80%; text-align: center;height:30px;">
                                        <div class="input-group-prepend">
                                            <span style="font-size: 18px;" class="input-group-text">SPECIAL ASSEMBLY FOR
                                                FINAL ASSEMBLY</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span style="font-size: 18px;"
                                                class="input-group-text bg-warning"><b>05</b></span>
                                        </div>
                                        <div class="input-group-append">
                                            <span style="font-size: 18px;" class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- kolom isi  -->
                                <div class="align-items-center justify-content-left p-2">
                                    <table>
                                        <tr style="height: 70px;" !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td style="width:10%">
                                                <h6 class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">
                                                    XX</h6>
                                            </td>
                                            <!-- nama proses-->
                                            <td style=" width:40%">
                                                <h6 class="  p-2 pb-0"
                                                    style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">
                                                    Special Assembly</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td style="width:500px ">
                                                <div
                                                    class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center ">
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="Radiator Valve">
                                                        <label class="m-0" for="Radiator Valve">Radiator Valve</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="Side Wall">
                                                        <label class="m-0" for="Side Wall">Side Wall</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="Tap Changer Rotary">
                                                        <label class="m-0" for="Tap Changer Rotary">Tap Changer
                                                            Rotary</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="Assembly Pad Mounted">
                                                        <label class="m-0" for="Assembly Pad Mounted">Assembly Pad
                                                            Mounted</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="Assembly Pole Mounted">
                                                        <label class="m-0" for="Assembly Pole Mounted">Assembly Pole
                                                            Mounted</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Finishing -->
                        <div class="card card-body">
                            <div style="padding: 5px;">
                                <!-- tampilan total hour pada tiap work center  -->
                                <div class="row align-items-center justify-content-center ">
                                    <div class="input-group mb-3" style="width:50%; text-align: center;height:30px;">
                                        <div class="input-group-prepend">
                                            <span style="font-size: 18px;" class="input-group-text">FINISHING</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span style="font-size: 18px;"
                                                class="input-group-text bg-warning"><b>05</b></span>
                                        </div>
                                        <div class="input-group-append">
                                            <span style="font-size: 18px;" class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- kolom isi  -->
                                <div class="align-items-center justify-content-left p-2">
                                    <table>
                                        <tr style="height: 70px;" !important>
                                            <!-- inputan spek -->
                                            <td style="width:600px">
                                                <div class="checkbox d-inline-block mr-3">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Rapid Pressure Rise Relay">
                                                                <label for="Rapid Pressure Rise Relay">Rapid Pressure Rise
                                                                    Relay</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="MOLG">
                                                                <label for="MOLG">MOLG</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Winding Thermometer">
                                                                <label for="Winding Thermometer">Winding
                                                                    Thermometer</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="PRD">
                                                                <label for="PRD">PRD</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="DGPT C/W Control Box">
                                                                <label for="DGPT C/W Control Box">DGPT C/W Control
                                                                    Box</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Control VT">
                                                                <label for="Control VT">Control VT</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Membran Separator">
                                                                <label for="Membran Separator">Membran Separator</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Differential VT">
                                                                <label for="Differential VT">Differential VT</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Dial Thermometer">
                                                                <label for="Dial Thermometer">Dial Thermometer</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Fan">
                                                                <label for="Fan">Fan</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Oil Thermometer">
                                                                <label for="Oil Thermometer">Oil Thermometer</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="NGR">
                                                                <label for="NGR">NGR</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Buccholz Relay">
                                                                <label for="Buccholz Relay">Buccholz Relay</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Arrester">
                                                                <label for="Arrester">Arrester</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="checkbox" class="checkbox-input"
                                                                    id="Anti Vibration">
                                                                <label for="Anti Vibration">Anti Vibration</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Heater">
                                                                <label for="Heater">Heater</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="OLTC">
                                                                <label for="OLTC">OLTC</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="PT-100">
                                                                <label for="PT-100">PT-100</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Cable Box LV/HV">
                                                                <label for="Cable Box LV/HV">Cable Box LV/HV</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="LV + HV">
                                                                <label for="Cable Box LV + HV">Cable Box LV + HV</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Wiring Control Box Standard">
                                                                <label for="Wiring Control Box Standard">Wiring Control Box
                                                                    Standard</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Wiring Control Box Non Standard">
                                                                <label for="Wiring Control Box Non Standard">Wiring Control
                                                                    Box Non Standard</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="checkbox" class="checkbox-input"
                                                                    id="Copper Link LV/HV (Standard)">
                                                                <label for="Copper Link LV/HV (Standard)">Copper Link LV/HV
                                                                    (Standard)</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Copper Link LV + HV (Standard)">
                                                                <label for="Copper Link LV + HV (Standard)">Copper Link LV
                                                                    + HV (Standard)</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="checkbox" class="checkbox-input"
                                                                    id="Copper Link LV/HV (Non Standard)">
                                                                <label for="Copper Link LV/HV (Non Standard)">Copper Link
                                                                    LV/HV (Non Standard)</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Copper Link LV + HV (Non Standard)">
                                                                <label for="Copper Link LV + HV (Non Standard)">Copper Link
                                                                    LV + HV (Non Standard)</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="checkbox" class="checkbox-input"
                                                                    id="Radiator Panel Bongkar">
                                                                <label for="Radiator Panel Bongkar">Radiator Panel
                                                                    Bongkar</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Radiator Panel Pasang">
                                                                <label for="Radiator Panel Pasang">Radiator Panel
                                                                    Pasang</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Conservator Bongkar">
                                                                <label for="Conservator Bongkar">Conservator
                                                                    Bongkar</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Conservator Pasang">
                                                                <label for="Conservator Pasang">Conservator Pasang</label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>



                        <div class="card card-body">
                            <div style="padding: 5px;">
                                <!-- tampilan total hour pada tiap work center  -->
                                <div class="row align-items-center justify-content-center ">
                                    <div class="input-group mb-3" style="width:50%; text-align: center;height:30px;">
                                        <div class="input-group-prepend">
                                            <span style="font-size: 18px;" class="input-group-text">QC TESTING</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span style="font-size: 18px;"
                                                class="input-group-text bg-warning"><b>05</b></span>
                                        </div>
                                        <div class="input-group-append">
                                            <span style="font-size: 18px;" class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- kolom isi  -->
                                <div class="align-items-center justify-content-left p-2">
                                    <table>
                                        <tr style="height: 70px;" !important>
                                            <!-- inputan spek -->
                                            <td style="width:500px">
                                                <div class="checkbox d-inline-block mr-3">
                                                    <table>
                                                        <tr>
                                                            <td><input type="checkbox" class="checkbox-input"
                                                                    id="Routing Test">
                                                                <label for="Routing Test">Routing Test</label>
                                                            </td>
                                                            <td><input type="checkbox" class="checkbox-input"
                                                                    id="Noise">
                                                                <label for="Noise">Noise</label>
                                                            </td>
                                                            <td><input type="checkbox" class="checkbox-input"
                                                                    id="Lightning Impluse">
                                                                <label for="Lightning Impluse">Lightning Impluse</label>
                                                            </td>
                                                            <td><input type="checkbox" class="checkbox-input"
                                                                    id="SFRA">
                                                                <label for="SFRA">SFRA</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="checkbox" class="checkbox-input"
                                                                    id="Temperature Rise">
                                                                <label for="Temperature Rise">Temperature Rise</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="PD">
                                                                <label for="PD">PD</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="Tan Delta">
                                                                <label for="Tan Delta">Tan Delta</label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" class="checkbox-input"
                                                                    id="DGA">
                                                                <label for="DGA">DGA</label>
                                                            </td>
                                                        </tr>
                                                    </table>
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
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function fillSelect(elementId, data, selectedProses, selectedWorkcenter) {
                var filteredData = data.filter(function(item) {
                    return (
                        item.nama_kategoriproduk === 'DRY TYPE NON RESIN' &&
                        item.nama_workcenter === selectedWorkcenter &&
                        item.nama_proses === selectedProses
                    );
                });
                $(elementId).empty();
                $(elementId).append('<option value="">-Pilih-</option>');
                $.each(filteredData, function(key, data) {
                    $(elementId).append(
                        '<option value="' + data.nama_tipeproses + '" data-durasi="' + data
                        .durasi_manhour +
                        '" data-workcenter="' + data.nama_workcenter + '">' +
                        data.nama_tipeproses +
                        '</option>'
                    );
                });
            }
            $('#ukuran_kapasitas').on('change', function() {
                var ukuran_kapasitas = $(this).val();
                console.log(ukuran_kapasitas);
                if (ukuran_kapasitas) {
                    $.ajax({
                        url: '/standardized_work/Create-Data/Dry-Non-Resin/kapasitas/' +
                            ukuran_kapasitas,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            if (data) {
                                fillSelect('#coil_lv', data, 'COIL LV', 'COIL MAKING');
                                fillSelect('#coil_hv', data, 'COIL HV', 'COIL MAKING');
                                fillSelect('#potong_leadwire', data, 'POTONG LEAD WIRE',
                                    'COIL MAKING');
                                fillSelect('#potong_isolasi', data, 'POTONG ISOLASI',
                                    'COIL MAKING');
                                fillSelect('#moulding_casting', data, 'MOULD & CASTING',
                                    'MOULD & CASTING');
                                fillSelect('#type_susun_core', data, 'TYPE SUSUN CORE',
                                    'CORE COIL ASSEMBLY');
                                fillSelect('#hv_connection', data, 'HV CONNECTION',
                                    'CORE COIL ASSEMBLY');
                                fillSelect('#lv_connection', data, 'lV CONNECTION',
                                    'CORE COIL ASSEMBLY');
                                fillSelect('#wiring', data, 'WIRING', 'CORE COIL ASSEMBLY');
                                fillSelect('#instal_housing', data, 'INSTAL HOUSING',
                                    'CORE COIL ASSEMBLY');
                                fillSelect('#bongkar_housing', data, 'BONGKAR HOUSING',
                                    'CORE COIL ASSEMBLY');
                                fillSelect('#pembuatan_cu_link', data, 'PEMBUATAN CU LINK',
                                    'CORE COIL ASSEMBLY');
                                fillSelect('#others', data, 'OTHERS', 'CORE COIL ASSEMBLY');
                                fillSelect('#accesories', data, 'ACCESORIES',
                                    'CORE COIL ASSEMBLY');
                                fillSelect('#potong_isolasi_fiber', data,
                                    'POTONG ISOLASI FIBER', 'CORE COIL ASSEMBLY');
                                fillSelect('#qc_testing', data, 'ROUNTINE',
                                    'QC TESTv');
                                $('#coil_lv').on('change', function() {
                                    showSelected('z');
                                });
                                $('#coil_hv').on('change', function() {
                                    showSelected('coil_hv');
                                });
                                $('#potong_leadwire').on('change', function() {
                                    showSelected('potong_leadwire');
                                });
                                $('#potong_isolasi').on('change', function() {
                                    showSelected('potong_isolasi');
                                });
                                $('#moulding_casting').on('change', function() {
                                    showSelected('moulding_casting');
                                });
                                // $('#lv_bobbin').on('change', function() {
                                //     showSelected('lv_bobbin');
                                // });
                                // $('#lv_moulding').on('change', function() {
                                //     showSelected('lv_moulding');
                                // });
                                // $('#touch_up').on('change', function() {
                                //     showSelected('touch_up');
                                // });
                                $('#type_susun_core').on('change', function() {
                                    showSelected('type_susun_core');
                                });
                                $('#hv_connection').on('change', function() {
                                    showSelected('hv_connection');
                                });
                                $('#lv_connection').on('change', function() {
                                    showSelected('lv_connection');
                                });
                                $('#wiring').on('change', function() {
                                    showSelected('wiring');
                                });
                                $('#instal_housing').on('change', function() {
                                    showSelected('instal_housing');
                                });
                                $('#bongkar_housing').on('change', function() {
                                    showSelected('bongkar_housing');
                                });
                                $('#pembuatan_cu_link').on('change', function() {
                                    showSelected('pembuatan_cu_link');
                                });
                                $('#others').on('change', function() {
                                    showSelected('others');
                                });
                                $('#accesories').on('change', function() {
                                    showSelected('accesories');
                                });
                                $('#potong_isolasi_fiber').on('change', function() {
                                    showSelected('potong_isolasi_fiber');
                                });
                                $('#qc_testing').on('change', function() {
                                    showSelected('qc_testing');
                                });
                            } else {
                                resetForm();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Request Error:', xhr.responseText);
                            alert(
                                'Terjadi kesalahan saat mengambil data barang. Silakan coba lagi.'
                            );
                        }
                    });
                } else {
                    resetForm();
                }
            });
        });

        function showSelected(target) {
            let selectElements = document.querySelectorAll('select');
            let totalManhour = 0;
            selectElements.forEach(function(select) {
                let selectedOptions = Array.from(select.selectedOptions);
                selectedOptions.forEach(function(selectedOption) {
                    let durasi = selectedOption.getAttribute('data-durasi');
                    totalManhour += parseFloat(durasi || 0);
                });
            });
            let totalHourInput = document.getElementById('total_hour');
            totalHourInput.value = totalManhour;
            let select = document.getElementById(target);
            console.log('Select Element:', select);
            let selectedOptions = Array.from(select.selectedOptions);
            let totalDurasi = 0;
            selectedOptions.forEach(function(selectedOption) {
                let selectedDurasi = selectedOption.getAttribute('data-durasi');
                totalDurasi += parseFloat(selectedDurasi || 0);
            });
            let selectedInfo = document.getElementById("selectedInfo_" + target);
            console.log('Selected Info Element:', selectedInfo);
            selectedInfo.textContent = " " + totalDurasi;
            console.log(selectedInfo);
            console.log(totalDurasi);
        }

        function displayTotalJamCoilMaking() {
            let selectElements = document.querySelectorAll('select');
            let totalJam = 0;
            let workcenterInfo = {};
            selectElements.forEach(function(select) {
                let selectedOptions = Array.from(select.selectedOptions);
                selectedOptions.forEach(function(selectedOption) {
                    let durasi = parseFloat(selectedOption.getAttribute('data-durasi')) || 0;
                    let workCenterAttr = selectedOption.getAttribute('data-workcenter');
                    if (workCenterAttr === 'COIL MAKING') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            console.log("Work Center (COIL MAKING):", workcenterInfo);
            let totalJamElement = document.getElementById("totalJam_value");
            if (totalJamElement) {
                totalJamElement.textContent = totalJam;
            }
        }

        function displayTotalJamMouldCasting() {
            let selectElements = document.querySelectorAll('select');
            let totalJam = 0;
            let workcenterInfo = {};
            selectElements.forEach(function(select) {
                let selectedOptions = Array.from(select.selectedOptions);
                selectedOptions.forEach(function(selectedOption) {
                    let durasi = parseFloat(selectedOption.getAttribute('data-durasi')) || 0;
                    let workCenterAttr = selectedOption.getAttribute('data-workcenter');
                    if (workCenterAttr === 'MOULD & CASTING') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            console.log("Work Center (MOULD & CASTING):", workcenterInfo);
            let totalJamElement = document.getElementById("totalMouldCasting_value");
            if (totalJamElement) {
                totalJamElement.textContent = totalJam;
            }
        }

        function displayTotalJamCoreCoilAssembly() {
            let selectElements = document.querySelectorAll('select');
            let totalJam = 0;
            let workcenterInfo = {};
            selectElements.forEach(function(select) {
                let selectedOptions = Array.from(select.selectedOptions);
                selectedOptions.forEach(function(selectedOption) {
                    let durasi = parseFloat(selectedOption.getAttribute('data-durasi')) || 0;
                    let workCenterAttr = selectedOption.getAttribute('data-workcenter');
                    if (workCenterAttr === 'CORE COIL ASSEMBLY') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            console.log("Work Center (CORE COIL ASSEMBLY):", workcenterInfo);
            let totalJamElement = document.getElementById("totalCoreCoilAssembly_value");
            if (totalJamElement) {
                totalJamElement.textContent = totalJam;
            }
        }

        function displayTotalJamQCTest() {
            let selectElements = document.querySelectorAll('select');
            let totalJam = 0;
            let workcenterInfo = {};
            selectElements.forEach(function(select) {
                let selectedOptions = Array.from(select.selectedOptions);
                selectedOptions.forEach(function(selectedOption) {
                    let durasi = parseFloat(selectedOption.getAttribute('data-durasi')) || 0;
                    let workCenterAttr = selectedOption.getAttribute('data-workcenter');
                    if (workCenterAttr === 'QC TEST') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            console.log("Work Center (QC TEST):", workcenterInfo);
            let totalJamElement = document.getElementById("totalQCTest_value");
            if (totalJamElement) {
                totalJamElement.textContent = totalJam;
            }
        }
        document.querySelectorAll('select').forEach(function(select) {
            select.addEventListener('change', function() {
                let selectedOption = select.options[select.selectedIndex];
                let workCenter = selectedOption.getAttribute('data-workcenter');
                if (workCenter === 'COIL MAKING') {
                    displayTotalJamCoilMaking();
                } else if (workCenter === 'MOULD & CASTING') {
                    displayTotalJamMouldCasting();
                } else if (workCenter === 'CORE COIL ASSEMBLY') {
                    displayTotalJamCoreCoilAssembly();
                } else if (workCenter === 'QC TEST') {
                    displayTotalJamQCTest();
                }
            });
        });
    </script>
@endsection
