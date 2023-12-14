@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Transfer Produksi</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- notif session --}}
            <div class="row px-2">
                <div class="col-lg-12">
                    @if (session()->has('success'))
                        <div class="alert alert-success rounded-0 ">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- notif session end --}}

            <div class="card rounded-0 m-2">
                <div class="card-header">
                    <div class="row justify-content-between mx-2">
                        {{-- button create data --}}
                        <div class="btn-create">
                            <button type="button" class="btn btn-xs btn-gray"
                                onclick=window.location="{{ url('/services/transaksiproduksi/transfer/create') }}">New
                                Transfer</button>
                        </div>
                        {{-- button create data end --}}

                        {{-- search --}}
                        <div>
                            <form action="{{ url('services/transaksigudang/cutting') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm rounded-0"
                                        placeholder="cari Nomor Bukti...." name="search" value="{{ request('search') }}">
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
                                    <th>No Bukti</th>
                                    <th>No Work Order</th>
                                    <th>Kode Finsihed Good </th>
                                    <th>kVA</th>
                                    <th>Qty</th>
                                    <th>Lacak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transfer as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->no_bon }}</td>
                                        <td>{{ $item->id_wo }}</td>
                                        <td>{{ $item->wo->id_fg }}</td>
                                        <td>{{ $item->wo->kva }}</td>
                                        <td>{{ $item->wo->qty_trafo }}</td>
                                        <td width="3%" class="text-center ">
                                            <a href="{{ url('/services/transaksiproduksi/transfer/lacak/'. $item->no_bon) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="22"
                                                    viewBox="0 0 21 22" fill="none">
                                                    <path d="M14.7502 15.5L19 20" stroke="black" stroke-width="3"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M2 9.71428C2 13.9747 5.26172 17.4286 9.28526 17.4286C11.3005 17.4286 13.1247 16.5621 14.4436 15.1618C15.758 13.7665 16.5705 11.8408 16.5705 9.71428C16.5705 5.4538 13.3088 2 9.28526 2C5.26172 2 2 5.4538 2 9.71428Z"
                                                        stroke="black" stroke-width="3" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </a>
                                        </td>
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
