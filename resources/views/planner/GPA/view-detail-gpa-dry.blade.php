<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Global Picking Area - Dry Type PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
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
    <h2>Detail Global Picking Area - Dry Type ({{ $dataGpa->first()->wo->id_wo }})</h2>
    <form>
        <div class="form-row">
            <div class="col-md-4 mb-2">
                <label for="id_wo">Work Order</label>
                <input type="text" class="form-control" name="id_wo" value="{{ $dataGpa->first()->wo->id_wo }}"required disabled>
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
                <input type="text" class="form-control" name="deadline" value="{{ \Carbon\Carbon::parse($dataMps->first()->deadline)->format('d-F-Y') }}"required disabled>
            </div>
        </div>
    </form>
    <table>
        <thead>
            <tr>
                <th>Work Center</th>
                <th>Dead Line</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataGpa as $item)
                <tr>
                    <td>{{ $item->nama_workcenter }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->deadline)->format('d-F-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>