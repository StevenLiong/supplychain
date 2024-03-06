@extends('planner.template.layout')
@section('style')
<style>
    .content-page{
        margin: 0;
        padding: 0;
    }
    .table-wrapper {
        overflow-x: scroll;
        overflow-y: scroll;
        display: flex;
        height: fit-content;
    }
    .freeze-column {
        position: sticky;
        left: 0;
        z-index: 0;
        background-color: white; /* jika perlu */
    }
    .jan-input {
        font-size: 12px; /* Sesuaikan dengan ukuran yang Anda inginkan */
        padding: 5px; /* Sesuaikan dengan ukuran yang Anda inginkan */
        width: 20px; /* Sesuaikan dengan lebar yang Anda inginkan */
    }
    .freeze-row{
        position: sticky;
        top : 0px;
        background-color: white;
        z-index: 2;
    }
</style>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between breadcrumb-content">
            <div class="col d-flex align-items-center">
                <a href="{{ route('bom-index') }}" class="btn btn-primary mr-2"><i aria-hidden="true"></i>Bill of Material</a>
                <h5 class="mb-0">Master Production Schedule</h5>
            </div>            
        </div>
        <br>
        <form id="mpsForm" action="{{ route('mps2.store') }}" method="POST">
            @csrf
            <div class="col text-left">
                <button type="submit" class="btn btn-md btn-primary" name="s1_planning">S1 Planning: Ex-work (SO due date)</button>
            </div>
            <div id="tabelmps" class="table-wrapper">
                <table class="table table-bordered mt-3">
                    <div class="fixed-header">
                        <tr>
                            <th colspan="37" style="text-align: center;">Kapasitas</th>
                        </tr>
                        <tr>
                            <td colspan="6" style="min-width: 145px; text-align: center;" class="freeze-column">PL 2</td>
                            @foreach ($kapasitasPL2 as $tanggal => $capacityPL2)
                                <td style="min-width: 57px; text-align: center;">{{ $capacityPL2 }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="6" style="min-width: 145px; text-align:center;" class="freeze-column">PL 3</td>
                            @foreach ($kapasitasPL3 as $tanggal => $capacityPL3)
                                <td style="min-width: 57px; text-align: center;">{{ $capacityPL3 }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="6" style="min-width: 145px; text-align:center;" class="freeze-column">DRYTYPE</td>
                            @foreach ($kapasitasDrytype as $tanggal => $capacityDrytype)
                                <td style="min-width: 57px; text-align: center;">{{ $capacityDrytype }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th rowspan="2" class="freeze-column" style="text-align: center; white-space: nowrap; width: 200px; padding: 10px; vertical-align: middle;">Work Order Code</th>
                            <th rowspan="2" class="" style="text-align: center; white-space: nowrap; width: 200px; padding: 10px; vertical-align: middle;">Line</th>
                            <th rowspan="2" class="" style="text-align: center; white-space: nowrap; width: 200px; padding: 10px; vertical-align: middle;">Project Name</th>
                            <th rowspan="2" class="" style="text-align: center; white-space: nowrap; width: 200px; padding: 10px; vertical-align: middle;">Due Date</th>
                            <th rowspan="2" class="" style="text-align: center; white-space: nowrap; width: 200px; padding: 10px; vertical-align: middle;">KVA</th>
                            <th rowspan="2" class="" style="text-align: center; white-space: nowrap; width: 200px; padding: 10px; vertical-align: middle;">Qty</th>
                            <th colspan="31" style="text-align: center">Maret</th>
                        </tr>
                        <tr>
                            @foreach ($tanggalHeaders as $tanggal)
                                <th style="text-align: center">{{ \Carbon\Carbon::parse($tanggal)->format('d') }}</th>
                            @endforeach
                        </tr>
                    </div>
                    <tbody>
                        @foreach ($mps2s as $mps2)
                            <tr>
                                <td class="freeze-column" style="min-width: 150x; padding: 10px;"><input type="text" class="form-control" name="id_wo" value="{{ $mps2->id_wo }}"></td>
                                <td class="" style="width: 200px; padding: 10px;"><input type="text" class="form-control" name="line" value="{{ $mps2->line }}"></td>
                                <td class="" style="width: 200px; padding: 10px;"><input type="text" class="form-control" name="project" value="{{ $mps2->project }}"></td>
                                <td class="" style="width: 200px; padding: 10px;">
                                    <input type="text" class="form-control" name="deadline" value="{{ \Carbon\Carbon::parse($mps2->deadline['day'] . '-' . $mps2->deadline['month'] . '-' . $mps2->deadline['year'])->format('j-M-Y') }}">
                                </td>                                
                                <td class="" style="width: 200px; padding: 10px;"><input type="text" class="form-control" name="kva" value="{{ $mps2->kva }}"></td>
                                <td class="" style="width: 200px; padding: 10px;"><input type="text" class="form-control" name="qty_trafo" value="{{ $mps2->qty_trafo }}"></td>
                                {{-- <td><input type="text" class="form-control jan-input" name="jan_input" value="{{ $mps2->qty_trafo }}"></td> --}}
                                @for ($i = 1; $i <= 31; $i++)
                                    {{-- @dd($mps2->deadline['day'] == $i) --}}
                                    @if ($mps2->deadline['day'] === $i)
                                        <td><input type="text" class="form-control jan-input" name="jan_{{ $i }}" value="{{ $mps2->qty_trafo }}" disabled></td>
                                    @else
                                    <td><input type="text" class="form-control jan-input" name="jan_{{ $i }}" value="" disabled></td>
                                    @endif
                                @endfor
                            </tr>
                        @endforeach
                        <tr>
                            <td class="freeze-column" style="min-width: 150px; padding: 10px;">
                                <input type="text" class="form-control" name="id_wo" value="">
                            </td>
                            <td class="" style="min-width: 75px; padding: 10px;">
                                <input type="text" class="form-control" name="line" value="">
                            </td>
                            <td class="" style="min-width: 200px; padding: 10px;">
                                <input type="text" class="form-control" name="project" value="">
                            </td>
                            <td class="" style="min-width: 150px; padding: 10px;">
                                <input type="text" class="form-control" name="deadline" id="deadline_input" value="">
                            </td>
                            <td class="" style="min-width: 100px; padding: 10px;">
                                <input type="text" class="form-control" name="kva" value="">
                            </td>
                            <td class="" style="min-width: 78px; padding: 10px;">
                                <input type="text" class="form-control" name="qty_trafo" value="">
                            </td>
                            @for ($i = 1; $i <= 31; $i++)
                                <td><input type="text" class="form-control jan-input" name="jan_{{ $i }}" disabled></td>
                            @endfor
                        </tr>
                    </tbody>
                </table>   
            </div>
        </form>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('.table-wrapper').scroll(function() {
            var $th = $('.freeze-column');
            var scrollLeft = $('.table-wrapper').scrollLeft();
            $th.css('left', scrollLeft);
        });
    });
</script>
