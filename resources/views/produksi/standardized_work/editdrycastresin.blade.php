@extends('produksi.standardized_work.layout')
@section('content')
    <div style="margin-bottom:350px; margin-top:10px;">
        <form class="login-content floating-label " method="post" action="{{ route('dryresin.update', $product->id) }}">
            @method('PUT')
            @csrf
            <div class="row px-2">
                <div class="col-lg-12">
                    <!-- Total Hour -->
                    <div class="card card-body my-1 py-1">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <div class="alert-title">
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
                                        name="total_hour" value="{{ old('total_hour', $product->total_hour) }}" readonly>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                                <button type="submit" class="btn btn-primary m-2"> <i
                                        class="fa-regular fa-floppy-disk mr-2"></i>Update</button>
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
                                        name="nama_product" value="Dry Cast Resin" id="category" disabled>
                                    <label style="border-radius: 40px;">Category</label>
                                    <div class="mb-3">
                                        <input type="hidden" class="form-control" name="kategori" id="kategori"
                                            value="{{ old('nama_product', $product->nama_product) }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="floating-label form-group">
                                    <select class="floating-input form-control form-select input"name="ukuran_kapasitas"
                                        id="ukuran_kapasitas" readonly>
                                        @php
                                            $selectedValue = old('ukuran_kapasitas', $product->ukuran_kapasitas);
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
                                    <label style="border-radius: 40px;">Capacity</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="floating-label form-group">
                                    <input class="floating-input form-control" type="text" placeholder="" name="nomor_so"
                                        value="{{ old('nomor_so', $product->nomor_so) }}" readonly>
                                    <label style="border-radius: 40px;">SO / No. Prospek</label>
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
                            <!--Coil Making  -->
                            <div class="card card-body my-1 py-1">
                                <div style="padding: 5px;">
                                    <!-- tampilan total hour pada tiap work center  -->
                                    <div class="row align-items-center ">
                                        <div class="input-group input-group-md justify-content-center">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">COIL MAKING</span>
                                            </div>
                                            <div class="input-group-append">
                                                <span type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                    id="totalHour_coil_making">{{ $product->totalHour_coil_making }}</span>
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
                                                <td>
                                                    <p class="border border-dark rounded text-center" style="width:100%;"
                                                        id="selectedInfo_coil_lv" name="hour_coil_lv">0</p>
                                                </td>
                                                <!-- nama proses-->
                                                <td class="w-30">
                                                    <h6 class=" border border-dark rounded p-1 text-center">Coil LV</h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td class="w-50">
                                                    <select
                                                        class="form-control form-select input border border-dark rounded text-center"
                                                        style="height: 33px;" name="coil_lv" id="coil_lv"
                                                        onchange="showSelected('coil_lv')">
                                                        @php
                                                            $selectedValue = old('coil_lv', $product->coil_lv);
                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'COIL MAKING')
                                                                ->where('nama_proses', 'COIL LV')
                                                                ->unique('nama_tipeproses');
                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="COIL MAKING"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>
                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr !important>
                                                <!-- tampilan hour dari inputan  -->
                                                <td>
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_coil_hv">0</p>
                                                </td>
                                                <!-- nama proses-->
                                                <td>
                                                    <h6 class=" border border-dark rounded p-1 text-center">Coil HV</h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td>
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        style="height: 33px;"name="coil_hv" id="coil_hv"
                                                        onchange="showSelected('coil_hv')">
                                                        @php
                                                            $selectedValue = old('coil_hv', $product->coil_hv);
                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'COIL MAKING')
                                                                ->where('nama_proses', 'COIL HV')
                                                                ->unique('nama_tipeproses');
                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="COIL MAKING"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>
                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr !important>
                                                <!-- tampilan hour dari inputan  -->
                                                <td>
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_potong_leadwire">0</p>
                                                </td>
                                                <!-- nama proses-->
                                                <td>
                                                    <h6 class="border border-dark rounded p-1 text-center">Potong Lead Wire
                                                    </h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td>
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        style="height: 33px;" name="potong_leadwire" id="potong_leadwire"
                                                        onchange="showSelected('potong_leadwire')">
                                                        @php
                                                            $selectedValue = old('potong_leadwire', $product->potong_leadwire);
                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'COIL MAKING')
                                                                ->where('nama_proses', 'POTONG LEAD WIRE')
                                                                ->unique('nama_tipeproses');
                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="COIL MAKING"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>
                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr !important>
                                                <!-- tampilan hour dari inputan  -->
                                                <td>
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_potong_isolasi">0</p>
                                                </td>
                                                <!-- nama proses-->
                                                <td>
                                                    <h6 class="border border-dark rounded p-1 text-center">Potong Isolasi
                                                    </h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td>
                                                    <select class="form-control border border-dark rounded text-center "
                                                        style="margin-bottom: 0rem" name="potong_isolasi[]"
                                                        id="potong_isolasi" onchange="showSelected('potong_isolasi')"
                                                        multiple>
                                                        @php
                                                            $selectedValue = old('potong_isolasi', $product->potong_isolasi);
                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'COIL MAKING')
                                                                ->where('nama_proses', 'POTONG ISOLASI')
                                                                ->unique('nama_tipeproses');
                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="COIL MAKING"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <!-- Mould & Casting  -->
                            <div class="card card-body my-1 py-1">
                                <div style="padding: 5px;">
                                    <!-- tampilan total hour pada tiap work center  -->
                                    <div class="row align-items-center">
                                        <div class="input-group input-group-md justify-content-center">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">MOULD & CASTING</span>
                                            </div>
                                            <div class="input-group-append " id="totalMouldCasting">
                                                <span type="text" class="input-group-text bg-warning"
                                                    style="width: 3rem" id="totalMouldCasting_value"></span>
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
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_hv_moulding"> 0</p>
                                                </td>
                                                <!-- nama proses-->
                                                <td class="w-30">
                                                    <h6 class=" border border-dark rounded p-1 text-center">HV Moulding
                                                    </h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td class="w-50">
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        style="height: 33px;"name="hv_moulding" id="hv_moulding"
                                                        onchange="showSelected('hv_moulding')">
                                                        @php
                                                            $selectedValue = old('hv_moulding', $product->hv_moulding);
                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'MOULD & CASTING')
                                                                ->where('nama_proses', 'HV MOULDING')
                                                                ->unique('nama_tipeproses');

                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="MOULD & CASTING"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr !important>
                                                <!-- tampilan hour dari inputan  -->
                                                <td class="w-20">
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_hv_casting">0</p>
                                                </td>
                                                <!-- nama proses-->
                                                <td>
                                                    <h6 class=" border border-dark rounded p-1 text-center">HV Casting</h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td>
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        style="height: 33px;" name="hv_casting" id="hv_casting"
                                                        onchange="showSelected('hv_casting')">
                                                        @php
                                                            $selectedValue = old('hv_casting', $product->hv_casting);
                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'MOULD & CASTING')
                                                                ->where('nama_proses', 'HV CASTING')
                                                                ->unique('nama_tipeproses');
                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="MOULD & CASTING"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr !important>
                                                <!-- tampilan hour dari inputan  -->
                                                <td class="w-20">
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_hv_demoulding">0</p>
                                                </td>
                                                <!-- nama proses-->
                                                <td>
                                                    <h6 class=" border border-dark rounded p-1 text-center">HV Demoulding
                                                    </h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td>
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        style="height: 33px;" name="hv_demoulding" id="hv_demoulding"
                                                        onchange="showSelected('hv_demoulding')">
                                                        @php
                                                            $selectedValue = old('hv_demoulding', $product->hv_demoulding);
                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'MOULD & CASTING')
                                                                ->where('nama_proses', 'HV DEMOULDING')
                                                                ->unique('nama_tipeproses');

                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="MOULD & CASTING"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr !important>
                                                <!-- tampilan hour dari inputan  -->
                                                <td class="w-20">
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;"id="selectedInfo_lv_bobbin">0</p>
                                                    {{-- <h6 class="border border-dark rounded p-1 text-center"></h6> --}}
                                                </td>
                                                <!-- nama proses-->
                                                <td>
                                                    <h6 class=" border border-dark rounded p-1 text-center">LV Bobbin</h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td>
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        name="lv_bobbin[]" id="lv_bobbin"
                                                        onchange="showSelected('lv_bobbin')" multiple>
                                                        @php
                                                            $selectedValue = old('lv_bobbin', $product->lv_bobbin);

                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'MOULD & CASTING')
                                                                ->where('nama_proses', 'LV BOBBIN')
                                                                ->unique('nama_tipeproses');

                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="MOULD & CASTING"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr !important>
                                                <!-- tampilan hour dari inputan  -->
                                                <td class="w-20">
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_lv_moulding">0</p>
                                                    {{-- <h6 class="border border-dark rounded p-1 text-center"></h6> --}}
                                                </td>
                                                <!-- nama proses-->
                                                <td>
                                                    <h6 class=" border border-dark rounded p-1 text-center">LV Moulding
                                                    </h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td>
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        name="lv_moulding[]" id="lv_moulding"
                                                        onchange="showSelected('lv_moulding')" multiple>
                                                        @php
                                                            $selectedValue = old('lv_moulding', $product->lv_moulding);
                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'MOULD & CASTING')
                                                                ->where('nama_proses', 'LV MOULDING')
                                                                ->unique('nama_tipeproses');
                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="MOULD & CASTING"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr !important>
                                                <!-- tampilan hour dari inputan  -->
                                                <td class="w-20">
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_touch_up">0</p>
                                                    {{-- <h6 class="border border-dark rounded p-1 text-center"></h6> --}}
                                                </td>
                                                <!-- nama proses-->
                                                <td>
                                                    <h6 class=" border border-dark rounded p-1 text-center">Touch Up</h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td>
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        name="touch_up[]" id="touch_up"
                                                        onchange="showSelected('touch_up')" multiple>
                                                        @php
                                                            $selectedValue = old('touch_up', $product->touch_up);

                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'MOULD & CASTING')
                                                                ->where('nama_proses', 'TOUCH UP')
                                                                ->unique('nama_tipeproses');
                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="MOULD & CASTING"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- kanan  -->
                        <div class="col-lg-6" style="padding-left: 5px">
                            {{-- core & Assembly  --}}
                            <div class="card card-body my-1 py-1">
                                <div style="padding: 5px;">
                                    <!-- tampilan total hour pada tiap work center  -->
                                    <div class="row align-items-center ">
                                        <div class="input-group input-group-md justify-content-center">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">CORE & ASSEMBLY</span>
                                            </div>
                                            <div class="input-group-append">
                                                <span type="text" class="input-group-text bg-warning"
                                                    style="width: 3rem" id="totalCoreCoilAssembly_value"></span>
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
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_type_susun_core">0</p>
                                                </td>
                                                <!-- nama proses-->
                                                <td class="w-30">
                                                    <h6 class="border border-dark rounded p-1 text-center">Type Susun Core
                                                    </h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td class="w-50">
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        style="height: 33px;" name="type_susun_core" id="type_susun_core"
                                                        onchange="showSelected('type_susun_core')">
                                                        @php
                                                            $selectedValue = old('type_susun_core', $product->type_susun_core);

                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'CORE COIL ASSEMBLY')
                                                                ->where('nama_proses', 'TYPE SUSUN CORE')
                                                                ->unique('nama_tipeproses');

                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="CORE COIL ASSEMBLY"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr !important>
                                                <!-- tampilan hour dari inputan  -->
                                                <td>
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_wiring">0</p>

                                                </td>
                                                <!-- nama proses-->
                                                <td>
                                                    <h6 class="border border-dark rounded p-1 text-center">Wiring</h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td>
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        style="height: 33px;" name="wiring" id="wiring"
                                                        onchange="showSelected('wiring')">
                                                        @php
                                                            $selectedValue = old('wiring', $product->wiring);

                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'CORE COIL ASSEMBLY')
                                                                ->where('nama_proses', 'WIRING')
                                                                ->unique('nama_tipeproses');
                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="CORE COIL ASSEMBLY"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif


                                                    </select>
                                                </td>
                                            </tr>
                                            <tr !important>
                                                <!-- tampilan hour dari inputan  -->
                                                <td>
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_instal_housing">0</p>

                                                </td>
                                                <!-- nama proses-->
                                                <td>
                                                    <h6 class="border border-dark rounded p-1 text-center">Instal Housing
                                                    </h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td>
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        style="height: 33px;" name="instal_housing" id="instal_housing"
                                                        onchange="showSelected('instal_housing')">
                                                        @php
                                                            $selectedValue = old('instal_housing', $product->instal_housing);

                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'CORE COIL ASSEMBLY')
                                                                ->where('nama_proses', 'INSTAL HOUSING')
                                                                ->unique('nama_tipeproses');
                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="CORE COIL ASSEMBLY"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr !important>
                                                <!-- tampilan hour dari inputan  -->
                                                <td>
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_bongkar_housing">0</p>

                                                </td>
                                                <!-- nama proses-->
                                                <td>
                                                    <h6 class="border border-dark rounded p-1 text-center">Bongkar Housing
                                                    </h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td>
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        style="height: 33px;" name="bongkar_housing" id="bongkar_housing"
                                                        onchange="showSelected('bongkar_housing')">
                                                        @php
                                                            $selectedValue = old('bongkar_housing', $product->bongkar_housing);

                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'CORE COIL ASSEMBLY')
                                                                ->where('nama_proses', 'BONGKAR HOUSING')
                                                                ->unique('nama_tipeproses');
                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="CORE COIL ASSEMBLY"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr !important>
                                                <!-- tampilan hour dari inputan  -->
                                                <td>
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_pembuatan_cu_link">0</p>

                                                </td>
                                                <!-- nama proses-->
                                                <td>
                                                    <h6 class="border border-dark rounded p-1 text-center">Pembuatan CU
                                                        Link
                                                    </h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td>
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        style="height: 33px;" name="pembuatan_cu_link"
                                                        id="pembuatan_cu_link"
                                                        onchange="showSelected('pembuatan_cu_link')">
                                                        @php
                                                            $selectedValue = old('pembuatan_cu_link', $product->pembuatan_cu_link);

                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'CORE COIL ASSEMBLY')
                                                                ->where('nama_proses', 'PEMBUATAN CU LINK')
                                                                ->unique('nama_tipeproses');

                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="CORE COIL ASSEMBLY"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr !important>
                                                <!-- tampilan hour dari inputan  -->
                                                <td>
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_others">0</p>

                                                </td>
                                                <!-- nama proses-->
                                                <td>
                                                    <h6 class="border border-dark rounded p-1 text-center">Others</h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td style="width:500px ">
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        name="others[]" id="others" onchange="showSelected('others')"
                                                        multiple>
                                                        @php
                                                            $selectedValue = old('others', $product->others);

                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'CORE COIL ASSEMBLY')
                                                                ->where('nama_proses', 'OTHERS')
                                                                ->unique('nama_tipeproses');

                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="CORE COIL ASSEMBLY"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr !important>
                                                <!-- tampilan hour dari inputan  -->
                                                <td>
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_accesories"p>0</p>

                                                </td>
                                                <!-- nama proses-->
                                                <td>
                                                    <h6 class="border border-dark rounded p-1 text-center">Accessories</h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td style="width:500px ">
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        name="accesories[]" id="accesories"
                                                        onchange="showSelected('accessories')" multiple>
                                                        @php
                                                            $selectedValue = old('accessories', $product->accessories);

                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'CORE COIL ASSEMBLY')
                                                                ->where('nama_proses', 'ACCESORIES')
                                                                ->unique('nama_tipeproses');

                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="CORE COIL ASSEMBLY"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr !important>
                                                <!-- tampilan hour dari inputan  -->
                                                <td>
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_potong_isolasi_fiber">0</p>
                                                </td>
                                                <!-- nama proses-->
                                                <td>
                                                    <h6 class="border border-dark rounded p-1 text-center">Potong Isolasi
                                                        Fiber
                                                    </h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td style="width:500px ">
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        name="potong_isolasi_fiber[]" id="potong_isolasi_fiber"
                                                        onchange="showSelected('potong_isolasi_fiber')" multiple>
                                                        @php
                                                            $selectedValue = old('potong_isolasi_fiber', $product->potong_isolasi_fiber);

                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'CORE COIL ASSEMBLY')
                                                                ->where('nama_proses', 'POTONG ISOLASI FIBER')
                                                                ->unique('nama_tipeproses');
                                                        @endphp
                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="CORE COIL ASSEMBLY"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
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
                                                <span class="input-group-text">QC TESTING</span>
                                            </div>
                                            <div class="input-group-append">
                                                <span type="text" class="input-group-text bg-warning"
                                                    style="width: 3rem" id="totalQCTest_value"></span>
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
                                                    <p type="text" class="border border-dark rounded p-1 text-center"
                                                        style="width:100%;" id="selectedInfo_routine_test">0</p>
                                                </td>
                                                <!-- nama proses-->
                                                <td class="w-30">
                                                    <h6 class="border border-dark rounded p-1 text-center">Routine Test
                                                    </h6>
                                                </td>
                                                <!-- inputan spek -->
                                                <td class="w-50">
                                                    <select class=" form-control border border-dark rounded text-center"
                                                        style="margin-bottom: 0rem" name="routine_test[]"
                                                        id="routine_test" onchange="showSelected('routine_test')"
                                                        multiple>
                                                        @php
                                                            $selectedValue = old('routine_test', $product->routine_test);

                                                            $manhourData = $manhour
                                                                ->where('nama_kategoriproduk', 'DRY TYPE RESIN')
                                                                ->where('nama_workcenter', 'QC TEST')
                                                                ->where('nama_proses', 'ROUNTINE')
                                                                ->unique('nama_tipeproses');
                                                        @endphp

                                                        @if (count($manhourData) > 0)
                                                            @foreach ($manhourData as $data)
                                                                <option value="{{ $data->nama_tipeproses }}"
                                                                    data-durasi="{{ $data->durasi_manhour }}"
                                                                    data-workcenter="QC TEST"
                                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                                    {{ $data->nama_tipeproses }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Data tidak ditemukan</option>
                                                        @endif

                                                    </select>
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
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function fillSelect(elementId, data, selectedProses, selectedWorkcenter) {
                var filteredData = data.filter(function(item) {
                    return (
                        item.nama_kategoriproduk === 'DRY TYPE RESIN' &&
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
                        url: '/standardized_work/Create-Data/Dry-Cast-Resin/kapasitas/' +
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
                                fillSelect('#hv_moulding', data, 'HV MOULDING',
                                    'MOULD & CASTING');
                                fillSelect('#hv_casting', data, 'HV CASTING',
                                    'MOULD & CASTING');
                                fillSelect('#hv_demoulding', data, 'HV DEMOULDING',
                                    'MOULD & CASTING');
                                fillSelect('#lv_bobbin', data, 'LV BOBBIN',
                                    'MOULD & CASTING');
                                fillSelect('#lv_moulding', data, 'LV MOULDING',
                                    'MOULD & CASTING');
                                fillSelect('#touch_up', data, 'TOUCH UP',
                                    'MOULD & CASTING');
                                fillSelect('#type_susun_core', data, 'TYPE SUSUN CORE',
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
                                    showSelected('coil_lv');
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
                                $('#hv_moulding').on('change', function() {
                                    showSelected('hv_moulding');
                                });
                                $('#hv_casting').on('change', function() {
                                    showSelected('hv_casting');
                                });
                                $('#hv_demoulding').on('change', function() {
                                    showSelected('hv_demoulding');
                                });
                                $('#lv_bobbin').on('change', function() {
                                    showSelected('lv_bobbin');
                                });
                                $('#lv_moulding').on('change', function() {
                                    showSelected('lv_moulding');
                                });
                                $('#touch_up').on('change', function() {
                                    showSelected('touch_up');
                                });
                                $('#type_susun_core').on('change', function() {
                                    showSelected('type_susun_core');
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
            let totalJamElement = document.getElementById("totalHour_coil_making");
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
