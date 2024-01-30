@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Data Delivery List</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- notif session --}}
            
            {{-- notif session end --}}

            {{-- card tabel --}}
            <div class="card rounded-0 m-2">
                <div class="card-header">
                    <div class="row justify-content-between mx-2">
                        {{-- btn create --}}
                        <div class="btn-create ">
                            <button type="button" class="btn btn-xs btn-gray"
                                onclick=window.location="{{ url('shipping/deliveryreceipt/create') }}">Create data</button>
                        </div>
                        {{-- btn create end--}}

                        {{-- search --}}
                        <div class="">
                            <form action="{{ url('shipping/deliveryreceipt') }}">
                                <div class="input-group ">
                                    <input type="text" class="form-control form-control-sm rounded-0"
                                        placeholder="cari delivery receipt..." name="search" value="{{ request('search') }}">
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
                                        <th>Nama Gudang</th>
                                        <th>Tanggal Delivery</th>
                                        <th>No. SO</th>
                                        <th>No. DO</th>
                                        <th>Packaging</th>
                                        <th>Ekspedisi</th>
                                        <th>No. Kendaraan</th>                                        
                                        <th>Cetak</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($delivery as $item)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td class="text-center">{{ $item->finishedgood->gudang}}</td>
                                            <td class="text-center">{{ $item->Tanggal_Delivery}}</td>
                                            <td class="text-center">{{ $item->NO_SO}}</td>
                                            <td class="text-center">{{ $item->NO_DO}}</td>
                                            <td class="text-center">{{ $item->packaging}}</td>
                                            <td class="text-center">{{ $item->ekspedisi}}</td>
                                            <td class="text-center">{{ $item->no_kendaraan}}</td>
                                            <td class="text-center">
                                                <a href="{{ url('shipping/deliveryreceipt/print/'.$item->no_delivery) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="24"
                                                        viewBox="0 0 18 24" fill="none">
                                                        <path
                                                            d="M12 8V5H6V8H4.5V3H13.5V8H12ZM13.5 12.5C13.7125 12.5 13.8907 12.404 14.0347 12.212C14.1787 12.02 14.2505 11.7827 14.25 11.5C14.25 11.2167 14.178 10.979 14.034 10.787C13.89 10.595 13.712 10.4993 13.5 10.5C13.2875 10.5 13.1093 10.596 12.9653 10.788C12.8213 10.98 12.7495 11.2173 12.75 11.5C12.75 11.7833 12.822 12.021 12.966 12.213C13.11 12.405 13.288 12.5007 13.5 12.5ZM12 19V15H6V19H12ZM13.5 21H4.5V17H1.5V11C1.5 10.15 1.71875 9.43733 2.15625 8.862C2.59375 8.28667 3.125 7.99933 3.75 8H14.25C14.8875 8 15.422 8.28767 15.8535 8.863C16.285 9.43833 16.5005 10.1507 16.5 11V17H13.5V21ZM15 15V11C15 10.7167 14.928 10.479 14.784 10.287C14.64 10.095 14.462 9.99933 14.25 10H3.75C3.5375 10 3.35925 10.096 3.21525 10.288C3.07125 10.48 2.9995 10.7173 3 11V15H4.5V13H13.5V15H15Z"
                                                            fill="#252525" />
                                                    </svg>
                                                </a>
                                            </td> 
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    
                                                    {{-- lihat --}}
                                                    <button type="button" class="btn btn-xs btn-primary rounded-0"
                                                        onclick="window.location='{{ url('receiving/incoming/' . $item->id) }}'">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" fill="none">
                                                            <path
                                                                d="M23.1853 11.6962C23.1525 11.6222 22.3584 9.86062 20.5931 8.09531C18.2409 5.74312 15.27 4.5 12 4.5C8.72999 4.5 5.75905 5.74312 3.40687 8.09531C1.64155 9.86062 0.843741 11.625 0.814679 11.6962C0.772035 11.7922 0.75 11.896 0.75 12.0009C0.75 12.1059 0.772035 12.2097 0.814679 12.3056C0.847491 12.3797 1.64155 14.1403 3.40687 15.9056C5.75905 18.2569 8.72999 19.5 12 19.5C15.27 19.5 18.2409 18.2569 20.5931 15.9056C22.3584 14.1403 23.1525 12.3797 23.1853 12.3056C23.2279 12.2097 23.25 12.1059 23.25 12.0009C23.25 11.896 23.2279 11.7922 23.1853 11.6962ZM12 18C9.11437 18 6.59343 16.9509 4.50655 14.8828C3.65028 14.0313 2.92179 13.0603 2.34374 12C2.92164 10.9396 3.65014 9.9686 4.50655 9.11719C6.59343 7.04906 9.11437 6 12 6C14.8856 6 17.4066 7.04906 19.4934 9.11719C20.3514 9.9684 21.0815 10.9394 21.6609 12C20.985 13.2619 18.0403 18 12 18ZM12 7.5C11.11 7.5 10.2399 7.76392 9.49993 8.25839C8.7599 8.75285 8.18313 9.45566 7.84253 10.2779C7.50194 11.1002 7.41282 12.005 7.58646 12.8779C7.76009 13.7508 8.18867 14.5526 8.81801 15.182C9.44735 15.8113 10.2492 16.2399 11.1221 16.4135C11.995 16.5872 12.8998 16.4981 13.7221 16.1575C14.5443 15.8169 15.2471 15.2401 15.7416 14.5001C16.2361 13.76 16.5 12.89 16.5 12C16.4988 10.8069 16.0242 9.66303 15.1806 8.81939C14.337 7.97575 13.1931 7.50124 12 7.5ZM12 15C11.4066 15 10.8266 14.8241 10.3333 14.4944C9.83993 14.1648 9.45542 13.6962 9.22835 13.1481C9.00129 12.5999 8.94188 11.9967 9.05764 11.4147C9.17339 10.8328 9.45911 10.2982 9.87867 9.87868C10.2982 9.45912 10.8328 9.1734 11.4147 9.05764C11.9967 8.94189 12.5999 9.0013 13.148 9.22836C13.6962 9.45542 14.1648 9.83994 14.4944 10.3333C14.824 10.8266 15 11.4067 15 12C15 12.7956 14.6839 13.5587 14.1213 14.1213C13.5587 14.6839 12.7956 15 12 15Z"
                                                                fill="#252525" />
                                                        </svg>
                                                    </button>
                                                    {{-- lihat end --}}

                                                    {{-- edit rak checking --}}
                                                    <button type="button" class="btn btn-xs btn-warning rounded-0"
                                                        onclick="window.location='{{ url('receiving/incoming/' . $item->id . '/edit') }}'">
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
                                                    {{-- edit end --}}
                                                    {{-- hapus --}}
                                                    <form action="{{ url('receiving/incoming/' . $item->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-xs btn-danger rounded-0" type="submit"
                                                            onclick="return confirm('Yakin menghapus ?')">
                                                            <svg width="18" height="18" viewBox="0 0 21 21"
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
                                    @endforeach
                                </tbody>
                            </table>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
@endsection