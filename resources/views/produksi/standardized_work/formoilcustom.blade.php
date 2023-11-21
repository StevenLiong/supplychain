@extends('layout')
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
                        <a href="/Home" class="btn btn-primary m-2"><i class="fa-solid fa-circle-xmark mr-2"></i>Cancel</a>
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
                            <label>SO /No. Prospek</label>
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
                                <div class="input-group mb-3" style="width:50%; text-align: center;height:30px;">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 18px;" class="input-group-text">COIL MAKING</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
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
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">Coil LV</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px">
                                            <select class="form-control" id="validationCustom04" required="">
                                                <option selected="" disabled="" value="">Sheet Konduktor 1</option>
                                                <option>Sheet Konduktor 2</option>
                                                <option>Sheet Konduktor (2 Section)</option>
                                                <option>Flat Cylindrical Konduktor 1</option>
                                                <option>Flat Cylindrical Konduktor 2</option>
                                                <option>Flat Cylindrical Konduktor 3</option>
                                                <option>Flat Cylindrical Konduktor 4</option>
                                                <option>Flat Helical</option>
                                                <option>Flat Disc Konduktor 1</option>
                                                <option>Flat Disc Konduktor 2</option>
                                                <option>Flat Disc Konduktor 3</option>
                                                <option>Flat Disc Konduktor 4</option>
                                            </select>
                                            <div class="checkbox d-inline-block mr-3">
                                                <table>
                                                    <tr>
                                                        <td><input type="checkbox" class="checkbox-input" id="Leadwire">
                                                        <label for="Leadwire">Leadwire</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Groundshield">
                                                            <label for="Groundshield">Groundshield</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Transpose">
                                                            <label for="Transpose">Transpose</label>
                                                        </td>
                                                    </tr>
                                                </table>
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
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">Coil HV</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px">
                                            <select class="form-control" id="validationCustom04" required="">
                                                <option selected="" disabled="" value="">Sheet Konduktor 1</option>
                                                <option>Sheet Konduktor 2</option>
                                                <option>Round Cylindrical Konduktor 1</option>
                                                <option>Round Cylindrical Konduktor 2</option>
                                                <option>Flat Cylindrical Konduktor 1</option>
                                                <option>Flat Cylindrical Konduktor 2</option>
                                                <option>Flat Cylindrical Konduktor 3</option>
                                                <option>Flat Cylindrical Konduktor 4</option>
                                                <option>2 Section</option>
                                                <option>4 Section</option>
                                                <option>FR OLTC</option>
                                                <option>Flat Disc Konduktor 1</option>
                                                <option>Flat Disc Konduktor 2</option>
                                                <option>Flat Disc Konduktor 3</option>
                                                <option>Flat Disc Konduktor 4</option>
                                            </select>
                                            <div class="checkbox d-inline-block mr-3">
                                                <table>
                                                    <tr>
                                                        <td><input type="checkbox" class="checkbox-input" id="Transpose">
                                                        <label for="Transpose">Transpose</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Press Coil">
                                                            <label for="Press Coil">Press Coil</label>
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

                    <!-- Core-Coil Assembly  -->
                    <div class="card card-body">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center justify-content-center ">
                                <div class="input-group mb-3" style="width:60%; text-align: center;height:30px;">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 18px;" class="input-group-text">CORE-COIL ASSEMBLY</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
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
                                                        <td><input type="checkbox" class="checkbox-input" id="Transpose">
                                                        <label for="Transpose">Wound Kotak</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Press Coil">
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
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
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
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">Connection</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px">
                                            <select class="form-control" id="validationCustom04" required="">
                                                <option selected="" disabled="" value="">Off Load</option>
                                                <option>On Load</option>
                                                <option>Chang Over Board</option>
                                                <option>Double Tap</option>
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
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
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
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">Final Assy</h6>
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
                                                        <td><input type="checkbox" class="checkbox-input" id="Leadwire">
                                                        <label for="Leadwire">Standard</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Groundshield">
                                                            <label for="Groundshield">Non Standard</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Transpose">
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
                                        <span style="font-size: 18px;" class="input-group-text">SPECIAL ASSEMBLY FOR FINAL ASSEMBLY</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
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
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">XX</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td style=" width:40%">
                                            <h6 class="  p-2 pb-0" style="border-style:solid;text-align: center;border-radius: 10px; border-width: 2px;">Special Assembly</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td style="width:500px ">
                                            <div class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center ">
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Radiator Valve">
                                                    <label class="m-0" for="Radiator Valve">Radiator Valve</label>
                                                </div>
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Side Wall">
                                                    <label class="m-0" for="Side Wall">Side Wall</label>
                                                </div>
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Tap Changer Rotary">
                                                    <label class="m-0" for="Tap Changer Rotary">Tap Changer Rotary</label>
                                                </div>
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Assembly Pad Mounted">
                                                    <label class="m-0" for="Assembly Pad Mounted">Assembly Pad Mounted</label>
                                                </div>
                                                <div class="row align-items-center">
                                                    <input type="checkbox" class="checkbox-input mr-1" id="Assembly Pole Mounted">
                                                    <label class="m-0" for="Assembly Pole Mounted">Assembly Pole Mounted</label>
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
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
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
                                                            <input type="checkbox" class="checkbox-input" id="Rapid Pressure Rise Relay">
                                                            <label for="Rapid Pressure Rise Relay">Rapid Pressure Rise Relay</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="MOLG">
                                                            <label for="MOLG">MOLG</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Winding Thermometer">
                                                            <label for="Winding Thermometer">Winding Thermometer</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="PRD">
                                                            <label for="PRD">PRD</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="DGPT C/W Control Box">
                                                            <label for="DGPT C/W Control Box">DGPT C/W Control Box</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Control VT">
                                                            <label for="Control VT">Control VT</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Membran Separator">
                                                            <label for="Membran Separator">Membran Separator</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Differential VT">
                                                            <label for="Differential VT">Differential VT</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Dial Thermometer">
                                                            <label for="Dial Thermometer">Dial Thermometer</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Fan">
                                                            <label for="Fan">Fan</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Oil Thermometer">
                                                            <label for="Oil Thermometer">Oil Thermometer</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="NGR">
                                                            <label for="NGR">NGR</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Buccholz Relay">
                                                            <label for="Buccholz Relay">Buccholz Relay</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Arrester">
                                                            <label for="Arrester">Arrester</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" class="checkbox-input" id="Anti Vibration">
                                                            <label for="Anti Vibration">Anti Vibration</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Heater">
                                                            <label for="Heater">Heater</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="OLTC">
                                                            <label for="OLTC">OLTC</label>
                                                        </td>    
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="PT-100">
                                                            <label for="PT-100">PT-100</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Cable Box LV/HV">
                                                            <label for="Cable Box LV/HV">Cable Box LV/HV</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="LV + HV">
                                                            <label for="Cable Box LV + HV">Cable Box LV + HV</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Wiring Control Box Standard">
                                                            <label for="Wiring Control Box Standard">Wiring Control Box Standard</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Wiring Control Box Non Standard">
                                                            <label for="Wiring Control Box Non Standard">Wiring Control Box Non Standard</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" class="checkbox-input" id="Copper Link LV/HV (Standard)">
                                                        <label for="Copper Link LV/HV (Standard)">Copper Link LV/HV (Standard)</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Copper Link LV + HV (Standard)">
                                                            <label for="Copper Link LV + HV (Standard)">Copper Link LV + HV (Standard)</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <td><input type="checkbox" class="checkbox-input" id="Copper Link LV/HV (Non Standard)">
                                                        <label for="Copper Link LV/HV (Non Standard)">Copper Link LV/HV (Non Standard)</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Copper Link LV + HV (Non Standard)">
                                                            <label for="Copper Link LV + HV (Non Standard)">Copper Link LV + HV (Non Standard)</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" class="checkbox-input" id="Radiator Panel Bongkar">
                                                        <label for="Radiator Panel Bongkar">Radiator Panel Bongkar</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Radiator Panel Pasang">
                                                            <label for="Radiator Panel Pasang">Radiator Panel Pasang</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Conservator Bongkar">
                                                            <label for="Conservator Bongkar">Conservator Bongkar</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Conservator Pasang">
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
                                        <span style="font-size: 18px;" class="input-group-text bg-warning"><b>05</b></span>
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
                                                        <td><input type="checkbox" class="checkbox-input" id="Routing Test">
                                                            <label for="Routing Test">Routing Test</label>
                                                        </td>
                                                        <td><input type="checkbox" class="checkbox-input" id="Noise">
                                                            <label for="Noise">Noise</label>
                                                        </td>
                                                        <td><input type="checkbox" class="checkbox-input" id="Lightning Impluse">
                                                            <label for="Lightning Impluse">Lightning Impluse</label>
                                                        </td>
                                                        <td><input type="checkbox" class="checkbox-input" id="SFRA">
                                                            <label for="SFRA">SFRA</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" class="checkbox-input" id="Temperature Rise">
                                                            <label for="Temperature Rise">Temperature Rise</label>
                                                        </td>   
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="PD">
                                                            <label for="PD">PD</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="Tan Delta">
                                                            <label for="Tan Delta">Tan Delta</label>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="checkbox-input" id="DGA">
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
@endsection