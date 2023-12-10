@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Bukti Penerimaan Barang</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- form --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mx-2 p-2">
                        <form action="{{ url('receiving/bpnb') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="id_po" class="form-label">Nomor PO</label>
                                        <select name="id_po" id="id_po" class="form-control">
                                            <option disabled selected value="">Pilih Nomor Po</option>
                                            @foreach ($po as $po)
                                                <option value="{{ $po->id_po }}">{{ $po->id_po }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="surat_jalan" class="form-label">No Surat Jalan</label>
                                        <input type="text" class="form-control" id="surat_jalan" name="surat_jalan"
                                            placeholder=" Nomor Surat Jalan">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="tgl_bpnb" class="form-label">Tanggal BPNB</label>
                                        <input type="date" class="form-control" id="tgl_bpnb" name="tgl_bpnb"
                                            placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="tgl_suratjalan" class="form-label">Tanggal Surat Jalan</label>
                                        <input type="date" class="form-control" id="tgl_suratjalan" name="tgl_suratjalan"
                                            placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                </div>
                            </div>
                            <div class="m-3">
                                <button class="btn btn-red" type="submit" name="submit" id="submit">Submit</button>
                            </div>
                        </form>
                        {{-- form end --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
