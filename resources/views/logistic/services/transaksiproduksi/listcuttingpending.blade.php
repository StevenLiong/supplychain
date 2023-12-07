@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Penerimaan Material</h4>
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

            <div class="card rounded-0 m-2 col-lg-8">
                <div class="card-header">
                    <div class="row justify-content-between mx-2">
                        {{-- search --}}
                        {{-- <div>
                            <form action="{{ url('services/transaksigudang/cutting') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm rounded-0"
                                        placeholder="cari Nomor Bon...." name="search" value="{{ request('search') }}">
                                    <button class="btn btn-red rounded-0 btn-xs" type="submit">Search</button>
                                </div>
                            </form>
                        </div> --}}
                        {{-- search ednd --}}
                    </div>

                </div>
                <div class="card-body ">
                    <div class="table-responsive">
                        {{-- table order --}}
                        <table class="table table-sm table-bordered table-hover">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>No Bon Cutting</th>
                                    <th>Tanggal </th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cutting as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->no_bon }}</td>
                                        <td>{{ $item->tanggal_bon }}</td>
                                        <td class="text-center"> <span
                                                class="badge bg-warning">{{ $item->statusText }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('/services/transaksiproduksi/listpending/show/' . $item->order->nama_workcenter) }}"><span class="badge bg-primary">Lihat</span></a>
                                            <a href="{{ url('') }}" ><span class="badge bg-success">Terima</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- table order end --}}
                    </div>
                </div>

                {{-- pagination --}}
                {{-- <div class="row mx-3 mb-3">
                    <div class="col text-secondary">
                        Showing {{ $order->firstItem() }}
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
