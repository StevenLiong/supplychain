@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Stok Produksi</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- notif session --}}
            
            {{-- notif session end --}}

            <div class="card rounded-0 m-2">
                <div class="card-header">
                    <div class="row justify-content-between mx-2">
                        {{-- button create data --}}
                        <div class="btn-create">
                            <button type="button" class="btn btn-xs btn-gray"
                                onclick=window.location="{{ url('/services/transaksiproduksi/transfer/create') }}">New Stok</button>
                        </div>
                        {{-- button create data end --}}

                        {{-- search --}}
                        <div>
                            <form action="{{ url('services/transaksigudang/cutting') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm rounded-0"
                                        placeholder="cari material...." name="search" value="{{ request('search') }}">
                                    <button class="btn btn-red rounded-0 btn-xs" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                        {{-- search ednd --}}
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- table transfer --}}
                        <table class="table table-sm table-bordered table-hover">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Kode Material</th>
                                    <th>Nama Material</th>
                                    <th>Satuan</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stokProduksi as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kd_material }}</td>
                                        <td>{{ $item->nama_material }}</td>
                                        <td>{{ $item->satuan }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- table transfer end --}}
                    </div>
                </div>

                {{-- pagination --}}
                {{-- <div class="row mx-3 mb-3">
                    <div class="col text-secondary">
                        Showing {{ $transfer->firstItem() }}
                        to {{ $material->lastItem() }}
                        of {{ $material->total() }}
                        data
                    </div>
                    <div class="col d-flex justify-content-end">
                        {{ $material->appends(request()->input())->links() }}
                    </div>
                </div> --}}
                {{-- pagination end --}}
            </div>
        </div>
    </div>
@endsection
