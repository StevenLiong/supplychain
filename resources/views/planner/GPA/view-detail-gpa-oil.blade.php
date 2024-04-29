<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Global Picking Area - Oil Trafo PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* margin: 20px;
            padding: 20px; */
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-row {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
        }
        .form-row .col-md-4 {
            flex: 0 0 calc(50% - 10px); /* Two columns with a little gap */
            margin-bottom: 20px;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border-radius: 8px; /* Rounded corners */
            border: 1px solid #ccc; /* Adding border */
        }
        label {
            margin-bottom: 5px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="p-2">
        <img src="{{ public_path('assets/LogoTrafoindo.png') }}" width="120" height="50" class="d-inline-block"
            alt="LOGO">
    </div>
    <h2>Detail Global Picking Area - Oil Trafo ({{ $dataGpa->first()->id_wo }})</h2>
    <form>
        <div class="form-row">
            <div class="col-md-4 mb-2">
                <label for="id_wo">Work Order</label>
                <input type="text" class="form-control" name="id_wo" value="{{ $dataGpa->first()->id_wo }}"required disabled>
            </div>
            <div class="col-md-4 mb-2">
                <label for="keterangan">Keterangan</label>
                <input type="text" class="form-control" name="keterangan" value="{{ $dataGpa->first()->keterangan }}"required disabled>
            </div>
            <div class="col-md-4 mb-2">
                <label for="production_line">Production Line</label>
                <input type="text" class="form-control" name="production_line" value="{{ $dataGpa->first()->production_line }}"required disabled>
            </div>
            <div class="col-md-4 mb-2">
                <label for="kva">KVA</label>
                <input type="text" class="form-control" name="kva" value="{{ $dataGpa->first()->kva }}"required disabled>
            </div>
            <div class="col-md-4 mb-2">
                <label for="qty_trafo">Quantity</label>
                <input type="text" class="form-control" name="qty_trafo" value="{{ $dataGpa->first()->qty_trafo }}"required disabled>
            </div>
            <div class="col-md-4 mb-2">
                <label for="validationDefault07">Dead Line</label>
                <input type="text" class="form-control" name="deadline" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $dataMps->first()->deadline['year'] . '-' . $dataMps->first()->deadline['month'] . '-' . $dataMps->first()->deadline['day'])->format('d-M-Y') }}"required disabled>
            </div>
        </div>
    </form>
    <table>
        <thead>
            <tr>
                <th>Work Center</th>
                <th>Start Date</th>
                <th>Deadline</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataGpa as $detailGpa)
            <tr role="row" class="odd">
                <td class="sorting_1">Bill of Material</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->start_wc1)->format('j-M-Y') }}</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->deadline_wc1)->format('j-M-Y') }}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1">Insulation Paper</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->start_wc2)->format('j-M-Y') }}</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->deadline_wc2)->format('j-M-Y') }}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1">Supply Material Insulation & Coil</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->start_wc3)->format('j-M-Y') }}</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->deadline_wc3)->format('j-M-Y') }}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1">Supply Material Moulding</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->start_wc4)->format('j-M-Y') }}</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->deadline_wc4)->format('j-M-Y') }}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1">LV Windling</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->start_wc5)->format('j-M-Y') }}</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->deadline_wc5)->format('j-M-Y') }}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1">HV Windling</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->start_wc6)->format('j-M-Y') }}</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->deadline_wc6)->format('j-M-Y') }}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1">Core</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->start_wc7)->format('j-M-Y') }}</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->deadline_wc7)->format('j-M-Y') }}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1">Supply Fixing Parts & Core</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->start_wc8)->format('j-M-Y') }}</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->deadline_wc8)->format('j-M-Y') }}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1">Moulding</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->start_wc9)->format('j-M-Y') }}</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->deadline_wc9)->format('j-M-Y') }}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1">Susun Core</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->start_wc10)->format('j-M-Y') }}</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->deadline_wc10)->format('j-M-Y') }}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1">Supply Material Connection & Final Assembly</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->start_wc11)->format('j-M-Y') }}</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->deadline_wc11)->format('j-M-Y') }}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1">Connection & Final Assembly</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->start_wc12)->format('j-M-Y') }}</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->deadline_wc12)->format('j-M-Y') }}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1">Finishing</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->start_wc13)->format('j-M-Y') }}</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->deadline_wc13)->format('j-M-Y') }}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1">Quality Control</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->start_wc14)->format('j-M-Y') }}</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->deadline_wc14)->format('j-M-Y') }}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1">Quality Control Transfer Gudang</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->start_wc15)->format('j-M-Y') }}</td>
                <td class="sorting_1">{{ \Carbon\Carbon::parse($detailGpa->deadline_wc15)->format('j-M-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>