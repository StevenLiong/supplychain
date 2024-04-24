@extends('planner.template.bar')
@section('content')
@section('workcenterdrytype', 'active')
@section('main', 'show')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">
                    Work Center - Dry Type
                </h4>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="datatable_wrapper" class="dataTables_wrapper">
                    <table id="datatable" class="table data-table table-striped dataTable" role="grid" aria-describedby="datatable_info">
                        <thead>
                            <tr class=" justify-content-center" role="row">
                                <tr class="ligth sorting_asc" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                                    <th style="width: 1rem;text-align: center;">No</th>
                                    <th style="width: 6rem; text-align: center">Work Center</th>
                                </tr>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <td style="width: 6rem; text-align: center"><a href="{{ route('wc-detailworkcenterdry') }}">Bill Of Material</a></td> --}}
                            @foreach ($dataWorkcenter as $index => $item)
                                <tr role="row" class="odd">
                                    <td style="width: 1rem;text-align: center;" class="sorting_1">{{ $index + 1 }}</td>
                                    <td style="width: 6rem; text-align: center"><a href="{{ route('wc-detailworkcenterdry', $item->nama_workcenter) }}">{{ $item->nama_workcenter }}</a></td>
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