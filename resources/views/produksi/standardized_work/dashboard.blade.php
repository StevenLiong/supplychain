@extends('produksi.standardized_work.layout')
@section('content')
    <!-- - - - - - - - - - - - start content-- - - - - - - - - - - -->
    <div class="card" style="margin:40px">
        <div class="card-header d-flex justify-content-center">
            <div class="header-title text-center">
                <h4 class="card-title" style="font-size: 30px; "><b>STANDARDIZED WORKS</b></h4>
            </div>
        </div>
        <div class="card-body">
            <!-- <p>Images in Bootstrap are made responsive with <code>.img-fluid</code>. <code>max-width: 100%;</code> and <code>height: auto;</code> are applied to the image so that it scales with the parent element.</p> -->
            <div class="row mb-4 align-items-center flex-sm-row">
                <!-- Tombol untuk memicu modal -->
                <button class="btn btn-primary ml-3 mb-3 mb-sm-0" data-toggle="modal" data-target="#myModal">
                    <i class="fa-solid fa-plus mr-2"></i>Create Data
                </button>


                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header justify-content-center">
                                <h5 class="modal-title " id="exampleModalLabel">Select Product Category</h5>
                            </div>
                            <div class="modal-body">
                                <a class="dropdown-item" href="/standardized_work/Create-Data/Dry-Cast-Resin">Dry Cast
                                    Resin</a>
                                <a class="dropdown-item" href="/standardized_work/Create-Data/Dry-Non-Resin">Dry Non
                                    Resin</a>
                                <a class="dropdown-item" href="/standardized_work/Create-Data/Ct">CT</a>
                                <a class="dropdown-item" href="/standardized_work/Create-Data/Vt">VT</a>
                                <a class="dropdown-item" href="/standardized_work/Create-Data/Oil-Standard">Oil Standard</a>
                                <a class="dropdown-item" href="/standardized_work/Create-Data/Oil-Custom">Oil Custom</a>
                                <a class="dropdown-item" href="/standardized_work/Create-Data/Repair">Repair</a>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropdown ml-3 mb-3 mb-sm-0 ">
                    <button class="btn btn-primary dropdown-toggle " type="button" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-search mr-2"></i>Filter Data
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/standardized_work/Create-Data/Dry-Cast-Resin">Dry Cast Resin</a>
                        <a class="dropdown-item" href="/standardized_work/Create-Data/Dry-Non-Resin">Dry Non Resin</a>
                        <a class="dropdown-item" href="/standardized_work/Create-Data/Ct">CT</a>
                        <a class="dropdown-item" href="/standardized_work/Create-Data/Vt">Vt</a>
                        <a class="dropdown-item" href="/standardized_work/Create-Data/Oil-Standard">Oil Standart</a>
                        <a class="dropdown-item" href="/standardized_work/Create-Data/Oil-Custom">Oil Custom</a>
                        <a class="dropdown-item" href="/standardized_work/Create-Data/Repair">Repair</a>
                    </div>
                </div>
                <div class="ml-auto mr-3 float-right">
                    <a href="#" class="ya-deh btn btn-primary ">
                        <i class="mr-2 fa-solid fa-print"></i>Print
                    </a>

                </div>
                <div class=" mr-3 float-right">

                    <form action="/logout" method="POST">
                        @csrf
                        <button class="ya-deh btn btn-primary" type="submit"><i
                                class=" fa-solid fa-power-off"></i></button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <div id="datatable_wrapper" class="dataTables_wrapper">
                    <table id="datatable" class="table data-table table-striped">
                        <thead>
                            <tr>
                            <tr class="ligth" style="text-align: center;">
                                <th>Category</th>
                                <th>Date</th>
                                <th>SO Code</th>
                                <th>Hours</th>
                                <th>Capacity</th>
                                <th>Man Hour Code</th>
                                <th style="width:14rem;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @dd($standardize_works) --}}
                            @forelse ($standardize_works as $std)
                                <tr>
                                    <td class="text-center">

                                        @if ($std->dry_cast_resin)
                                            {{-- @dd($std->dry_cast_resin) --}}
                                            {{ $std->dry_cast_resin->nama_product }}
                                        @elseif ($std->dry_non_resin)
                                            {{ $std->dry_non_resin->nama_product }}
                                        @elseif ($std->repair)
                                            {{ $std->repair->nama_product }}
                                        @elseif ($std->oil_custom)
                                            {{ $std->oil_custom->nama_product }}
                                        @elseif ($std->oil_standard)
                                            {{ $std->oil_standard->nama_product }}
                                        @elseif ($std->vt)
                                            {{ $std->vt->nama_product }}
                                        @elseif ($std->ct)
                                            {{ $std->ct->nama_product }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($std->dry_cast_resin)
                                            {{ $std->dry_cast_resin->created_at->format('d-m-Y H:i') }}
                                        @elseif ($std->dry_non_resin)
                                            {{ $std->dry_non_resin->created_at->format('d-m-Y H:i') }}
                                        @elseif ($std->repair)
                                            {{ $std->repair->created_at->format('d-m-Y H:i') }}
                                        @elseif ($std->oil_custom)
                                            {{ $std->oil_custom->created_at->format('d-m-Y H:i') }}
                                        @elseif ($std->oil_standard)
                                            {{ $std->oil_standard->created_at->format('d-m-Y H:i') }}
                                        @elseif ($std->vt)
                                            {{ $std->vt->created_at->format('d-m-Y H:i') }}
                                        @elseif ($std->ct)
                                            {{ $std->ct->created_at->format('d-m-Y H:i') }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($std->dry_cast_resin)
                                            {{ $std->dry_cast_resin->nomor_so }}
                                        @elseif ($std->dry_non_resin)
                                            {{ $std->dry_non_resin->nomor_so }}
                                        @elseif ($std->repair)
                                            {{ $std->repair->nomor_so }}
                                        @elseif ($std->oil_custom)
                                            {{ $std->oil_custom->nomor_so }}
                                        @elseif ($std->oil_standard)
                                            {{ $std->oil_standard->nomor_so }}
                                        @elseif ($std->vt)
                                            {{ $std->vt->nomor_so }}
                                        @elseif ($std->ct)
                                            {{ $std->ct->nomor_so }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($std->dry_cast_resin)
                                            {{ $std->dry_cast_resin->total_hour }}
                                        @elseif ($std->dry_non_resin)
                                            {{ $std->dry_non_resin->total_hour }}
                                        @elseif ($std->repair)
                                            {{ $std->repair->total_hour }}
                                        @elseif ($std->oil_custom)
                                            {{ $std->oil_custom->total_hour }}
                                        @elseif ($std->oil_standard)
                                            {{ $std->oil_standard->total_hour }}
                                        @elseif ($std->vt)
                                            {{ $std->vt->total_hour }}
                                        @elseif ($std->ct)
                                            {{ $std->ct->total_hour }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($std->dry_cast_resin)
                                            {{ $std->dry_cast_resin->ukuran_kapasitas }}
                                        @elseif ($std->dry_non_resin)
                                            {{ $std->dry_non_resin->ukuran_kapasitas }}
                                        @elseif ($std->repair)
                                            {{ $std->repair->ukuran_kapasitas }}
                                        @elseif ($std->oil_custom)
                                            {{ $std->oil_custom->ukuran_kapasitas }}
                                        @elseif ($std->oil_standard)
                                            {{ $std->oil_standard->ukuran_kapasitas }}
                                        @elseif ($std->vt)
                                            {{ $std->vt->ukuran_kapasitas }}
                                        @elseif ($std->ct)
                                            {{ $std->ct->ukuran_kapasitas }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($std->dry_cast_resin)
                                            {{ $std->dry_cast_resin->kd_manhour }}
                                        @elseif ($std->dry_non_resin)
                                            {{ $std->dry_non_resin->kd_manhour }}
                                        @elseif ($std->repair)
                                            {{ $std->repair->kd_manhour }}
                                        @elseif ($std->oil_custom)
                                            {{ $std->oil_custom->kd_manhour }}
                                        @elseif ($std->oil_standard)
                                            {{ $std->oil_standard->kd_manhour }}
                                        @elseif ($std->vt)
                                            {{ $std->vt->kd_manhour }}
                                        @elseif ($std->ct)
                                            {{ $std->ct->kd_manhour }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="" type="button" class="btn btn-primary m-1"><i
                                                class="fa-solid fa-circle-info m-1"></i></a>
                                        <a type="button" href="{{ route('dryresin.edit', ['id' => $std->id]) }}"
                                            class="btn btn-primary m-1"><i class="fa-solid fa-pen-to-square m-1"></i></a>
                                        <a href="#" class="btn btn-primary m-1" data-toggle="modal"
                                            data-target=".bd-example-modal-sm"
                                            onclick="
                                                    event.preventDefault();
                                                    if (confirm('Do you want to remove this?')) {
                                                    document.getElementById('delete-row-{{ $std->id }}').submit();
                                                    }">
                                            <i class="fa-solid fa-trash m-1"></i>
                                        </a>
                                        <form id="delete-row-{{ $std->id }}"
                                            action="{{ route('delete', ['id' => $std->id]) }}" method="POST">
                                            <input type="hidden" name="_method" value="DELETE">
                                            @csrf
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        No record found!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- - - - - - - - - - - - end content-- - - - - - - - - - - -->
@endsection
