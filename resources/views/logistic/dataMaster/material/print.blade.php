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

            {{-- table cetak --}}
            {{-- button print --}}
            <div class="btn-print px-3 mb-3">
                <button class="btn-btn-sm btn-gray" id="print">Cetak</button>
            </div>
            {{-- button print end --}}
            <div class="table-responsive px-3">
                <table class="table table-bordered table-hover">
                    <thead class="table-secondary">
                        <tr class="text-center">
                            <th>Barcode</th>
                        </tr>
                    </thead>

                    <tbody>
                        <td> {!! DNS1D::getBarcodeSVG($material->kd_material, 'C39') !!}</td>
                    </tbody>
                </table>
            </div>
            {{-- table cetak end --}}
        </div>
    </div>
@endsection
