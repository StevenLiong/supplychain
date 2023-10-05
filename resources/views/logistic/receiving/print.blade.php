@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">CETAK QR CODE DAN BARCODE</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- table dry type --}}
            <div class="btn-create px-3 mb-3">
                <button type="button" class="btn btn-sm btn-gray"
                    onclick=window.location="{{ route('print') }}">Print</button>
            </div>
            <div class="table-responsive px-3">
                <table class="table table-bordered table-hover">
                    <thead class="table-secondary">
                        <tr class="text-center">
                            <th>QR Code</th>
                            <th>Barcode</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Gambar QR</td>
                            <td>Gambar Barcode</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- table dry type end --}}
        </div>
    </div>
@endsection
