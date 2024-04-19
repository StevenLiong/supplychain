@extends('planner.template.bar')
@section('content')
@section('gpadry', 'active')
@section('main', 'show')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Detail GPA Trafo Dry Type</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex mb-4">
                <div class="col  text-left">
                    <a href="{{ route('gpa.exportPdfDetail', $dataMps->id_wo) }}" class="btn btn-primary"><i class="mr-2 fa-regular fa-file-pdf"></i>Download PDF</a>
                </div>
            </div>
            <form>
                <div class="form-row">
                    <div class="col-md-4 mb-2">
                        <label for="id_wo">Work Order</label>
                        <input type="text" class="form-control" name="id_wo" value="{{ $dataMps->id_wo }}"required disabled>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" value="{{ $keterangan }}"required disabled>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="production_line">Production Line</label>
                        <input type="text" class="form-control" name="production_line" value="{{ $dataMps->production_line }}"required disabled>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="kva">KVA</label>
                        <input type="text" class="form-control" name="kva" value="{{ $dataMps->kva }}"required disabled>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="qty_trafo">Quantity</label>
                        <input type="text" class="form-control" name="qty_trafo" value="{{ $dataMps->qty_trafo }}"required disabled>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="validationDefault07">Deadline</label>
                        <input type="text" class="form-control" name="deadline" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $dataMps->deadline['year'] . '-' . $dataMps->deadline['month'] . '-' . $dataMps->deadline['day'])->format('d-M-Y') }}"required disabled>
                    </div>
                </div>    
            </form>
            <div class="table-responsive" style="margin-top: 1rem">
                <div id="datatable_wrapper" class="dataTables_wrapper">
                    <table id="datatable" class="table table-striped dataTable">
                        <thead>
                            <tr class=" justify-content-center" role="row">
                                <th style="width: 15rem;text-align: center;">Work Center</th>
                                <th style="width: 15rem;text-align:center">Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataGpa as $detailGpa)
                                <tr role="row" class="odd">
                                    <td style="text-align: center;" class="sorting_1">Bill of Material</td>
                                    <td style="text-align: center;" class="sorting_1">{{$detailGpa->deadline_wc1}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td style="text-align: center;" class="sorting_1">Insulation Paper</td>
                                    <td style="text-align: center;" class="sorting_1">{{$detailGpa->deadline_wc2}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td style="text-align: center;" class="sorting_1">Supply Material Insulation & Coil</td>
                                    <td style="text-align: center;" class="sorting_1">{{$detailGpa->deadline_wc3}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td style="text-align: center;" class="sorting_1">Supply Material Moulding</td>
                                    <td style="text-align: center;" class="sorting_1">{{$detailGpa->deadline_wc4}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td style="text-align: center;" class="sorting_1">LV Windling</td>
                                    <td style="text-align: center;" class="sorting_1">{{$detailGpa->deadline_wc5}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td style="text-align: center;" class="sorting_1">HV Windling</td>
                                    <td style="text-align: center;" class="sorting_1">{{$detailGpa->deadline_wc6}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td style="text-align: center;" class="sorting_1">Core</td>
                                    <td style="text-align: center;" class="sorting_1">{{$detailGpa->deadline_wc7}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td style="text-align: center;" class="sorting_1">Supply Fixing Parts & Core</td>
                                    <td style="text-align: center;" class="sorting_1">{{$detailGpa->deadline_wc8}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td style="text-align: center;" class="sorting_1">Moulding</td>
                                    <td style="text-align: center;" class="sorting_1">{{$detailGpa->deadline_wc9}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td style="text-align: center;" class="sorting_1">Susun Core</td>
                                    <td style="text-align: center;" class="sorting_1">{{$detailGpa->deadline_wc10}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td style="text-align: center;" class="sorting_1">Supply Material Connection & Final Assembly</td>
                                    <td style="text-align: center;" class="sorting_1">{{$detailGpa->deadline_wc11}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td style="text-align: center;" class="sorting_1">Connection & Final Assembly</td>
                                    <td style="text-align: center;" class="sorting_1">{{$detailGpa->deadline_wc12}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td style="text-align: center;" class="sorting_1">Finishing</td>
                                    <td style="text-align: center;" class="sorting_1">{{$detailGpa->deadline_wc13}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td style="text-align: center;" class="sorting_1">Quality Control</td>
                                    <td style="text-align: center;" class="sorting_1">{{$detailGpa->deadline_wc14}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td style="text-align: center;" class="sorting_1">Quality Control Transfer Gudang</td>
                                    <td style="text-align: center;" class="sorting_1">{{$detailGpa->deadline_wc15}}</td>
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