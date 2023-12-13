@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Create Delivery Receipt </h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            <div class="card mx-2 p-5">
                {{-- form --}}
                <div class="row">
                    <div class="col-12 px-3">
                        <form action="{{ url('shipping/deliveryreceipt') }}" method="POST">
                            @csrf
                            {{-- Form Packing List --}}
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="id_wo" class="form-label">WO</label>
                                        <select name="id_wo" id="id_wo" class="form-control">
                                            <option value="">Pilih Referensi Wo</option>
                                            @foreach ($finishedgood as $item)
                                                <option value="{{ $item->id_wo }}">{{ $item->id_wo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="nsp" class="form-label">NSK</label>
                                        <select name="nsp" id="nsp" class="form-control">
                                            <option value="">Pilih Referensi WO</option>
                                            @foreach ($finishedgood as $item)
                                                <option value="{{ $item->nsp }}">{{ $item->nsp }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="nsk" class="form-label">NSK</label>
                                        <select name="nsk" id="nsk" class="form-control">
                                            <option value="">Pilih Referensi Wo</option>
                                            @foreach ($finishedgood as $item)
                                                <option value="{{ $item->nsk }}">{{ $item->nsk }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="Tanggal_Delivery" class="form-label">Tanggal
                                            Delivery</label>
                                        <input type="date"
                                            class="form-control @error('Tanggal_Delivery')
                                            is-invalid
                                        @enderror"
                                            id="Tanggal_Delivery" name="Tanggal_Delivery"
                                            placeholder="Pilih Tanggal Delivery" value="{{ old('Tanggal_Delivery') }}">
                                        @error('Tanggal_Delivery')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="NO_SO" class="form-label">No. SO</label>
                                        <input type="text"
                                            class="form-control @error('NO_SO')
                                            is-invalid
                                        @enderror"
                                            id="NO_SO" name="NO_SO" placeholder="Input No. SO"
                                            value="{{ old('NO_SO') }}">
                                        @error('NO_SO')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="NO_DO" class="form-label">No. DO</label>
                                        <input type="text"
                                            class="form-control @error('NO_DO')
                                            is-invalid
                                        @enderror"
                                            id="NO_DO" name="NO_DO" placeholder="Input No. DO"
                                            value="{{ old('NO_DO') }}">
                                        @error('NO_DO')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="packaging" class="form-label">Packaging</label>
                                        <select class="form-control @error('packaging') is-invalid @enderror" id="packaging"
                                            name="packaging">
                                            <option value="" selected disabled>Choose Packaging</option>
                                            <option value="plastik" {{ old('packaging') == 'plastik' ? 'selected' : '' }}>
                                                Plastik</option>
                                            <option value="peti" {{ old('packaging') == 'peti' ? 'selected' : '' }}>Peti
                                            </option>
                                            <option value="pallet" {{ old('packaging') == 'pallet' ? 'selected' : '' }}>
                                                Pallet</option>
                                        </select>
                                        @error('packaging')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="ekspedisi" class="form-label">Ekspedisi</label>
                                        <input type="text"
                                            class="form-control @error('ekspedisi')
                                            is-invalid
                                        @enderror"
                                            id="ekspedisi" name="ekspedisi" placeholder="Input Ekspedisi"
                                            value="{{ old('ekspedisi') }}">
                                        @error('ekspedisi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="no_kendaraan" class="form-label">No. Kendaraan</label>
                                        <input type="text"
                                            class="form-control @error('no_kendaraan')
                                            is-invalid
                                        @enderror"
                                            id="no_kendaraan" name="no_kendaraan" placeholder="Input No. Kendaraan"
                                            value="{{ old('no_kendaraan') }}">
                                        @error('no_kendaraan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="alamat" class="form-label w-100">Alamat Penyerahan</label>
                                        <input type="text"
                                            class="form-control @error('alamat')
                                            is-invalid
                                        @enderror"
                                            id="alamat" name="alamat" placeholder="Input Alamat Penyerahan"
                                            value="{{ old('alamat') }}">
                                        @error('alamat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div> --}}
                            </div>
                            <div class="m-3">
                                <button type="button" class="btn btn-sm btn-red text-black"
                                    onclick="window.location='{{ url('/shipping/deliveryreceipt') }}'"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                        viewBox="0 0 12 22" fill="none">
                                        <path d="M11 1L1 11L11 21" stroke="#252525" stroke-opacity="0.8" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> Kembali </button>
                                <button class="btn btn-sm btn-red" type="submit" id="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- form end --}}
            </div>


            {{-- output --}}
            @if (!is_null($delivery))
            <div class="card mx-2 p-5">
                <div class="head-tabel">
                    <div class="row">
                        <h3 class="col-lg-6">List Delivery Receipt</h3>
                    </div>
                </div>
                <div class="tabel table-sm" style="height: 300px">
                    <table class="table border-bottom ">
                        <thead class="border-top text-center">
                            <tr>
                                <th>No.</th>
                                <th>Kode Finished Good</th>
                                <th>Qty</th>
                                <th>kVA</th>
                                <th>NSP</th>
                                <th>NSK</th>
                                <th>Ekspedisi</th>
                                <th>No. Kendaraan</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($delivery as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->finishedgood->kd_finishedgood }}</td>
                                    <td>{{ $item->finishedgood->qty}}</td>
                                    <td>{{ $item->finishedgood->kva }}</td>
                                    <td>{{ $item->finishedgood->nsp }}</td>
                                    <td>{{ $item->finishedgood->nsk }}</td>
                                    <td>{{ $item->ekspedisi }}</td>
                                    <td>{{ $item->no_kendaraan }}</td>
                                </tr>
                            @endforeach
                            {{-- <tr>
                                <td>1</td>
                                <td>1dcwd</td>
                                <td>1dcwdd</td>
                                <td>1dcwdd</td>
                                <td>1dcwdd</td>
                                <td>1dcwdd</td>
                                <td>1dcwdd</td>
                                <td>1dcwdd</td>
                            </tr> --}}
                        </tbody>
                    </table>
                    <div class="row justify-content-end">
                        <a href="{{ url('services/transaksigudang/order/') }}" target="_blank"
                            class="btn btn-sm btn-red ">Print</a>

                    </div>
                </div>

            </div>
            @endif
            {{-- output end --}}

        </div>
    </div>
@endsection
