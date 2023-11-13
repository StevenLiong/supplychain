@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Rack Checking</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- notif session --}}
            <div class="row px-2">
                <div class="col-lg-8">
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
                                onclick=window.location="{{ url('storage/rawmaterial/listmaterial/create') }}">Plot Material</button>
                        </div>
                        {{-- btn create end --}}

                        {{-- search --}}
                        <div>
                            <form action="{{ url('storage/rawmaterial/listmaterial') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm rounded-0"
                                        placeholder="cari nama material" name="search" value="{{ request('search') }}">
                                    <button class="btn btn-red btn-xs rounded-0" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                        {{-- search end --}}
                    </div>
                </div>
                <div class="card-body">
                    {{-- table RackChecking --}}
                    <div class="table-responsive">
                        @if ($materialRak->isNotEmpty())
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-secondary">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Kode Rak</th>
                                        <th>Gudang</th>
                                        <th>Kode Material</th>
                                        <th>Nama Material</th>
                                        <th>Qty</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($materialRak as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $materialRak->firstItem() + $key }}</td>
                                            <td>{{ $item->rak->kd_rak }}</td>
                                            <td>{{ $item->rak->gudang->nama_gudang }}</td>
                                            <td>{{ $item->material->kd_material }}</td>
                                            <td>{{ $item->material->nama_material }}</td>
                                            <td>{{ $item->qty_rak }}</td>
                                            <td class="text-center ">
                                                <div class="btn-group">

                                                    <!-- edit -->
                                                    <button type="button" class="btn btn-xs btn-warning rounded-0 "
                                                        onclick="window.location='{{ url('storage/rawmaterial/listmaterial/' . $item->id . '/edit') }}'">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" fill="none">
                                                            <path
                                                                d="M7.41256 7H6.49135C6.00271 7 5.53408 7.21071 5.18856 7.58579C4.84304 7.96086 4.64893 8.46957 4.64893 9V18C4.64893 18.5304 4.84304 19.0391 5.18856 19.4142C5.53408 19.7893 6.00271 20 6.49135 20H14.7823C15.2709 20 15.7395 19.7893 16.085 19.4142C16.4306 19.0391 16.6247 18.5304 16.6247 18V17"
                                                                stroke="#252525" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                            <path
                                                                d="M15.7034 4.99998L18.467 7.99998M19.7429 6.58499C20.1057 6.19114 20.3095 5.65697 20.3095 5.09998C20.3095 4.543 20.1057 4.00883 19.7429 3.61498C19.3801 3.22114 18.888 2.99988 18.3749 2.99988C17.8618 2.99988 17.3697 3.22114 17.0069 3.61498L9.25488 12V15H12.0185L19.7429 6.58499Z"
                                                                stroke="#252525" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </button>
                                                    {{-- hapus --}}
                                                    <form action="{{ url('storage/rawmaterial/listmaterial/' . $item->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-xs btn-danger rounded-0" type="submit"
                                                            onclick="return confirm('Yakin menghapus ?')">
                                                            <svg width="20" height="20" viewBox="0 0 21 21"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M17.2902 9.4043V19.2796C17.2902 19.6278 17.0167 19.9099 16.6793 19.9099H3.64702C3.30964 19.9099 3.03613 19.6278 3.03613 19.2796V9.4043"
                                                                    stroke="black" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                                <path d="M8.12695 15.7077V9.4043" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                                <path d="M12.1997 15.7077V9.4043" stroke="black"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                                <path
                                                                    d="M19.3267 5.20226H14.2359M14.2359 5.20226V1.63034C14.2359 1.28221 13.9624 1 13.625 1H6.70163C6.36424 1 6.09074 1.28221 6.09074 1.63034V5.20226M14.2359 5.20226H6.09074M1 5.20226H6.09074"
                                                                    stroke="black" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center">Tidak ada data</p>
                        @endif

                    </div>
                    {{-- table RackChecking end --}}
                </div>
                {{-- pagination --}}
                <div class="row mx-3 mb-3">
                    <div class="col text-secondary">
                        Showing
                        to
                        of
                        data
                        {{-- <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav> --}}
                    </div>
                    <div class="col d-flex justify-content-end">
                        {{ $materialRak->appends(request()->input())->links() }}
                    </div>
                </div>
                {{-- pagination end --}}
            </div>




        </div>
    </div>
@endsection
