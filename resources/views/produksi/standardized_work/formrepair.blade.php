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
<h5 class="text-center my-3 header-title card-title " style="font-size: 40px;color:#d02424;"><b>PERHITUNGAN MAN HOUR</b></h5>

<form class="login-content floating-label ">
    <div class="row px-2">
        <div class="col-lg-12 mb-0">
            <!-- Total Hour -->
            <div class="card card-body">
                <!-- tampilan total hour pada tiap work center  -->
                <div class="row align-items-center justify-content-center px-3">
                    <div class="col  text-left input-group" style="width:50%; text-align: center;">
                        <div class="input-group-prepend">
                            <span style="font-size: 25px;" class="input-group-text"><b>TOTAL HOUR</b></span>
                        </div>
                        <div class="input-group-append">
                            <span style="font-size: 25px;" class="input-group-text bg-warning"><b>05</b></span>
                        </div>
                    </div>

                    <div class="col  text-right">
                        <a href="#" class="btn btn-warning m-2" data-target="#new-project-modal" data-toggle="modal"><i class="fa-solid fa-rotate-left mr-2"></i>Reset</a>
                        <a href="#" class="btn btn-primary m-2" data-target="#new-project-modal" data-toggle="modal"><i class="fa-regular fa-floppy-disk mr-2"></i>Save</a>
                        <a href="/" class="btn btn-primary m-2"><i class="fa-solid fa-circle-xmark mr-2"></i>Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row px-2">
        <div class="col-lg-12 mb-0">
            <div class="card card-body">
                <!-- head input  -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="floating-label form-group">
                            <input class="floating-input form-control" type="email" placeholder="">
                            <label>Category</label>
                        </div>
                        <div class="floating-label form-group">
                            <input class="floating-input form-control" type="email" placeholder="">
                            <label>Capacity</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="floating-label form-group">
                            <input class="floating-input form-control" type="email" placeholder="">
                            <label>No. Spek / Prospek</label>
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
                    <!--Untaking Hour  -->
                    <div class="card card-body">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center justify-content-center ">
                                <div class="input-group mb-3" style="width:50%; text-align: center;height:30px;">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 18px;" class="input-group-text">UNTAKING HOUR
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text">HOUR
                                    </div>
                                </div>
                            </div>
                            <!-- kolom isi  -->
                            <div class="align-items-center justify-content-left p-2">
                                <table>
                                    <tr style="height: 70px;" !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td style="width:10%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">On Cover Standard</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px">
                                            <select class="form-control" id="validationCustom04" required="">
                                                <option selected="" disabled="" value="">Flat-Konduktor 1</option>
                                                <option>Flat-Konduktor 2-3</option>
                                                <option>Flat-Konduktor 4-8</option>
                                                <option>Flat-Konduktor >8</option>
                                                <option>Sheet-Konduktor 1</option>
                                                <option>Sheet-Konduktor 2-3</option>
                                                <option>Sheet-Konduktor 4-8</option>
                                                <option>Sheet-Konduktor >8</option>
                                                <option>Round-Konduktor 1</option>
                                                <option>Round-Konduktor 2-3</option>
                                                <option>Round-Konduktor 4-8</option>
                                                <option>Round-Konduktor >8</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr style="height: 70px;" !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td style="width:10%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">Sidewall</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px">
                                            <select class="form-control" id="validationCustom04" required="">
                                                <option selected="" disabled="" value="">Flat-Konduktor 1</option>
                                                <option>Flat-Konduktor 2-3</option>
                                                <option>Flat-Konduktor 4-8</option>
                                                <option>Flat-Konduktor >8</option>
                                                <option>Sheet-Konduktor 1</option>
                                                <option>Sheet-Konduktor 2-3</option>
                                                <option>Sheet-Konduktor 4-8</option>
                                                <option>Sheet-Konduktor >8</option>
                                                <option>Round-Konduktor 1</option>
                                                <option>Round-Konduktor 2-3</option>
                                                <option>Round-Konduktor 4-8</option>
                                                <option>Round-Konduktor >8</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Bongkar  -->
                    <div class="card card-body">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center  justify-content-center">
                                <div class="input-group mb-3 justify-content-center" style="width:50%; text-align: center;height:30px;">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 18px;" class="input-group-text">BONGKAR
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text">HOUR
                                    </div>
                                </div>
                            </div>
                            <!-- kolom isi  -->
                            <div class="justify-content-left px-2" style="">
                                <table>
                                    <tr>
                                        <div class="row px-3 mt-3 mb-2 ">
                                            <ul class="m-0 p-0">
                                                <input type="checkbox" class="checkbox-input " id="Conservator">
                                                <label class="mr-3" for="Conservator">Conservator</label>
                                            </ul>
                                            <ul class="m-0 p-0">
                                                <input type="checkbox" class="checkbox-input " id="Cable Box HV">
                                                <label class="mr-3" for="Cable Box HV">Cable Box HV</label>
                                            </ul>
                                            <ul class="m-0 p-0">
                                                <input type="checkbox" class="checkbox-input " id="Cable Box LV">
                                                <label class="mr-3" for="Cable Box LV">Cable Box LV</label>
                                            </ul>
                                            <ul class="m-0 p-0">
                                                <input type="checkbox" class="checkbox-input " id="Cable Box HV-LV">
                                                <label class="mr-3" for="Cable Box HV-LV">Cable Box HV-LV</label>
                                            </ul>
                                        </div>
                                    </tr>
                                    <!-- Radiator  -->
                                    <tr style="height: 70px;" !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td style="width:10%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">Radiator</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px ">
                                            <div class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center ">
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="S/D 4 Susun">
                                                    <label class="m-0" for="S/D 4 Susun">S/D 4 Susun</label>
                                                </div>
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="S/D 8 Susun">
                                                    <label class="m-0" for="S/D 8 Susun">S/D 8 Susun</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Accessories/Proteksi  -->
                                    <tr style="" >
                                        <!-- tampilan hour dari inputan  -->
                                        <td style="width:10%;vertical-align: top;">
                                            <h6 class="  p-2 pb-0" style=" border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%;vertical-align: top;">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">Accessories/Proteksi</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px;vertical-align: top;">
                                            <div class="ml-3 form-group checkbox d-inline-block ">
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Bushing HV">
                                                    <label class="m-0" for="Bushing HV">Bushing HV</label>
                                                </div>
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Bushing LV">
                                                    <label class="m-0" for="Bushing LV">Bushing LV</label>
                                                </div>
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Oil Level Indicator">
                                                    <label class="m-0" for="Oil Level Indicator">Oil Level Indicator</label>
                                                </div>
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Winding Thermometer">
                                                    <label class="m-0" for="Winding Thermometer">Winding Thermometer</label>
                                                </div>
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Pressure Relief Device">
                                                    <label class="m-0" for="Pressure Relief Device">Pressure Relief Device</label>
                                                </div>
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Buccholz Relay">
                                                    <label class="m-0" for="Buccholz Relay">Buccholz Relay</label>
                                                </div>
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Thermometer">
                                                    <label class="m-0" for="Thermometer">Thermometer</label>
                                                </div>
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="OLTC">
                                                    <label class="m-0" for="OLTC">OLTC</label>
                                                </div>
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Motor Drive">
                                                    <label class="m-0" for="Motor Drive">Motor Drive</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="height: 70px;" !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td style="width:10%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">Angkat Coil</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px ">
                                            <div class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center ">

                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Wound">
                                                    <label class="m-0" for="Wound">Wound</label>
                                                </div>
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Bongkar Total">
                                                    <label class="m-0" for="Bongkar Total">Bongkar Total</label>
                                                </div>
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Yoke Core Atas">
                                                    <label class="m-0" for="Yoke Core Atas">Yoke Core Atas</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Coil Making  -->
                    <div class="card card-body">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center  justify-content-center">
                                <div class="input-group mb-3 justify-content-center" style="width:50%; text-align: center;height:30px;">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 18px;" class="input-group-text">COIL MAKING</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text">HOUR
                                    </div>
                                </div>
                            </div>
                            <!-- kolom isi  -->
                            <div class="align-items-center justify-content-left p-2" style="">
                                <table>
                                    <!-- Coil LV -->
                                    <tr style="height: 70px;" !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td style="width:10%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">Coil LV</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px">
                                            <select class="form-control" id="validationCustom04" required="">
                                                <option selected="" disabled="" value="">Flat-Konduktor 1</option>
                                                <option>Flat-Konduktor 2-3</option>
                                                <option>Flat-Konduktor 4-8</option>
                                                <option>Flat-Konduktor >8</option>
                                                <option>Sheet-Konduktor 1</option>
                                                <option>Sheet-Konduktor 2-3</option>
                                                <option>Sheet-Konduktor 4-8</option>
                                                <option>Sheet-Konduktor >8</option>
                                                <option>Round-Konduktor 1</option>
                                                <option>Round-Konduktor 2-3</option>
                                                <option>Round-Konduktor 4-8</option>
                                                <option>Round-Konduktor >8</option>
                                            </select>
                                            <div class="row  ">
                                                <div class="col">
                                                    <input type="checkbox" class="checkbox-input" id="Leadwire">
                                                    <label class="m-0" for="Leadwire">Leadwire</label>
                                                </div>
                                                <div class="col">
                                                    <input type="checkbox" class="checkbox-input" id="Groundshield">
                                                    <label class="m-0" for="Groundshield">Groundshield</label>
                                                </div>
                                                <div class="col ">
                                                    <input type="checkbox" class="checkbox-input" id="Tanspose">
                                                    <label class="m-0" for="Tanspose">Transpose</label>
                                                </div>
                                            </div>
                                        </td>


                                        </td>
                                    </tr>
                                    <!-- Coil HV -->
                                    <tr style="height: 70px;" !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td style="width:10%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">Coil HV</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px">
                                            <select class="form-control" id="validationCustom04" required="">
                                                <option selected="" disabled="" value="">Flat-Konduktor 1</option>
                                                <option>Flat-Konduktor 2-3</option>
                                                <option>Flat-Konduktor 4-8</option>
                                                <option>Flat-Konduktor >8</option>
                                                <option>Sheet-Konduktor 1</option>
                                                <option>Sheet-Konduktor 2-3</option>
                                                <option>Sheet-Konduktor 4-8</option>
                                                <option>Sheet-Konduktor >8</option>
                                                <option>Round-Konduktor 1</option>
                                                <option>Round-Konduktor 2-3</option>
                                                <option>Round-Konduktor 4-8</option>
                                                <option>Round-Konduktor >8</option>
                                            </select>
                                            <input type="checkbox" class="checkbox-input" id="Transpose">
                                            <label class="mr-2" for="Transpose">Transpose</label>

                                            <input type="checkbox" class="checkbox-input" id="Press Coil">
                                            <label class="m-0" for="Press Coil">Press Coil</label>


                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Core & Assembly  -->
                    <div class="card card-body">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center  justify-content-center">
                                <div class="input-group mb-3 justify-content-center" style="width:50%; text-align: center;height:30px;">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 18px;" class="input-group-text">CORE & ASSEMBLY</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text">HOUR
                                    </div>
                                </div>
                            </div>
                            <!-- kolom isi  -->
                            <div class="align-items-center justify-content-left p-2" style="">
                                <div class="row  ">
                                    <div class="col">
                                        <input type="checkbox" class="checkbox-input" id="Stacking Kotak">
                                        <label class="m-0" for="Stacking Kotak">Stacking Kotak</label>
                                    </div>
                                    <div class="col">
                                        <input type="checkbox" class="checkbox-input" id="Wound Kotak">
                                        <label class="m-0" for="Wound Kotak">Wound Kotak</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Connection Assembly  -->
                    <div class="card card-body">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center justify-content-center ">
                                <div class="input-group mb-3" style="width:50%; text-align: center;height:30px;">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 18px;" class="input-group-text">CONNECTION ASSEMBLY
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text">HOUR
                                    </div>
                                </div>
                            </div>
                            <!-- kolom isi  -->
                            <div class="align-items-center justify-content-left p-2">
                                <table>
                                    <tr style="height: 70px;" !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td style="width:10%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">Connection Final Assembly</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px">
                                            <select class="form-control" id="validationCustom04" required="">
                                                <option selected="" disabled="" value="">Flat-Konduktor 1</option>
                                                <option>Flat-Konduktor 2-3</option>
                                                <option>Flat-Konduktor 4-8</option>
                                                <option>Flat-Konduktor >8</option>
                                                <option>Sheet-Konduktor 1</option>
                                                <option>Sheet-Konduktor 2-3</option>
                                                <option>Sheet-Konduktor 4-8</option>
                                                <option>Sheet-Konduktor >8</option>
                                                <option>Round-Konduktor 1</option>
                                                <option>Round-Konduktor 2-3</option>
                                                <option>Round-Konduktor 4-8</option>
                                                <option>Round-Konduktor >8</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr style="height: 70px;" !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td style="width:10%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">HV Connection</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px">
                                            <select class="form-control" id="validationCustom04" required="">
                                                <option selected="" disabled="" value="">Flat-Konduktor 1</option>
                                                <option>Flat-Konduktor 2-3</option>
                                                <option>Flat-Konduktor 4-8</option>
                                                <option>Flat-Konduktor >8</option>
                                                <option>Sheet-Konduktor 1</option>
                                                <option>Sheet-Konduktor 2-3</option>
                                                <option>Sheet-Konduktor 4-8</option>
                                                <option>Sheet-Konduktor >8</option>
                                                <option>Round-Konduktor 1</option>
                                                <option>Round-Konduktor 2-3</option>
                                                <option>Round-Konduktor 4-8</option>
                                                <option>Round-Konduktor >8</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--Final Assembly  -->
                    <div class="card card-body">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center justify-content-center ">
                                <div class="input-group mb-3" style="width:50%; text-align: center;height:30px;">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 18px;" class="input-group-text">FINAL ASSEMBLY
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text">HOUR
                                    </div>
                                </div>
                            </div>
                            <!-- kolom isi  -->
                            <div class="align-items-center justify-content-left p-2">
                                <table>
                                    <tr style="height: 70px;" !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td style="width:10%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">LV Connection</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px">
                                            <select class="form-control" id="validationCustom04" required="">
                                                <option selected="" disabled="" value="">Flat-Konduktor 1</option>
                                                <option>Flat-Konduktor 2-3</option>
                                                <option>Flat-Konduktor 4-8</option>
                                                <option>Flat-Konduktor >8</option>
                                                <option>Sheet-Konduktor 1</option>
                                                <option>Sheet-Konduktor 2-3</option>
                                                <option>Sheet-Konduktor 4-8</option>
                                                <option>Sheet-Konduktor >8</option>
                                                <option>Round-Konduktor 1</option>
                                                <option>Round-Konduktor 2-3</option>
                                                <option>Round-Konduktor 4-8</option>
                                                <option>Round-Konduktor >8</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr style="height: 70px;" !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td style="width:10%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">Accesories</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px ">
                                            <div class=" form-group checkbox m-0">
                                                <input type="checkbox" class="checkbox-input " id="Standard">
                                                <label class="m-0 mr-2" for="Standard">Standard</label>
                                                <input type="checkbox" class="checkbox-input" id="Non Standard">
                                                <label class="m-0" for="Non Standard">Non Standard</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="height: 70px;" !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td style="width:10%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">Special Assembly</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px ">
                                            <div class="checkbox d-inline-block mr-3">
                                                <input type="checkbox" class="checkbox-input " id="Radiator Valve">
                                                <label class="m-0 mr-2" for="Radiator Valve">Radiator Valve</label>
                                            </div>
                                            <div class="checkbox d-inline-block mr-3">
                                                <input type="checkbox" class="checkbox-input" id="Side Wall">
                                                <label class="m-0" for="Side Wall">Side Wall</label>
                                            </div>
                                            <div class="checkbox d-inline-block mr-3">
                                                <input type="checkbox" class="checkbox-input" id="Type Changer Rotary">
                                                <label class="m-0" for="Type Changer Rotary">Type Changer Rotary</label>
                                            </div>
                                            <div class="checkbox d-inline-block mr-3">
                                                <input type="checkbox" class="checkbox-input" id="A. Pad Mounted">
                                                <label class="m-0" for="A. Pad Mounted">A. Pad Mounted</label>
                                            </div>
                                            <div class="checkbox d-inline-block mr-3">
                                                <input type="checkbox" class="checkbox-input" id="A. Pole Mounted">
                                                <label class="m-0" for="A. Pole Mounted">A. Pole Mounted</label>
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
                    <!-- finising  -->
                    <div class="card card-body">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center justify-content-center ">
                                <div class="input-group mb-3" style="width:50%; text-align: center;height:30px;">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 18px;" class="input-group-text">Finishing</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text">HOUR
                                    </div>
                                </div>
                            </div>
                            <!-- kolom isi  -->
                            <div class="row align-items-center justify-content-left p-2">
                                <div class="col">
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Rapid Pressure Rise Relay">
                                            <label class="m-0 mr-2" for="Rapid Pressure Rise Relay">Rapid Pressure Rise Relay</label>
                                        </div>
                                    </ul>
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Winding Thermometer">
                                            <label class="m-0 mr-2" for="Winding Thermometer">Winding Thermometer</label>
                                        </div>
                                    </ul>
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="DGPT C/W Control Box">
                                            <label class="m-0 mr-2" for="DGPT C/W Control Box">DGPT C/W Control Box</label>
                                        </div>
                                    </ul>
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Membran Separator">
                                            <label class="m-0 mr-2" for="Membran Separator">Membran Separator</label>
                                        </div>
                                    </ul>
                                </div>
                                <div class="col">
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Dial Thermometer">
                                            <label class="m-0 mr-2" for="Dial Thermometer">Dial Thermometer</label>
                                        </div>
                                    </ul>
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Oil Thermometer">
                                            <label class="m-0 mr-2" for="Oil Thermometer">Oil Thermometer</label>
                                        </div>
                                    </ul>
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Buccholz Relay">
                                            <label class="m-0 mr-2" for="Buccholz Relay">Buccholz Relay</label>
                                        </div>
                                    </ul>
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Anti Vibration">
                                            <label class="m-0 mr-2" for="Anti Vibration">Anti Vibration</label>
                                        </div>
                                    </ul>
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="OLTC">
                                            <label class="m-0 mr-2" for="OLTC">OLTC</label>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- cable box  -->
                    <div class="card card-body">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center justify-content-center ">
                                <div class="input-group mb-3" style="width:50%; text-align: center;height:30px;">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 18px;" class="input-group-text">Cabel Box</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text">HOUR
                                    </div>
                                </div>
                            </div>
                            <!-- kolom isi  -->
                            <div class="row align-items-center justify-content-left p-2">
                                <div class="col">
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="LV/HV">
                                            <label class="m-0 mr-2" for="LV/HV">LV/HV</label>
                                        </div>
                                    </ul>
                                </div>
                                <div class="col">
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="LV + HV">
                                            <label class="m-0 mr-2" for="LV + HV">LV + HV</label>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Wiring control box -->
                    <div class="card card-body">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center justify-content-center ">
                                <div class="input-group mb-3" style="width:50%; text-align: center;height:30px;">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 18px;" class="input-group-text">Wiring control box</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text">HOUR
                                    </div>
                                </div>
                            </div>
                            <!-- kolom isi  -->
                            <div class="row align-items-center justify-content-left p-2">
                                <div class="col">
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Standart">
                                            <label class="m-0 mr-2" for="Standart">Standart</label>
                                        </div>
                                    </ul>
                                </div>
                                <div class="col">
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Non Standart">
                                            <label class="m-0 mr-2" for="Non Standart">Non Standart</label>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Copper Link -->
                    <div class="card card-body">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center justify-content-center ">
                                <div class="input-group mb-3" style="width:50%; text-align: center;height:30px;">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 18px;" class="input-group-text">Copper Link</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text">HOUR
                                    </div>
                                </div>
                            </div>
                            <!-- kolom isi  -->
                            <div class="row align-items-center justify-content-left p-2">
                                <div class="col">
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="LV/HV (Standard)">
                                            <label class="m-0 mr-2" for="LV/HV (Standard)">LV/HV (Standard)</label>
                                        </div>
                                    </ul>
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="LV + HV (Standard)">
                                            <label class="m-0 mr-2" for="LV + HV (Standard)">LV + HV (Standard)</label>
                                        </div>
                                    </ul>
                                </div>
                                <div class="col">
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="LV/HV (Non Standard)">
                                            <label class="m-0 mr-2" for="LV/HV (Non Standard)">LV/HV (Non Standard)</label>
                                        </div>
                                    </ul>
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="LV + HV (Non Standard)">
                                            <label class="m-0 mr-2" for="LV + HV (Non Standard)">LV + HV (Non Standard)</label>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Radiator Panel -->
                    <div class="card card-body">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center justify-content-center ">
                                <div class="input-group mb-3" style="width:50%; text-align: center;height:30px;">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 18px;" class="input-group-text">Radiator Panel</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text">HOUR
                                    </div>
                                </div>
                            </div>
                            <!-- kolom isi  -->
                            <div class="row align-items-center justify-content-left p-2">
                                <div class="col">
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Bongkar radiator">
                                            <label class="m-0 mr-2" for="Bongkar radiator">Bongkar</label>
                                        </div>
                                    </ul>
                                </div>
                                <div class="col">
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Pasang">
                                            <label class="m-0 mr-2" for="Pasang">Pasang</label>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Conservator-->
                    <div class="card card-body">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center justify-content-center ">
                                <div class="input-group mb-3" style="width:50%; text-align: center;height:30px;">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 18px;" class="input-group-text">Conservator</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text">HOUR
                                    </div>
                                </div>
                            </div>
                            <!-- kolom isi  -->
                            <div class="row align-items-center justify-content-left p-2">
                                <div class="col">
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Bongkar">
                                            <label class="m-0 mr-2" for="Bongkar">Bongkar</label>
                                        </div>
                                    </ul>
                                </div>
                                <div class="col">
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Pasang">
                                            <label class="m-0 mr-2" for="Pasang">Pasang</label>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- QC Testing-->
                    <div class="card card-body">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center justify-content-center ">
                                <div class="input-group mb-3" style="width:50%; text-align: center;height:30px;">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 18px;" class="input-group-text">QC Testing</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text">HOUR
                                    </div>
                                </div>
                            </div>
                            <!-- kolom isi  -->
                            <div class="row align-items-center justify-content-left p-2">
                                <div class="col">
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Routine Test">
                                            <label class="m-0 mr-2" for="Routine Test">Routine Test</label>
                                        </div>
                                    </ul>
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Lighting Impluse">
                                            <label class="m-0 mr-2" for="Lighting Impluse">Lighting Impluse</label>
                                        </div>
                                    </ul>
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Temperature Rise">
                                            <label class="m-0 mr-2" for="Temperature Rise">Temperature Rise</label>
                                        </div>
                                    </ul>
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Tan Delta">
                                            <label class="m-0 mr-2" for="Tan Delta">Tan Delta</label>
                                        </div>
                                    </ul>
                                </div>
                                <div class="col">
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="Noise">
                                            <label class="m-0 mr-2" for="Noise">Noise</label>
                                        </div>
                                    </ul>
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="SFRA">
                                            <label class="m-0 mr-2" for="SFRA">SFRA</label>
                                        </div>
                                    </ul>
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="PD">
                                            <label class="m-0 mr-2" for="PD">PD</label>
                                        </div>
                                    </ul>
                                    <ul class="m-0 p-0">
                                        <div class="checkbox d-inline-block mr-3">
                                            <input type="checkbox" class="checkbox-input " id="GDA">
                                            <label class="m-0 mr-2" for="GDA">GDA</label>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
