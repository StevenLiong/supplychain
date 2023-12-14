@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Inventory Finishedgood</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- notif session --}}
            @if (session()->has('success'))
                <script>
                    showSweetAlert('success', '{{ session('success') }}');
                </script>
            @endif

            {{-- notif session end --}}

            <div class="card rounded-0 m-2">
                <div class="card-header">
                    <div class="row justify-content-between mx-2">
                        {{-- button create data --}}
                        <div class="btn-create">
                            <button type="button" class="btn btn-xs btn-gray"
                                onclick=window.location="{{ url('datamaster/finishedgood/create') }}">Create Data</button>
                        </div>
                        {{-- button create data end --}}

                        {{-- search --}}
                        <div>
                            <form action="{{ url('datamaster/Finishedgood') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm rounded-0"
                                        placeholder="cari nama Finishedgood..." name="search"
                                        value="{{ request('search') }}">
                                    <button class="btn btn-red rounded-0 btn-xs" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                        {{-- search ednd --}}
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- table Finishedgood --}}
                        <table class="table table-sm table-bordered table-hover">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>WO</th>
                                    <th>Kode Finishedgood</th>
                                    <th>Qty</th>
                                    <th>kVA</th>
                                    <th>NSP</th>
                                    <th>NSK</th>
                                    <th>Gudang</th>
                                    <th>Cetak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($finishedgood as $item)
                                <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->id_wo }}</td>
                                        <td>{{ $item->kd_finishedgood }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->kva }}</td>
                                        <td>{{ $item->nsp }}</td>
                                        <td>{{ $item->nsk }}</td>
                                        <td>{{ $item->gudang }}</td>
                                        <td class="text-center">
                                            {{-- cetak print --}}
                                            <a href="{{ url('datamaster/material/print/' . $item->id) }}" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 18 24" fill="none">
                                                    <path
                                                        d="M12 8V5H6V8H4.5V3H13.5V8H12ZM13.5 12.5C13.7125 12.5 13.8907 12.404 14.0347 12.212C14.1787 12.02 14.2505 11.7827 14.25 11.5C14.25 11.2167 14.178 10.979 14.034 10.787C13.89 10.595 13.712 10.4993 13.5 10.5C13.2875 10.5 13.1093 10.596 12.9653 10.788C12.8213 10.98 12.7495 11.2173 12.75 11.5C12.75 11.7833 12.822 12.021 12.966 12.213C13.11 12.405 13.288 12.5007 13.5 12.5ZM12 19V15H6V19H12ZM13.5 21H4.5V17H1.5V11C1.5 10.15 1.71875 9.43733 2.15625 8.862C2.59375 8.28667 3.125 7.99933 3.75 8H14.25C14.8875 8 15.422 8.28767 15.8535 8.863C16.285 9.43833 16.5005 10.1507 16.5 11V17H13.5V21ZM15 15V11C15 10.7167 14.928 10.479 14.784 10.287C14.64 10.095 14.462 9.99933 14.25 10H3.75C3.5375 10 3.35925 10.096 3.21525 10.288C3.07125 10.48 2.9995 10.7173 3 11V15H4.5V13H13.5V15H15Z"
                                                        fill="#252525" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                        {{-- table Finishedgood end --}}

                    </div>
                </div>

                {{-- pagination --}}
                {{-- <div class="row mx-3 mb-3">
                    <div class="col text-secondary">
                        Showing {{ $Finishedgood->firstItem() }}
                        to {{ $Finishedgood->lastItem() }}
                        of {{ $Finishedgood->total() }}
                        data
                        
                    </div>
                    <div class="col d-flex justify-content-end">
                        {{ $Finishedgood->appends(request()->input())->links() }}
                    </div>
                </div> --}}
                {{-- pagination end --}}
            </div>



        </div>
    </div>
@endsection
