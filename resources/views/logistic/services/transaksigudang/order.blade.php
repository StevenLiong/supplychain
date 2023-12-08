@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Order Material (F)</h4>
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
                                onclick=window.location="{{ url('services/transaksigudang/order/create') }}">Order
                                Baru</button>
                        </div>
                        {{-- button create data end --}}

                        {{-- search --}}
                        <div>
                            <form action="{{ url('services/transaksigudang/order') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm rounded-0"
                                        placeholder="cari Nomor Bon...." name="search" value="{{ request('search') }}">
                                    <button class="btn btn-red rounded-0 btn-xs" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                        {{-- search ednd --}}
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($order->isNotEmpty())
                            {{-- table order --}}
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-secondary">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>No Bon</th>
                                        <th>Work Order</th>
                                        <th>Workcenter</th>
                                        <th>Tanggal </th>
                                        <th>kVA</th>
                                        <th>Status</th>
                                        <th>Cetak</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                @foreach ($order as $key => $item)
                                    <tbody>
                                        <tr>
                                            <td>{{ $order->firstItem() + $key }}</td>
                                            <td>{{ $item->no_bon }}</td>
                                            <td>{{ $item->id_wo }}</td>
                                            <td>{{ $item->nama_workcenter }}</td>
                                            <td>{{ $item->tanggal_bon }}</td>
                                            <td>{{ $item->wo->kva }}</td>
                                            <td class="text-center"><span class="badge badge-warning">{{ $item->statusText }}</span></td>
                                            <td class="text-center">
                                                {{-- cetak print --}}
                                                <a href="{{ url('services/transaksigudang/order/' . $item->nama_workcenter) }}"
                                                    target="_blank">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 18 24" fill="none">
                                                        <path
                                                            d="M12 8V5H6V8H4.5V3H13.5V8H12ZM13.5 12.5C13.7125 12.5 13.8907 12.404 14.0347 12.212C14.1787 12.02 14.2505 11.7827 14.25 11.5C14.25 11.2167 14.178 10.979 14.034 10.787C13.89 10.595 13.712 10.4993 13.5 10.5C13.2875 10.5 13.1093 10.596 12.9653 10.788C12.8213 10.98 12.7495 11.2173 12.75 11.5C12.75 11.7833 12.822 12.021 12.966 12.213C13.11 12.405 13.288 12.5007 13.5 12.5ZM12 19V15H6V19H12ZM13.5 21H4.5V17H1.5V11C1.5 10.15 1.71875 9.43733 2.15625 8.862C2.59375 8.28667 3.125 7.99933 3.75 8H14.25C14.8875 8 15.422 8.28767 15.8535 8.863C16.285 9.43833 16.5005 10.1507 16.5 11V17H13.5V21ZM15 15V11C15 10.7167 14.928 10.479 14.784 10.287C14.64 10.095 14.462 9.99933 14.25 10H3.75C3.5375 10 3.35925 10.096 3.21525 10.288C3.07125 10.48 2.9995 10.7173 3 11V15H4.5V13H13.5V15H15Z"
                                                            fill="#252525" />
                                                    </svg>
                                                </a>
                                            </td>
                                            <td width="5%">
                                                <div class="btn-group">
                                                    {{-- edit --}}
                                                    <button type="button" class="btn btn-xs btn-warning rounded-0 "
                                                        onclick="window.location='{{ url('services/transaksigudang/order/' . $item->id_boms . '/edit') }}'">
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
                                                    <form
                                                        action="{{ url('/services/transaksigudang/order/' . $item->id) }}"
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
                                                    {{-- hapus end --}}
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        @else
                            <p class="text-center ">Tidak ada data</p>
                        @endif
                        {{-- table order end --}}
                    </div>
                </div>

                {{-- pagination --}}
                <div class="row mx-3 mb-3">
                    <div class="col text-secondary">
                        Showing {{ $order->firstItem() }}
                        to {{ $order->lastItem() }}
                        of {{ $order->total() }}
                        data
                    </div>
                    <div class="col d-flex justify-content-end">
                        {{ $order->appends(request()->input())->links() }}
                    </div>
                </div>
                {{-- pagination end --}}
            </div>
        </div>
    </div>
@endsection
