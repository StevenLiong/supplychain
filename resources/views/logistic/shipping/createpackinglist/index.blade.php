@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Input Data Packing</h4>
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

            {{-- card tabel --}}
            <div class="card rounded-0 m-2">
                <div class="card-header">
                    <div class="row justify-content-between mx-2">
                        {{-- btn create --}}
                        <div class="btn-create ">
                            <button type="button" class="btn btn-xs btn-gray"
                                onclick=window.location="{{ url('shipping/createpackinglist/create') }}">Create
                                Packing</button>
                        </div>
                        {{-- btn create end --}}

                        {{-- search --}}
                        <div class="">
                            <form action="{{ url('') }}">
                                <div class="input-group ">
                                    <input type="text" class="form-control form-control-sm rounded-0"
                                        placeholder="cari..." name="search" value="{{ request('search') }}">
                                    <button class="btn btn-red rounded-0 btn-xs" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                        {{-- search end --}}
                    </div>
                </div>
                <div class="card-body">
                    {{-- table Input data kedatangan --}}
                    <div class="table-responsive">

                        <table class="table table-sm table-bordered table-hover">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>No DO</th>
                                    <th>NO WO</th>
                                    <th>NSP</th>
                                    <th>NSK</th>
                                    <th>Ukuran</th>
                                    <th width="5%">Dimensi</th>
                                    <th width="3%">Customer</th>
                                    <th width="3%">Tgl Packing</th>
                                    <th width="3%">Tgl Pengiriman</th>
                                    <th>Cetak</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    {{-- table Input data kedatangan end --}}
                </div>

                {{-- pagination --}}
                {{-- <div class="row mx-3 mb-3">
                    <div class="col text-secondary">
                        Showing {{ $incoming->firstItem() }}
                        to {{ $incoming->lastItem() }}
                        of {{ $incoming->total() }}
                        data
                    </div>
                    <div class="col d-flex justify-content-end">
                        {{ $incoming->appends(request()->input())->links() }}
                    </div>
                </div> --}}
                {{-- pagination end --}}
            </div>


        </div>
    </div>
@endsection
