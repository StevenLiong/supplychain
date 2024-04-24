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
                <<th style="width: 1rem;text-align: center;">No</th>
                <th style="width: 6rem; text-align: center">Work Order Code</th>
                <th style="width: 6rem; text-align:center">Start Date</th>
                <th style="width: 6rem; text-align:center">Dead Line</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deadlines as $index => $deadline)
                <tr role="row" class="odd">
                    <td style="width: 1rem;text-align: center;" class="sorting_1">{{ $index + 1 }}</td>
                    <td style="width: 6rem; text-align: center">{{ $deadline['id_wo'] }}</td>
                    {{-- <td style="width: 6rem; text-align: center">{{ $dataWorkcenter->project }}</td>
                    <td style="width: 6rem; text-align: center">{{ $dataWorkcenter->production_line }}</td>
                    <td style="width: 6rem; text-align: center">{{ $dataWorkcenter->kva }}</td>
                    <td style="width: 6rem; text-align: center">{{ $dataWorkcenter->qty_trafo }}</td>
                    <td style="width: 6rem; text-align: center">{{ \Carbon\Carbon::parse($dataWorkcenter->start)->format('d-F-Y') }}</td> --}}
                    <td style="width: 6rem; text-align: center">{{ $deadline['startWc'] }}</td>
                    <td style="width: 6rem; text-align: center">{{ $deadline['deadlineWc'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
