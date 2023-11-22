@extends('produksi.resource_work_planning.template.bar')
@section('content')
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h5>Kolom Input</h5>
            </div>
            <div class="card-body">
                <p style="font-size: smaller;line-height: 1.5;">Gunakan tanda "." sebagai pengganti koma ",". Dan kolom input
                    hanya menerima input berupa angka.</p>
                <form id="calculatorForm">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" for="qty">QTY</span>
                        </div>
                        <input type="text" id="qty" class="form-control" placeholder="QTY">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" for="rate">Rate Work </span>
                        </div>
                        <input type="text" id="rate" class="form-control" placeholder="Rate Work">
                    </div>

                    <button type="button" class="btn btn-primary" onclick="calculateManpower()">Hitung</button>

                </form>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h5>Hasil Perhitungan</h5>
            </div>
            <div class="card-body">
                <div class="card card-list text-white m-0 p-0 mb-2" style="background-color: #d02424; ">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-users px-3" style="font-size: larger"></i>
                            <div class="pl-3 border-left">
                                <p class="mb-1 ">Man Power</p>
                                <h5 class="mb-0 text-white" id="result-mp" style="font-weight:bold">00.00</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-list  text-white" style="background-color: #d02424; ">
                    <div class="card-body">
                        <div class="d-flex align-items-center ">
                            <i class="fa-solid fa-clock px-3" style="font-size: larger"></i>
                            <div class="pl-3 border-left">
                                <p class="mb-1 ">Man Hour</p>
                                <h5 class="mb-0 text-white" id="result-mh" style="font-weight:bold">00.00</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function appendToDisplay(value) {
            document.getElementById('display').value += value;
        }

        function clearDisplay() {
            document.getElementById('display').value = '';
        }

        function calculateResult() {
            var displayValue = document.getElementById('display').value;
            var result = eval(displayValue); // eval() dapat mengeksekusi operasi matematika dari string
            document.getElementById('display').value = result;
        }

        function calculateManpower() {
            var qty = document.getElementById('qty').value;
            var rate = document.getElementById('rate').value;

            // Melakukan perhitungan
            var manpower = (qty * rate) / (173 * 0.93);
            var manhour = manpower * 173 * 0.93;

            // Menampilkan hasil perhitungan
            document.getElementById('result-mp').innerHTML = manpower.toFixed(2);
            document.getElementById('result-mh').innerHTML = manhour.toFixed(2);
        }
    </script>
@endsection
