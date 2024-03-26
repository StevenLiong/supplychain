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

                <!-- <div class="dropdown ml-3 mb-3 mb-sm-0">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-search mr-2"></i>Filter Data
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item filter-link" data-category="Dry Cast Resin">Dry Cast Resin</a>
                        <a class="dropdown-item filter-link" data-category="Dry Non Cast Resin">Dry Non Resin</a>
                    </div>
                </div> -->

                <form id="filterForm" method="GET" action="{{ url('/standardized_work/FilterData') }}">
                    @csrf
                    <div class="dropdown ml-3 mb-3 mb-sm-0">
                        <select class="btn btn-primary dropdown-toggle" name="category" id="filterCategorySelect">
                            <option value="all">No Filter</option>
                            <option value="Dry Cast Resin">Dry Cast Resin</option>
                            <option value="Dry Non Cast Resin">Dry Non Resin</option>
                            <option value="CT">CT</option>
                            <option value="VT">VT</option>
                            <option value="Oil Standart">Oil Standart</option>
                            <option value="Oil Custom">Oil Custom</option>
                            <option value="Repair">Repair</option>
                        </select>
                        <button type="submit" class="btn btn-primary">
                            Filter <i class="fa-solid fa-refresh"></i>
                        </button>
                    </div>
                </form>
                <div class="ml-auto mr-3 float-right">
                    {{-- <a href="#" class="ya-deh btn btn-primary ">
                        <i class="mr-2 fa-solid fa-print"></i>Print
                    </a> --}}
                </div>
                <div class=" mr-3 float-right">

                    <form action="/logout" method="POST">
                        @csrf
                        <button class="ya-deh btn btn-primary" type="submit"><i
                                class=" fa-solid fa-power-off"></i></button>
                    </form>
                </div>
            </div>
            <div id="filteredResults" class="table-responsive">
                <div id="datatable_wrapper" id="filteredTable" class="dataTables_wrapper">
                    <table id="datatable" class="table data-table table-striped" data-ordering="false">
                        <thead>
                            <tr>
                            <tr class="ligth" style="text-align: center;">
                                <th>Category</th>
                                <th>Date</th>
                                <th>Nomor SO</th>
                                <th>Hours</th>
                                <th>Capacity</th>
                                <th>kode Man Hour</th>
                                <th>kode Finish Good</th>
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
                                            {{ $std->nama_product }}
                                        @elseif ($std->dry_non_resin)
                                            {{ $std->nama_product }}
                                        @elseif ($std->repair)
                                            {{ $std->nama_product }}
                                        @elseif ($std->oil_custom)
                                            {{ $std->nama_product }}
                                        @elseif ($std->oil_standard)
                                            {{ $std->nama_product }}
                                        @elseif ($std->vt)
                                            {{ $std->nama_product }}
                                        @elseif ($std->ct)
                                            {{ $std->nama_product }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($std->dry_cast_resin)
                                            {{ $std->dry_cast_resin->created_at->format('d-m-Y') }}
                                        @elseif ($std->dry_non_resin)
                                            {{ $std->dry_non_resin->created_at->format('d-m-Y') }}
                                        @elseif ($std->repair)
                                            {{ $std->repair->created_at->format('d-m-Y') }}
                                        @elseif ($std->oil_custom)
                                            {{ $std->oil_custom->created_at->format('d-m-Y') }}
                                        @elseif ($std->oil_standard)
                                            {{ $std->oil_standard->created_at->format('d-m-Y') }}
                                        @elseif ($std->vt)
                                            {{ $std->vt->created_at->format('d-m-Y') }}
                                        @elseif ($std->ct)
                                            {{ $std->ct->created_at->format('d-m-Y') }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($std->dry_cast_resin)
                                            {{ $std->nomor_so }}
                                        @elseif ($std->dry_non_resin)
                                            {{ $std->nomor_so }}
                                        @elseif ($std->repair)
                                            {{ $std->nomor_so }}
                                        @elseif ($std->oil_custom)
                                            {{ $std->nomor_so }}
                                        @elseif ($std->oil_standard)
                                            {{ $std->nomor_so }}
                                        @elseif ($std->vt)
                                            {{ $std->nomor_so }}
                                        @elseif ($std->ct)
                                            {{ $std->nomor_so }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($std->dry_cast_resin)
                                            {{ $std->total_hour }}
                                        @elseif ($std->dry_non_resin)
                                            {{ $std->total_hour }}
                                        @elseif ($std->repair)
                                            {{ $std->total_hour }}
                                        @elseif ($std->oil_custom)
                                            {{ $std->total_hour }}
                                        @elseif ($std->oil_standard)
                                            {{ $std->total_hour }}
                                        @elseif ($std->vt)
                                            {{ $std->total_hour }}
                                        @elseif ($std->ct)
                                            {{ $std->total_hour }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($std->dry_cast_resin)
                                            {{ $std->ukuran_kapasitas }}
                                        @elseif ($std->dry_non_resin)
                                            {{ $std->ukuran_kapasitas }}
                                        @elseif ($std->repair)
                                            {{ $std->ukuran_kapasitas }}
                                        @elseif ($std->oil_custom)
                                            {{ $std->ukuran_kapasitas }}
                                        @elseif ($std->oil_standard)
                                            {{ $std->ukuran_kapasitas }}
                                        @elseif ($std->vt)
                                            {{ $std->ukuran_kapasitas }}
                                        @elseif ($std->ct)
                                            {{ $std->ukuran_kapasitas }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($std->dry_cast_resin)
                                            {{ $std->kd_manhour }}
                                        @elseif ($std->dry_non_resin)
                                            {{ $std->kd_manhour }}
                                        @elseif ($std->repair)
                                            {{ $std->kd_manhour }}
                                        @elseif ($std->oil_custom)
                                            {{ $std->kd_manhour }}
                                        @elseif ($std->oil_standard)
                                            {{ $std->kd_manhour }}
                                        @elseif ($std->vt)
                                            {{ $std->kd_manhour }}
                                        @elseif ($std->ct)
                                            {{ $std->kd_manhour }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($std->dry_cast_resin)
                                            {{ $std->dry_cast_resin->id_fg }}
                                        @elseif ($std->dry_non_resin)
                                            {{ $std->dry_non_resin->id_fg }}
                                        @elseif ($std->repair)
                                            {{ $std->repair->id_fg }}
                                        @elseif ($std->oil_custom)
                                            {{ $std->oil_custom->id_fg }}
                                        @elseif ($std->oil_standard)
                                            {{ $std->oil_standard->id_fg }}
                                        @elseif ($std->vt)
                                            {{ $std->vt->id_fg }}
                                        @elseif ($std->ct)
                                            {{ $std->ct->id_fg }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a type="button" href="{{ route('dryresin.detail', ['id' => $std->id]) }}"
                                            class="btn btn-primary m-1"><i class="fa-solid fa-circle-info m-1"></i></a>
                                        <a type="button" href="{{ route('dryresin.edit', ['id' => $std->id]) }}"
                                            class="btn btn-primary m-1"><i class="fa-solid fa-pen-to-square m-1"></i></a>
                                        <a href="#" class="btn btn-primary m-1" data-toggle="modal"
                                            data-target=".delete-modal">
                                            {{-- onclick="
                                                    event.preventDefault();
                                                    if (confirm('Do you want to remove this?')) {
                                                    document.getElementById('delete-row-{{ $std->id }}').submit();
                                                    }"> --}}
                                            <i class="fa-solid fa-trash m-1"></i>
                                        </a>
                                        <!-- delete modal -->
                                        <div class="modal fade delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Yakin ingin menghapus data ini?</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-row-{{ $std->kd_manhour }}').submit();">Hapus</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <form id="delete-row-{{ $std->kd_manhour }}" action="{{ route('delete', ['kd_manhour' => $std->kd_manhour]) }}" method="POST">
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

    <script>
        $(document).ready(function() {
            $('.filter-link').on('click', function () {
                var selectedCategory = $(this).data('category');
                console.log('Selected Category:', selectedCategory);
                $('#filterCategorySelect').val(selectedCategory);
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                sendFilterRequest(selectedCategory);
            });
        });

        function sendFilterRequest(selectedCategory) {
            $.ajax({
                url: '/standardized_work/FilterData',
                type: 'GET',
                data: { category: selectedCategory },
            });
        }
    </script>
@endsection
