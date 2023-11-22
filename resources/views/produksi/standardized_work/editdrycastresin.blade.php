@extends('produksi.standardized_work.layout')
@section('content')
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
                            <a href="/" class="btn btn-primary m-2">
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
                                <input class="floating-input form-control" type="text" placeholder="" name="nama_product"
                                    value="Dry Cast Resin" id="category" disabled>
                                <label style="border-radius: 40px;">Category</label>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" name="kategori"
                                        value="{{ old('nama_product', $product->nama_product) }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <select 
                                    class="floating-input form-control form-select input"name="ukuran_kapasitas"
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
                                                id="totalJam_value"></span>
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
                                                    id="selectedInfo_coil_lv">0</p>
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
                                                <h6 class="border border-dark rounded p-1 text-center">Potong Isolasi</h6>
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
                                            <span type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalMouldCasting_value"></span>
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
                                                <h6 class=" border border-dark rounded p-1 text-center">HV Moulding</h6>
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
                                                <h6 class=" border border-dark rounded p-1 text-center">HV Demoulding</h6>
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
                                                <h6 class=" border border-dark rounded p-1 text-center">LV Moulding</h6>
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
                                                    name="touch_up[]" id="touch_up" onchange="showSelected('touch_up')"
                                                    multiple>
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
                                            <span type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalCoreCoilAssembly_value"></span>
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
                                                <h6 class="border border-dark rounded p-1 text-center">Type Susun Core</h6>
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
                                                <h6 class="border border-dark rounded p-1 text-center">Instal Housing</h6>
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
                                                <h6 class="border border-dark rounded p-1 text-center">Bongkar Housing</h6>
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
                                                <h6 class="border border-dark rounded p-1 text-center">Pembuatan CU Link
                                                </h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="pembuatan_cu_link" id="pembuatan_cu_link"
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
                                                <h6 class="border border-dark rounded p-1 text-center">Potong Isolasi Fiber
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
                                            <span type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalQCTest_value"></span>
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
                                                <h6 class="border border-dark rounded p-1 text-center">Routine Test</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="margin-bottom: 0rem" name="routine_test[]" id="routine_test"
                                                    onchange="showSelected('routine_test')" multiple>
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

@endsection
