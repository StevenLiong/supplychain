@extends('produksi.resource_work_planning.template.bar')
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Jumlah Man Power Production Line Repair</h4>
                </div>
            </div>
            <div class="card-body">

                <div class="row mb-4 align-items-center px-4">
                    <form action="{{ route('process.periodeRepair') }}" method="post" id="periodeRepairForm">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-md-auto">
                                <label for="periodeRepairSelect">Pilih Periode:</label>
                            </div>
                            <div class="col-md-auto">
                                <select class="custom-select" name="periodeRepair" id="periodeRepairSelect">
                                    <option value="1">Bulan Sekarang</option>
                                    <option value="2">Minggu sekarang</option>
                                    <option value="3">Minggu Depan</option>
                                    <option value="4">Bulan Depan</option>
                                </select>
                            </div>
                        </div>

                    </form>
                    {{-- <form action="{{ route('process.workcenter') }}" method="post" class="ml-2" id="workcenterForm">
                        @csrf
                        <select class="custom-select" name="selectedWorkcenter" id="workcenterSelect"><i
                                class="ri-arrow-down-s-line ml-2 mr-0">Hour/Day</i>
                            <option value="1">8 Hours/1 Day</option>
                            <option value="2">16 Hours/2 Day</option>
                            <option value="3">24 Hours/3 Day</option>
                        </select>
                    </form>
                    <form action="{{ route('process.workcenter') }}" method="post" class="ml-2" id="workcenterForm">
                        @csrf
                        <select class="custom-select" name="selectedWorkcenter" id="workcenterSelect"><i
                                class="ri-arrow-down-s-line ml-2 mr-0">shift</i>
                            <option value="1">Shift 1</option>
                            <option value="2">Shift 2</option>
                            <option value="3">Shift 3</option>
                        </select>
                    </form> --}}
                    {{-- <div class="dropdown status-dropdown ml-2 dropdown-toggl" id="dropdownMenuButton03"
                        data-toggle="dropdown" aria-expanded="false">
                        <div class="btn btn-primary">Work Center<i class="ri-arrow-down-s-line ml-2 mr-0"></i></div>
                        <div class="dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuButton03">
                            <a class="dropdown-item" href="#"> Untanking</a>
                            <a class="dropdown-item" href="#"> Bongkar</a>
                            <a class="dropdown-item" href="#"> Coil Making</a>
                            <a class="dropdown-item" href="#"> CCA</a>
                            <a class="dropdown-item" href="#"> Connect</a>
                            <a class="dropdown-item" href="#"> Final Assembly</a>
                            <a class="dropdown-item" href="#"> Finishing</a>
                            <a class="dropdown-item" href="#"> QC Testing</a>
                        </div>
                    </div>
                    <div class="ml-auto mr-3" style="align-items: d-flex right;">
                        <a href="#" class="btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i
                                class="mr-2 fa-solid fa-print"></i>Print</a>
                    </div> --}}
                </div>
                <div class="table-responsive">
                    <div id="datatable_wrapper" class="dataTables_wrapper">
                        <table id="datatable" class="table table-striped dataTable" role="grid"
                            aria-describedby="datatable_info">
                            <thead class="text-center">
                                <tr>
                                    <th>Work Center</th>
                                    <th>Total MH</th>
                                    <th>Total Kebutuhan MP</th>
                                    <th>Ketersediaan MP</th>
                                    <th>Kekurangan MP</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td>
                                        {{ $data['wc_Untangking'] }}
                                    </td>
                                    <td>
                                        {{$data['jumlahtotalHour_untangking']}}
                                    </td>
                                    <td>
                                        {{ $data['kebutuhanMPUntangking'] }}
                                    </td>
                                    <td>
                                        {{ $data['ketersediaanMPUntangking'] }}
                                    </td>
                                    <td>
                                        {{ $data['selisihMPUntangking'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ $data['wc_Bongkar'] }}
                                    </td>
                                    <td>
                                        {{$data['jumlahtotalHour_bongkar']}}
                                    </td>
                                    <td>
                                        {{ $data['kebutuhanMPBongkar'] }}
                                    </td>
                                    <td>
                                        {{ $data['ketersediaanMPBongkar'] }}
                                    </td>
                                    <td>
                                        {{ $data['selisihMPBongkar'] }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        {{ $data['wc_Coil_Making'] }}
                                    </td>
                                    <td>
                                        {{$data['jumlahtotalHourCoil_Making']}}
                                    </td>
                                    <td>
                                        {{ $data['kebutuhanMPCoil_Making'] }}
                                    </td>
                                    <td>
                                        {{ $data['ketersediaanMPCoil_Making'] }}
                                    </td>
                                    <td>
                                        {{ $data['selisihMPCoil_Making'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ $data['wc_Core_Assembly'] }}
                                    </td>
                                    <td>
                                        {{$data['jumlahtotalHour_CoreAssembly']}}
                                    </td>
                                    <td>
                                        {{ $data['kebutuhanMPCoreAssembly'] }}
                                    </td>
                                    <td>
                                        {{ $data['ketersediaanMPCoreAssembly'] }}
                                    </td>
                                    <td>
                                        {{ $data['selisihMPCoreAssembly'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ $data['wc_Conect_Assembly'] }}
                                    </td>
                                    <td>
                                        {{$data['jumlahtotalHour_ConectAssembly']}}
                                    </td>
                                    <td>
                                        {{ $data['kebutuhanMPConectAssembly'] }}
                                    </td>
                                    <td>
                                        {{ $data['ketersediaanMPConect_Assembly'] }}
                                    </td>
                                    <td>
                                        {{ $data['selisihMPConect_Assembly'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ $data['wc_Final_Assembly'] }}
                                    </td>
                                    <td>
                                        {{$data['jumlahtotalHour_FinalAssembly']}}
                                    </td>
                                    <td>
                                        {{ $data['kebutuhanMPFinal_Assembly'] }}
                                    </td>
                                    <td>
                                        {{ $data['ketersediaanMPFinal_Assembly'] }}
                                    </td>
                                    <td>
                                        {{ $data['selisihMPFinal_Assembly'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ $data['wc_Special_Final_Assembly'] }}
                                    </td>
                                    <td>
                                        {{$data['jumlahtotalHour_SpecialFinalAssembly']}}
                                    </td>
                                    <td>
                                        {{ $data['kebutuhanMPSpecial_Final_Assembly'] }}
                                    </td>
                                    <td>
                                        {{ $data['ketersediaanMPSpecial_Final_Assembly'] }}
                                    </td>
                                    <td>
                                        {{ $data['selisihMPSpecial_Final_Assembly'] }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        {{ $data['wc_Finishing'] }}
                                    </td>
                                    <td>
                                        {{$data['jumlahtotalHour_Finishing']}}
                                    </td>
                                    <td>
                                        {{ $data['kebutuhanMPFinishing'] }}
                                    </td>
                                    <td>
                                        {{ $data['ketersediaanMPFinishing'] }}
                                    </td>
                                    <td>
                                        {{ $data['selisihMPFinishing'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ $data['wc_cabelbox'] }}
                                    </td>
                                    <td>
                                        {{$data['jumlahtotalHour_cabelbox']}}
                                    </td>
                                    <td>
                                        {{ $data['kebutuhanMPCabelBox'] }}
                                    </td>
                                    <td>
                                        {{ $data['ketersediaanMPCabelBox'] }}
                                    </td>
                                    <td>
                                        {{ $data['selisihMPCabelBox'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ $data['wc_Wiring_Controlbox'] }}
                                    </td>
                                    <td>
                                        {{$data['jumlahtotalHour_wiring_controlbox']}}
                                    </td>
                                    <td>
                                        {{ $data['kebutuhanMPWiringControlBox'] }}
                                    </td>
                                    <td>
                                        {{ $data['ketersediaanMPWiringControlBox'] }}
                                    </td>
                                    <td>
                                        {{ $data['selisihMPWiringControlBox'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ $data['wc_Coper_link'] }}
                                    </td>
                                    <td>
                                        {{$data['jumlahtotalHour_copper_link']}}
                                    </td>
                                    <td>
                                        {{ $data['kebutuhanMPCoperLink'] }}
                                    </td>
                                    <td>
                                        {{ $data['ketersediaanMPCoperLink'] }}
                                    </td>
                                    <td>
                                        {{ $data['selisihMPCoperLink'] }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        {{ $data['wc_Radioator_Panel'] }}
                                    </td>
                                    <td>
                                        {{$data['jumlahtotalHour_radiator_panel']}}
                                    </td>
                                    <td>
                                        {{ $data['kebutuhanMPRadiatorPanel'] }}
                                    </td>
                                    <td>
                                        {{ $data['ketersediaanMPRadiatorPanel'] }}
                                    </td>
                                    <td>
                                        {{ $data['selisihMPRadiatorPanel'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ $data['wc_Conservator'] }}
                                    </td>
                                    <td>
                                        {{$data['jumlahtotalHour_conservator']}}
                                    </td>
                                    <td>
                                        {{ $data['kebutuhanMPConservator'] }}
                                    </td>
                                    <td>
                                        {{ $data['ketersediaanMPConservator'] }}
                                    </td>
                                    <td>
                                        {{ $data['selisihMPConservator'] }}
                                    </td>
                                </tr>


                            </tbody>
                            {{-- <tfoot class="text-center">
                                <tr>
                                    <th>Total</th>
                                    <th>20</th>
                                    <th>15</th>
                                    <th>20</th>
                                    <th>15</th>
                                </tr>
                                <tr>
                                    <th>Catatan</th>
                                    <th>-3</th>
                                    <th>1</th>
                                    <th>-1</th>
                                    <th>-2</th>
                                </tr>
                            </tfoot> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Mendeteksi perubahan pada dropdown
            $('#periodeRepairSelect').change(function() {
                // Mengambil nilai yang dipilih
                var selectedValue = $(this).val();

                // Menyimpan nilai yang dipilih dalam localStorage
                localStorage.setItem('selectedPeriodeRepair', selectedValue);

                // Mengirimkan formulir secara otomatis
                $('#periodeRepairForm').submit();
            });

            // Memeriksa apakah ada nilai yang disimpan dalam localStorage
            var storedValue = localStorage.getItem('selectedPeriodeRepair');
            if (storedValue) {
                // Menetapkan nilai yang disimpan sebagai nilai awal dropdown
                $('#periodeRepairSelect').val(storedValue);
            }
        });
    </script>
@endsection
