@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">QR CODE DAN BARCODE</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- button print --}}
            <div class="btn-print px-3 mb-3">
                <button class="btn-btn-sm btn-gray" id="print">Cetak</button>
            </div>
            {{-- button print end --}}

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
                            <?php 
                            $item = $incoming->material->kd_material;    
                            ?>
                            <td>
                                {!!  DNS1D::getBarcodeSVG($item, 'C39') !!}
                                {{-- <img src="data:image/png;base64,'{{DNS1D::getBarcodePNG($item, 'C39+')   }}" alt="barcode">  --}}
                            </td>
                            {{-- <td>{{ $incoming->material->kd_material }}</td> --}}
                            <td>{{ $incoming->no_surat_jalan }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- table dry type end --}}
        </div>
    </div>
    <script>
        document.getElementById('print').addEventListener('click', function() {
            window.print(); // Memulai proses pencetakan
        });
    </script>
    
@endsection
