@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Form Cutting</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            <div class="card mx-2 p-2">
                {{-- form --}}
                <div class="row">
                    <div class="col-12 px-3">
                        <form action="{{ url('services/transaksigudang/cutting') }}" method="post">
                            @csrf
                            {{-- Form Tambah Data Material --}}
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="bon_f" class="form-label">Referensi (F)</label>
                                        <select name="bon_f" id="bon_f"
                                            class="form-control @error('bon_f')
                                            is-invalid
                                        @enderror">
                                            <option value=""></option>
                                            @foreach ($order as $item)
                                                <option value="{{ $item->id }}">{{ $item->no_bon }}</option>
                                            @endforeach
                                        </select>
                                        @error('bon_f')
                                            <div class="invalid-feedback">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="tanggal_bon" class="form-label ">Tanggal Bon</label>
                                        <input type="date"
                                            class="form-control @error('tanggal_bon')
                                            is-invalid
                                        @enderror"
                                            id="tanggal_bon" name="tanggal_bon" placeholder="tanggal bon"
                                            value="{{ old('tanggal_bon') }}">
                                        @error('tanggal_bon')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="m-3">
                        <button class="btn btn-red" type="submit" name="submit" id="submit">Submit</button>
                    </div>
                    </form>

                </div>
                {{-- form end --}}
            </div>

            {{-- output --}}
            @if (!is_null($detailbom))
            <div class="card mx-2 p-5">
                <div class="head-tabel">
                    <div class="row">
                        <h3 class="col-lg-6">List Permintaan bahan</h3>
                    </div>
                </div>
                <div class="tabel table-sm" style="height: 300px">
                    <table class="table border-bottom ">
                        <thead class="border-top text-center">
                            <tr>
                                <th>No.</th>
                                <th>Kode </th>
                                <th>Nama Material</th>
                                <th>Satuan</th>
                                <th>Jumlah Diminta</th>
                                <th>Diserahkan</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($detailbom as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->id_materialbom }}</td>
                                        <td>{{ $item->nama_materialbom }}</td>
                                        <td>{{ $item->uom_material }}</td>
                                        <td>{{ $item->usage_material }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            {{-- <tr>
                                <td>1</td>
                                <td>1dcwd</td>
                                <td>1dcwdd</td>
                                <td>1dcwdd</td>
                                <td>1dcwdd</td>
                                <td>1dcwdd</td>
                            </tr> --}}
                        </tbody>
                    </table>
                    <div class="row justify-content-end">
                        <a href="{{ url('services/transaksigudang/cutting/'. $item->nama_workcenter) }}" target="_blank"
                            class="btn btn-sm btn-red ">Print</a>

                    </div>
                </div>

            </div>
            @endif
            {{-- output end --}}
        </div>
    </div>
    </div>
@endsection
