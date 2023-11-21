@extends('standardized_work.layout')
@section('content')
    <div id="app">
        <div class="main-wrapper">
            <div class="main-content">
                <div class="container">
                    <form method="post" action="{{ route('dryresin.update', $product->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="card mt-5">
                            <div class="card-header">
                                <h3>Edit Product</h3>
                            </div>
                            <div class="card-body">
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
                                <div class="mb-3">
                                    <label class="form-label">NOMOR SO</label>
                                    <input type="text" class="form-control"  name="nomor_so"
                                        value="{{ old('nomor_so', $product->nomor_so) }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kategori</label>
                                    <input type="text" class="form-control" name="nama_product"
                                        value="{{ old('nama_product', $product->nama_product) }}" readonly>
                                </div>
                                {{-- <div class="mb-3">
                                <label class="form-label">Kapasitas</label>
                                <select id="ukuran_kapasitas" name="ukuran_kapasitas" class="form-control">
                                    @php
                                        $selectedValue = old('ukuran_kapasitas', $product->ukuran_kapasitas);
                                        $manhourData = $manhour->where('nama_kategoriproduk', 'DRY TYPE RESIN')->unique('ukuran_kapasitas');
                                    @endphp

                                    @if (count($manhourData) > 0)
                                        @foreach ($manhourData as $data)
                                            <option value="{{ $data->ukuran_kapasitas }}"
                                                data-durasi="{{ $data->durasi_manhour }}"
                                                {{ $selectedValue == $data->ukuran_kapasitas ? 'selected' : '' }}>
                                                {{ $data->ukuran_kapasitas }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">Data tidak ditemukan</option>
                                    @endif
                                </select>
                            </div> --}}
                                <div class="mb-3">
                                    <label class="form-label">Kapasitas</label>
                                    <select id="ukuran_kapasitas" name="ukuran_kapasitas" class="form-control" readonly>
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
                                    </select>
                                </div>

                                <div>
                                    <label for="coil_lv">Coil LV</label>
                                    <select id="coil_lv" class="form-select input" name="coil_lv" onchange="showSelected('coil_lv')">
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
                                                    data-durasi="{{ $data->durasi_manhour }}" data-workcenter="COIL MAKING"
                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>
                                                    {{ $data->nama_tipeproses }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="">Data tidak ditemukan</option>
                                        @endif
                                    </select>
                                    <p id="selectedInfo_coil_lv"></p>
                                </div>

                                <div>
                                    <label for="coil_hv">Coil HV</label>
                                    <select id="coil_hv" class="form-select input" name="coil_hv" onchange="showSelected('coil_hv')">
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
                                                    data-durasi="{{ $data->durasi_manhour }}" data-workcenter="COIL MAKING"
                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>
                                                    {{ $data->nama_tipeproses }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="">Data tidak ditemukan</option>
                                        @endif
                                    </select>
                                    <p id="selectedInfo_coil_hv"></p>
                                </div>

                                <div>
                                    <label for="potong_leadwire">Potong Leadwire</label>
                                    <select id="potong_leadwire" class="form-select input" name="potong_leadwire"
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
                                                    data-durasi="{{ $data->durasi_manhour }}" data-workcenter="COIL MAKING"
                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>
                                                    {{ $data->nama_tipeproses }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="">Data tidak ditemukan</option>
                                        @endif
                                    </select>
                                    <p id="selectedInfo_potong_leadwire"></p>
                                </div>

                                <div>
                                    <label for="potong_isolasi">Potong Isolasi</label>
                                    <select id="potong_isolasi[]" class="form-select input" name="potong_isolasi"
                                        onchange="showSelected('potong_isolasi')" multiple>
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
                                                    data-durasi="{{ $data->durasi_manhour }}" data-workcenter="COIL MAKING"
                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                    {{ $data->nama_tipeproses }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="">Data tidak ditemukan</option>
                                        @endif
                                    </select>
                                    <p id="selectedInfo_potong_isolasi"></p>
                                </div>
                                <div id="totalJam">
                                    Total Jam COIL MAKING: <span id="totalJam_value"></span>
                                </div>
                                <div>
                                    <label for="hv_moulding">HV Moulding</label>
                                    <select id="hv_moulding" class="form-select input" name="hv_moulding" onchange="showSelected('hv_moulding')">
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
                                    <p id="selectedInfo_hv_moulding"></p>
                                </div>

                                <div>
                                    <label for="hv_casting">HV Casting</label>
                                    <select id="hv_casting" class="form-select input" name="hv_casting" onchange="showSelected('hv_casting')">
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
                                    <p id="selectedInfo_hv_casting"></p>
                                </div>

                                <div>
                                    <label for="hv_demoulding">HV Demoulding</label>
                                    <select id="hv_demoulding" class="form-select input" name="hv_demoulding"
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
                                    <p id="selectedInfo_hv_demoulding"></p>
                                </div>

                                <div>
                                    <label for="lv_bobbin">LV Bobbin</label>
                                    <select id="lv_bobbin[]" class="form-select input" name="lv_bobbin" onchange="showSelected('lv_bobbin')" multiple>
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
                                    <p id="selectedInfo_lv_bobbin"></p>
                                </div>

                                <div>
                                    <label for="lv_moulding">LV Moulding</label>
                                    <select id="lv_moulding[]" class="form-select input" name="lv_moulding" onchange="showSelected('lv_moulding')" multiple>
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
                                    <p id="selectedInfo_lv_moulding"></p>
                                </div>

                                <div>
                                    <label for="touch_up">Touch Up</label>
                                    <select id="touch_up[]" class="form-select input" name="touch_up" onchange="showSelected('touch_up')" multiple>
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
                                    <p id="selectedInfo_touch_up"></p>
                                </div>
                                <div id="totalMouldCasting">
                                    Total Jam MOULD & CASTING: <span id="totalMouldCasting_value">0</span>
                                </div>
                                <div>
                                    <label for="type_susun_core">Type Susun Core</label>
                                    <select id="type_susun_core" class="form-select input" name="type_susun_core"
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
                                    <p id="selectedInfo_type_susun_core"></p>
                                </div>

                                <div>
                                    <label for="wiring">Wiring</label>
                                    <select id="wiring" class="form-select input" name="wiring" onchange="showSelected('wiring')">
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
                                    <p id="selectedInfo_wiring"></p>
                                </div>

                                <div>
                                    <label for="instal_housing">Instal Housing</label>
                                    <select id="instal_housing" class="form-select input" name="instal_housing"
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
                                    <p id="selectedInfo_instal_housing"></p>
                                </div>

                                <div>
                                    <label for="bongkar_housing">Bongkar Housing</label>
                                    <select id="bongkar_housing" class="form-select input" name="bongkar_housing"
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
                                    <p id="selectedInfo_bongkar_housing"></p>
                                </div>

                                <div>
                                    <label for="pembuatan_cu_link">Pembuatan CU Link</label>
                                    <select id="pembuatan_cu_link" class="form-select input" name="pembuatan_cu_link"
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
                                    <p id="selectedInfo_pembuatan_cu_link"></p>
                                </div>

                                <div>
                                    <label for="others">Others</label>
                                    <select id="others[]" class="form-select input" name="others" onchange="showSelected('others')" multiple>
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
                                    <p id="selectedInfo_others"></p>
                                </div>

                                <div>
                                    <label for="accessories">Accessories</label>
                                    <select id="accessories[]" class="form-select input" name="accessories" onchange="showSelected('accessories')" multiple>
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
                                    <p id="selectedInfo_accessories"></p>
                                </div>

                                <div>
                                    <label for="potong_isolasi_fiber">Potong Isolasi Fiber</label>
                                    <select id="potong_isolasi_fiber[]" class="form-select input" name="potong_isolasi_fiber"
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
                                    <p id="selectedInfo_potong_isolasi_fiber"></p>
                                </div>
                                <div id="totalCoreCoilAssembly">
                                    Total Jam CORE COIL ASSEMBLY: <span id="totalCoreCoilAssembly_value">0</span>
                                </div>
                                <div>
                                    <label for="routine_test">Routine Test</label>
                                    <select id="routine_test[]" class="form-select input" name="routine_test"
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
                                                    data-durasi="{{ $data->durasi_manhour }}" data-workcenter="QC TEST"
                                                    {{ $selectedValue == $data->nama_tipeproses ? 'selected' : '' }}>

                                                    {{ $data->nama_tipeproses }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="">Data tidak ditemukan</option>
                                        @endif
                                    </select>
                                    <p id="selectedInfo_routine_test"></p>
                                </div>

                                <div id="totalQCTest">
                                    Total Jam QC TEST: <span id="totalQCTest_value">0</span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Total Hour</label>
                                    <input type="text" class="form-control" id="total_hour"  name="total_hour"
                                        value="{{ old('total_hour', $product->total_hour) }}" readonly>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
