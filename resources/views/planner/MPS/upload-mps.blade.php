@extends('planner.template.bar')
@section('content')
@section('mps', 'active')
@section('main', 'show')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Input MPS</h4>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('mps.store') }}" method="post">
            @csrf
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Work Order</label>
                    <select id="id_wo" name="id_wo" class="form-control" required>
                        <option value="">Choose...</option>
                        @foreach($dataWo as $woId)
                            <option value="{{ $woId->id }}">{{ $woId->id_wo }}</option>
                            
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Project Name</label>
                    <input type="text" class="form-control" name="project" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Production Line</label>
                    <select name="production_line" id="production_line" class="form-control">
                        <option>Choose...</option>
                        <option value="PL2">PL2</option>
                        <option value="PL3">PL3</option>
                        <option value="Dry Type">Dry Type</option>
                        <option value="CTVT">CTVT</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">KVA</label>
                    <input type="text" class="form-control" name="kva" required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Jenis Trafo</label>
                    <select name="jenis" id="jenis" class="form-control">
                        <option>Choose...</option>
                        <option value="Oil Trafo">Oil Trafo</option>
                        <option value="Dry Type">Dry Type</option>
                        <option value="CTVT">CTVT</option>
                    </select>
                    {{-- <input type="text" class="form-control" name="jenis" required> --}}
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Quantity</label>
                    <input type="text" class="form-control" name="qty_trafo" required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Deadline</label>
                    <input type="date" class="form-control datepicker" name="deadline" required>
                </div>
            </div>
            <div class="col text-center">
                <button type="submit" class="btn btn-md btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function getDataByIdWo(idWo) {
        $.ajax({
            url: '/getdataid-wo/' + idWo,
            method: 'GET',
            success: function (data) {
                // Isi nilai-nilai formulir berdasarkan data yang diterima dari server
                $('input[name="qty_trafo"]').val(data.qty_trafo);
                $('input[name="kva"]').val(data.kva);
            },
            error: function (xhr, status, error) {
                // Handle error jika diperlukan
                console.log('Error fetching data:', status, error);
                console.log(xhr.responseText); // Log the response for further inspection
            }
        });
    }

    // Event listener untuk perubahan nilai pada input id_fg
    $(document).ready(function () {
        $('#id_wo').on('change', function () {
            var idWo = $(this).val();
            getDataByIdWo(idWo);
        });
    });
</script>
@endsection