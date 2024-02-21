@extends('planner.template.bar')
@section('content')
@section('kapasitas_produksi', 'active')
@section('main', 'show')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Edit Data Kapasitas Produksi {{$dataKp->tanggal}}</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="row d-flex mb-4">
                <button id="drytype-btn" class="btn btn-primary ml-2">Drytype</button>
                <button id="pl1pl2-btn" class="btn btn-primary ml-2">PL1 & PL2</button>
                <button id="pl3-btn" class="btn btn-primary ml-2">PL3</button>
        </div>           

        <form method="POST" action="{{ route('kp.updatekp', ['id' => $dataKp->id]) }}">
            @method('PUT')
            @csrf
            <div class="form-row">
                <div style="width: 1500px;">
                    <div id="drytype-section">
                        <div class="col-md-12 mb-3">
                            <h4 class="text-center align-middle">Perhitungan Kapasitas Produksi Dry Type</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12 mb-3">
                                    <!-- <label for="validationDefault01">OEE (Ubah Percentage ke Decimal Contoh 93% => 0.93)</label> -->
                                    <label for="validationDefault01">OEE (Efektivitas)</label>
                                    <br>
                                    <h8>(Ubah Percentage ke Decimal Contoh 93% => 0.93)</h8>
                                    <input type="text" class="form-control" name="oee_drytype" value="{{ $dataKp->oee_drytype }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault01">Output / Hari</label>
                                    <input type="text" class="form-control" name="output_drytype" value="{{ $dataKp->output_drytype }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault01">Shift Kerja</label>
                                    <input type="text" class="form-control" name="shift_kerja_drytype" value="{{ $dataKp->shift_kerja_drytype }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <h8 class="text-center align-middle" style="font-size: 10 px;">Notes: Apabila ingin menaikkan kapasitas produksi ubah shift kerja</h8>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault01">Jam Kerja</label>
                                    <input type="text" class="form-control" name="jam_kerja_drytype" value="{{ $dataKp->jam_kerja_drytype }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault01">Aktual OEE</label>
                                    <input type="text" class="form-control" name="aktual_oee_drytype" value="{{ $dataKp->aktual_oee_drytype }}" required>
                                </div>                
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <h4 class="text-center align-middle">Hasil Perhitungan</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="validationDefault01">Takt Time</label>
                                <input type="text" class="form-control" name="takt_time_drytype" id="takt_time_drytype" required disabled>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="validationDefault01">Available Work Time</label>
                                <input type="text" class="form-control" name="available_work_time_drytype" id="available_work_time_drytype" required disabled>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="validationDefault01">Kapasitas Produksi</label>
                                <input type="text" class="form-control" name="kap_produksi_drytype" id="kap_produksi_drytype" required disabled>
                            </div>
                        </div>
                    </div>
                    <!-- =============================PL1 & PL2====================================== -->
                    <div id="pl1pl2-section" style="display: none;">
                        <div class="col-md-12 mb-3">
                            <h4 class="text-center align-middle">Perhitungan Kapasitas Produksi PL1 & PL2</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault01">OEE (Ubah Percentage ke Decimal Contoh 93% => 0.93)</label>
                                    <input type="text" class="form-control" name="oee_pl2" value="{{ $dataKp->oee_pl2 }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault01">Output / Hari</label>
                                    <input type="text" class="form-control" name="output_pl2" value="{{ $dataKp->output_pl2 }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault01">Shift Kerja</label>
                                    <input type="text" class="form-control" name="shift_kerja_pl2" value="{{ $dataKp->shift_kerja_pl2 }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault01">Jam Kerja</label>
                                    <input type="text" class="form-control" name="jam_kerja_pl2" value="{{ $dataKp->jam_kerja_pl2 }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault01">Aktual OEE</label>
                                    <input type="text" class="form-control" name="aktual_oee_pl2" value="{{ $dataKp->aktual_oee_pl2 }}" required>
                                </div>                
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <h4 class="text-center align-middle">Hasil Perhitungan</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="validationDefault01">Takt Time</label>
                                <input type="text" class="form-control" name="takt_time_pl2" id="takt_time_pl2" required disabled>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="validationDefault01">Available Work Time</label>
                                <input type="text" class="form-control" name="available_work_time_pl2" id="available_work_time_pl2" required disabled>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="validationDefault01">Kapasitas Produksi</label>
                                <input type="text" class="form-control" name="kap_produksi_pl2" id="kap_produksi_pl2" required disabled>
                            </div>
                        </div>
                    </div>
                    <!-- =============================PL3====================================== -->
                    <div id="pl3-section" style="display: none;">
                        <div class="col-md-12 mb-3">
                            <h4 class="text-center align-middle">Perhitungan Kapasitas Produksi PL3</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault01">OEE (Ubah Percentage ke Decimal Contoh 93% => 0.93)</label>
                                    <input type="text" class="form-control" name="oee_pl3" value="{{ $dataKp->oee_pl3 }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault01">Output / Hari</label>
                                    <input type="text" class="form-control" name="output_pl3" value="{{ $dataKp->output_pl3 }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault01">Shift Kerja</label>
                                    <input type="text" class="form-control" name="shift_kerja_pl3" value="{{ $dataKp->shift_kerja_pl3 }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault01">Jam Kerja</label>
                                    <input type="text" class="form-control" name="jam_kerja_pl3" value="{{ $dataKp->jam_kerja_pl3 }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault01">Aktual OEE</label>
                                    <input type="text" class="form-control" name="aktual_oee_pl3" value="{{ $dataKp->aktual_oee_pl3 }}" required>
                                </div>                
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <h4 class="text-center align-middle">Hasil Perhitungan</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="validationDefault01">Takt Time</label>
                                <input type="text" class="form-control" name="takt_time_pl3" id="takt_time_pl3" required disabled>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="validationDefault01">Available Work Time</label>
                                <input type="text" class="form-control" name="available_work_time_pl3" id="available_work_time_pl3" required disabled>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="validationDefault01">Kapasitas Produksi</label>
                                <input type="text" class="form-control" name="kap_produksi_pl3" id="kap_produksi_pl3" required disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col text-center">
                <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                <a href="{{ route ('kp-index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    document.getElementById('drytype-btn').addEventListener('click', function() {
        document.getElementById('drytype-section').style.display = 'block';
        document.getElementById('pl1pl2-section').style.display = 'none';
        document.getElementById('pl3-section').style.display = 'none';
    });

    document.getElementById('pl1pl2-btn').addEventListener('click', function() {
        document.getElementById('drytype-section').style.display = 'none';
        document.getElementById('pl1pl2-section').style.display = 'block';
        document.getElementById('pl3-section').style.display = 'none';
    });

    document.getElementById('pl3-btn').addEventListener('click', function() {
        document.getElementById('drytype-section').style.display = 'none';
        document.getElementById('pl1pl2-section').style.display = 'none';
        document.getElementById('pl3-section').style.display = 'block';
    });

    document.addEventListener('DOMContentLoaded', function() {
        var oeeInput = document.querySelector('input[name="oee_drytype"]');
        var outputInput = document.querySelector('input[name="output_drytype"]');
        var shiftInput = document.querySelector('input[name="shift_kerja_drytype"]');
        var jamInput = document.querySelector('input[name="jam_kerja_drytype"]');
        var aktualOeeInput = document.querySelector('input[name="aktual_oee_drytype"]');
        var taktTimeInput = document.getElementById('takt_time_drytype');
        var availableWorkTimeInput = document.getElementById('available_work_time_drytype');
        var kapProduksiInput = document.getElementById('kap_produksi_drytype');

        function calculate() {
            var oee = parseFloat(oeeInput.value);
            var output = parseFloat(outputInput.value);
            var shift = parseFloat(shiftInput.value);
            var jam = parseFloat(jamInput.value);
            var aktualOee = parseFloat(aktualOeeInput.value);

            var taktTime = jam / output;
            taktTimeInput.value = taktTime.toFixed(2); // Menyimpan hasil dengan dua desimal

            var availableWorkTime = (jam * shift) * oee;
            availableWorkTimeInput.value = availableWorkTime.toFixed(2);

            var kapProduksi = Math.ceil(availableWorkTime / taktTime);
            kapProduksiInput.value = kapProduksi;

            console.log('Nilai Kapasitas Produksi Dry Type: ', kapProduksi);
        }
        calculate();

        oeeInput.addEventListener('input', calculate);
        outputInput.addEventListener('input', calculate);
        shiftInput.addEventListener('input', calculate);
        jamInput.addEventListener('input', calculate);
        aktualOeeInput.addEventListener('input', calculate);

        // PERHITUNGAN UNTUK PL1 & PL2
        var oee_pl2 = document.querySelector('input[name="oee_pl2"]');
        var output_pl2 = document.querySelector('input[name="output_pl2"]');
        var shift_kerja_pl2 = document.querySelector('input[name="shift_kerja_pl2"]');
        var jam_kerja_pl2 = document.querySelector('input[name="jam_kerja_pl2"]');
        var aktual_oee_pl2 = document.querySelector('input[name="aktual_oee_pl2"]');
        var takt_time_pl2 = document.getElementById('takt_time_pl2');
        var available_work_time_pl2 = document.getElementById('available_work_time_pl2');
        var kap_produksi_pl2 = document.getElementById('kap_produksi_pl2');

        function calculatepl2() {
            var oee_pl12 = parseFloat(oee_pl2.value);
            var output_pl12 = parseFloat(output_pl2.value);
            var shift_pl12 = parseFloat(shift_kerja_pl2.value);
            var jam_pl12 = parseFloat(jam_kerja_pl2.value);
            var aktualOee_pl12 = parseFloat(aktual_oee_pl2.value);

            // Menghitung Takt Time
            var taktTimePl2 = jam_pl12 / output_pl12;
            takt_time_pl2.value = taktTimePl2.toFixed(2);

            // Menghitung Available Work Time
            var availableWorkTimePl2 = (jam_pl12 * shift_pl12) * oee_pl12;
            available_work_time_pl2.value = availableWorkTimePl2.toFixed(2);

            // Menghitung Kapasitas Produksi
            var kapProduksiPl2 = Math.ceil(availableWorkTimePl2 / taktTimePl2);
            kap_produksi_pl2.value = kapProduksiPl2;
        }

        calculatepl2();

        oee_pl2.addEventListener('input', calculatepl2);
        output_pl2.addEventListener('input', calculatepl2);
        shift_kerja_pl2.addEventListener('input', calculatepl2);
        jam_kerja_pl2.addEventListener('input', calculatepl2);
        aktual_oee_pl2.addEventListener('input', calculatepl2);


        // PERHITUNGAN UNTUK PL3
        var oee_pl3 = document.querySelector('input[name="oee_pl3"]');
        var output_pl3 = document.querySelector('input[name="output_pl3"]');
        var shift_kerja_pl3 = document.querySelector('input[name="shift_kerja_pl3"]');
        var jam_kerja_pl3 = document.querySelector('input[name="jam_kerja_pl3"]');
        var aktual_oee_pl3 = document.querySelector('input[name="aktual_oee_pl3"]');
        var takt_time_pl3 = document.getElementById('takt_time_pl3');
        var available_work_time_pl3 = document.getElementById('available_work_time_pl3');
        var kap_produksi_pl3 = document.getElementById('kap_produksi_pl3');

        function calculatepl3() {
            var oee_pl13 = parseFloat(oee_pl3.value);
            var output_pl13 = parseFloat(output_pl3.value);
            var shift_pl13 = parseFloat(shift_kerja_pl3.value);
            var jam_pl13 = parseFloat(jam_kerja_pl3.value);
            var aktualOee_pl13 = parseFloat(aktual_oee_pl3.value);

            // Menghitung Takt Time
            var taktTimePl3 = jam_pl13 / output_pl13;
            takt_time_pl3.value = taktTimePl3.toFixed(2);

            // Menghitung Available Work Time
            var availableWorkTimePl3 = (jam_pl13 * shift_pl13) * oee_pl13;
            available_work_time_pl3.value = availableWorkTimePl3.toFixed(2);

            // Menghitung Kapasitas Produksi
            var kapProduksiPl3 = Math.ceil(availableWorkTimePl3 / taktTimePl3);
            kap_produksi_pl3.value = kapProduksiPl3;
        }
        
        calculatepl3()

        oee_pl3.addEventListener('input', calculatepl3);
        output_pl3.addEventListener('input', calculatepl3);
        shift_kerja_pl3.addEventListener('input', calculatepl3);
        jam_kerja_pl3.addEventListener('input', calculatepl3);
        aktual_oee_pl3.addEventListener('input', calculatepl3);
    });

</script>

@endsection
