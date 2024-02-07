<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export PDF</title>
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
    <h1>Detail Work Center</h1>
    <form>
        <div class="form-row">
            <div class="col-md-4 mb-2">
                <label for="id_wo">Workcenter</label>
                <input type="text" class="form-control" name="id_wo" value="{{ $dataWorkcenter->nama_workcenter }}"required disabled>
            </div>
        </div>
    </form>
    
    <table border="1">
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th style="text-align: center">Work Order</th>
                <th style="text-align: center">Project</th>
                <th style="text-align: center">Production Line</th>
                <th style="text-align: center">KVA</th>
                <th style="text-align: center">Quantity</th>
                <th style="text-align: center">Deadline</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataGpa as $index => $gpa)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}</td>
                    <td style="text-align: center">{{ $gpa->wo->id_wo }}</td>
                    <td style="width: 10rem; text-align:center">{{ $gpa->project }}</td>
                    <td style="text-align: center">{{ $gpa->production_line }}</td>
                    <td style="text-align: center">{{ $gpa->kva }}</td>
                    <td style="text-align: center">{{ $gpa->qty_trafo }}</td>
                    <td style="width: 9rem; text-align:center">{{ \Carbon\Carbon::parse($gpa->deadline)->format('d-F-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
