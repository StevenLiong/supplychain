@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Data Kedatangan</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- table dry type --}}
            <div class="btn-create px-3 mb-3">
                <button type="button" class="btn btn-sm btn-gray"
                    onclick=window.location="{{ url('receiving/incoming/create') }}">Create data</button>
            </div>

            <div class="table-responsive px-3">
                <table class="table table-bordered table-hover">
                    <thead class="table-secondary">
                        <tr class="text-center">
                            <th>No</th>
                            <th>No PO</th>
                            <th>NO Surat Jalan</th>
                            <th>Kode Material</th>
                            <th>Nama Material</th>
                            <th>Nama Supplier</th>
                            <th>Qty Kedatangan</th>
                            <th>batch Kedatangan</th>
                            <th>Cetak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($incoming as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->no_po }}</td>
                                <td>{{ $item->no_surat_jalan }}</td>
                                <td>{{ $item->material->kd_material }}</td>
                                <td>{{ $item->material->nama_material }}</td>
                                <td>{{ $item->supplier->nama_supplier }}</td>
                                <td>{{ $item->qty_kedatangan }}</td>
                                <td>{{ $item->batch_datang }}</td>
                                <td class="text-center">
                                    <a href="{{ url('receiving/incoming/print') }}" target="_blank" id="print">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="24"
                                            viewBox="0 0 18 24" fill="none">
                                            <path
                                                d="M12 8V5H6V8H4.5V3H13.5V8H12ZM13.5 12.5C13.7125 12.5 13.8907 12.404 14.0347 12.212C14.1787 12.02 14.2505 11.7827 14.25 11.5C14.25 11.2167 14.178 10.979 14.034 10.787C13.89 10.595 13.712 10.4993 13.5 10.5C13.2875 10.5 13.1093 10.596 12.9653 10.788C12.8213 10.98 12.7495 11.2173 12.75 11.5C12.75 11.7833 12.822 12.021 12.966 12.213C13.11 12.405 13.288 12.5007 13.5 12.5ZM12 19V15H6V19H12ZM13.5 21H4.5V17H1.5V11C1.5 10.15 1.71875 9.43733 2.15625 8.862C2.59375 8.28667 3.125 7.99933 3.75 8H14.25C14.8875 8 15.422 8.28767 15.8535 8.863C16.285 9.43833 16.5005 10.1507 16.5 11V17H13.5V21ZM15 15V11C15 10.7167 14.928 10.479 14.784 10.287C14.64 10.095 14.462 9.99933 14.25 10H3.75C3.5375 10 3.35925 10.096 3.21525 10.288C3.07125 10.48 2.9995 10.7173 3 11V15H4.5V13H13.5V15H15Z"
                                                fill="#252525" />
                                        </svg>
                                    </a>
                                </td>
                                <td class="text-center">
                                    {{-- lihat --}}
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="24"
                                            viewBox="0 0 23 24" fill="none">
                                            <g clip-path="url(#clip0_2351_2514)">
                                                <path
                                                    d="M21.4494 11.6962C21.4192 11.6222 20.6877 9.86062 19.0615 8.09531C16.8946 5.74312 14.1577 4.5 11.1454 4.5C8.133 4.5 5.39614 5.74312 3.22928 8.09531C1.60305 9.86062 0.868094 11.625 0.841321 11.6962C0.802037 11.7922 0.781738 11.896 0.781738 12.0009C0.781738 12.1059 0.802037 12.2097 0.841321 12.3056C0.871548 12.3797 1.60305 14.1403 3.22928 15.9056C5.39614 18.2569 8.133 19.5 11.1454 19.5C14.1577 19.5 16.8946 18.2569 19.0615 15.9056C20.6877 14.1403 21.4192 12.3797 21.4494 12.3056C21.4887 12.2097 21.509 12.1059 21.509 12.0009C21.509 11.896 21.4887 11.7922 21.4494 11.6962ZM11.1454 18C8.48709 18 6.16478 16.9509 4.24232 14.8828C3.45351 14.0313 2.78242 13.0603 2.24991 12C2.78228 10.9396 3.45339 9.9686 4.24232 9.11719C6.16478 7.04906 8.48709 6 11.1454 6C13.8036 6 16.126 7.04906 18.0484 9.11719C18.8388 9.9684 19.5113 10.9394 20.0451 12C19.4225 13.2619 16.7098 18 11.1454 18ZM11.1454 7.5C10.3255 7.5 9.52399 7.76392 8.84228 8.25839C8.16056 8.75285 7.62923 9.45566 7.31547 10.2779C7.00171 11.1002 6.91961 12.005 7.07957 12.8779C7.23952 13.7508 7.63434 14.5526 8.21409 15.182C8.79384 15.8113 9.53249 16.2399 10.3366 16.4135C11.1408 16.5872 11.9743 16.4981 12.7318 16.1575C13.4892 15.8169 14.1367 15.2401 14.5922 14.5001C15.0477 13.76 15.2908 12.89 15.2908 12C15.2897 10.8069 14.8526 9.66303 14.0754 8.81939C13.2982 7.97575 12.2445 7.50124 11.1454 7.5ZM11.1454 15C10.5988 15 10.0645 14.8241 9.60997 14.4944C9.1555 14.1648 8.80127 13.6962 8.5921 13.1481C8.38293 12.5999 8.3282 11.9967 8.43483 11.4147C8.54147 10.8328 8.80468 10.2982 9.19118 9.87868C9.57768 9.45912 10.0701 9.1734 10.6062 9.05764C11.1423 8.94189 11.698 9.0013 12.203 9.22836C12.708 9.45542 13.1396 9.83994 13.4432 10.3333C13.7469 10.8266 13.909 11.4067 13.909 12C13.909 12.7956 13.6178 13.5587 13.0996 14.1213C12.5813 14.6839 11.8783 15 11.1454 15Z"
                                                    fill="#252525" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_2351_2514">
                                                    <rect width="22.1091" height="24" fill="white"
                                                        transform="translate(0.0908203)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                    {{-- edit --}}
                                    <a href="{{ url('incoming/edit') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M7.41256 7H6.49135C6.00271 7 5.53408 7.21071 5.18856 7.58579C4.84304 7.96086 4.64893 8.46957 4.64893 9V18C4.64893 18.5304 4.84304 19.0391 5.18856 19.4142C5.53408 19.7893 6.00271 20 6.49135 20H14.7823C15.2709 20 15.7395 19.7893 16.085 19.4142C16.4306 19.0391 16.6247 18.5304 16.6247 18V17"
                                                stroke="#252525" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M15.7034 4.99998L18.467 7.99998M19.7429 6.58499C20.1057 6.19114 20.3095 5.65697 20.3095 5.09998C20.3095 4.543 20.1057 4.00883 19.7429 3.61498C19.3801 3.22114 18.888 2.99988 18.3749 2.99988C17.8618 2.99988 17.3697 3.22114 17.0069 3.61498L9.25488 12V15H12.0185L19.7429 6.58499Z"
                                                stroke="#252525" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- table dry type end --}}


            {{-- pagination --}}
            <div class="row ">
                <div class="col-12 p-3 ">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            {{-- pagination end --}}
        </div>
    </div>
    {{-- script print --}}
    <script>
        document.getElementById('print').addEventListener('click', function() {
            window.print(); // Memulai proses pencetakan
        });
    </script>
@endsection
