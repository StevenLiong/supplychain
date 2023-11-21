@extends('layout')
@section('content')

<style>
    label {
        font-weight: bold;
    }

    .label {
        margin-bottom: 0px;
    }
</style>
<h5 class="text-center rounded ml-2 text-sm-center text-xs-center my-1 header-title card-title" style="font-size: 30px;color:#d02424;"><b>PERHITUNGAN MAN HOUR</b></h5>

<form class="login-content floating-label ">
    <div class="row px-2">
        <div class="col-lg-12">
            <!-- Total Hour -->
            <div class="card card-body my-1 py-1">
                <!-- tampilan total hour pada tiap work center -->
                <div class="row align-items-center justify-content-center px-3 ">
                    <div class="col-lg-6 col-md-6 col-sm-12 text-left input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text font-size-lg"><b>TOTAL HOUR</b></span>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text font-size-lg bg-warning"><b>05</b></span>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                        <a href="#" class="btn btn-warning m-2" data-target="#new-project-modal" data-toggle="modal">
                            <i class="fa-solid fa-rotate-left mr-2"></i>Reset
                        </a>
                        <a href="#" class="btn btn-primary m-2" data-target="#new-project-modal" data-toggle="modal">
                            <i class="fa-regular fa-floppy-disk mr-2"></i>Save
                        </a>
                        <a href="/Home" class="btn btn-primary m-2">
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
                            <input class="floating-input form-control" type="email" placeholder="">
                            <label>Category</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="floating-label form-group">
                            <input class="floating-input form-control" type="email" placeholder="">
                            <label>Capacity</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="floating-label form-group">
                            <input class="floating-input form-control" type="email" placeholder="">
                            <label>SO / No. Prospek</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="row px-2">
                <div class="col-lg-12">
                    <!--Coil Making  -->
                    <div class="card card-body my-1 py-1">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center">
                                <div class="input-group input-group-md d-flex justify-content-center pb-2   ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">COIL MAKING</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">HOUR</span>
                                    </div>
                                </div>
                                <div class="input-group input-group-md d-flex justify-content-center">
                                    <div class="input-group input-group-md d-flex justify-content-center ">
                                        <div  style="width: 5rem">
                                            <h6 class="border border-dark rounded p-1 text-center" >XX</h6>
                                        </div>
                                        <div style="width: 10rem">
                                            <h6 class="border border-dark rounded p-1 text-center">Coil LV</h6>
                                        </div>
                                        <div class="input-group-append">
                                            <select class="form-control border border-dark rounded text-center" style="height: 33px;" id="validationCustom04" required="">
                                                <option >SHEET KONDUKTOR 1</option>
                                                <option>SHEET KONDUKTOR 2</option>
                                                <option>SHEET KONDUKTOR (2 SECTION)</option>
                                                <option>FLAT CYLINDRICAL KONDUKTOR 1</option>
                                            </select>
                                        </div>
                                        <div>
                                            <input type="text" value="LEADWIRE " readonly class=" text-center rounded ml-2" >

                                        </div>

                                    </div>
                                    <div class="input-group input-group-md d-flex justify-content-center">
                                        <div class="input-group-prepend">
                                            <div  style="width: 5rem">
                                                <h6 class="border border-dark rounded p-1 text-center" >XX</h6>
                                            </div>
                                            <div style="width: 10rem">
                                                <h6 class="border border-dark rounded p-1 text-center">Coil LV</h6>
                                            </div>
                                            <select class="w-75 form-control border border-dark rounded text-center" style="height: 33px;" id="validationCustom04" required="">
                                                <option selected="" disabled="" value="">ROUND CYLINDRICAL KONDUKTOR 1</option>
                                                <option>ROUND CYLINDRICAL KONDUKTOR 2</option>
                                                <option>FLAT CYLINDRICAL KONDUKTOR 1</option>
                                                <option>FLAT CYLINDRICAL KONDUKTOR 2</option>
                                            </select>
                                        </div>
                                        <div>
                                            <input type="text" value="PRESS COIL" readonly class="text-center rounded ml-2" >

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-body my-1 py-1">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center ">
                                <div class="input-group input-group-md d-flex justify-content-center pb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Core & Assembly</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">HOUR</span>
                                    </div>
                                </div>
                                <div class="input-group input-group-md d-flex justify-content-center">
                                    <div>
                                        <select class=" form-control border border-dark rounded text-center" style="height: 33px;" id="validationCustom04" required="">
                                                <option selected="" disabled="" value="">STACKING</option>
                                                <option>WOUND CORE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-body my-1 py-1">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center ">
                                <div class="input-group input-group-md d-flex justify-content-center pb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Connect</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">HOUR</span>
                                    </div>
                                </div>
                                <div class="input-group input-group-md d-flex justify-content-center">
                                    <div class="input-group-append">
                                        <input type="text" value="OFF LOAD" readonly class="text-center rounded ml-2" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-body my-1 py-1">
                        <div style="padding: 5px;">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center ">
                                <div class="input-group input-group-md d-flex justify-content-center pb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Final Assembly</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">HOUR</span>

                                    </div>
                                </div>
                                <div class="input-group input-group-md d-flex justify-content-center rounded">
                                    <div class="input-group-append">
                                        <input type="text" value="RAIL" readonly class="text-center rounded ml-2" >
                                    </div>
                                    <div class="input-group-append">
                                        <input type="text" value="STANDART" readonly class="text-center rounded ml-2" >
                                    </div>
                                    <div class="input-group-append">
                                        <input type="text" value="PENGISIAN OLIT" readonly class="text-center rounded ml-2" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="card card-body my-1 py-1">
                            <!-- tampilan total hour pada tiap work center  -->
                            <div class="row align-items-center ">
                                <div class="input-group input-group-md d-flex justify-content-center pb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">QC Testing</span>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-warning"><b>05</b></span>
                                    </div>
                                    <div class="input-group-append ">
                                        <span class="input-group-text ">HOUR</span>
                                    </div>
                                </div>
                                <div class="input-group input-group-md d-flex justify-content-center">
                                    <div class="input-group-append">
                                        <input type="text" value="ROUTINE TEST" readonly class="text-center rounded ml-2" >
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
    </div>
</form>
@endsection
