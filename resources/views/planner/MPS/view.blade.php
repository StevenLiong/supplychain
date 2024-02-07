<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Production Schedule PDF</title>
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
    </style>
</head>
<body>
    <div style="margin-bottom: 20px;">
        <img src="{{ public_path('assets/LogoTrafoindo.png') }}" width="120" height="50" alt="LOGO">
    </div>
    <h2>Master Production Schedule</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Work Order Code</th>
                <th>Project Name</th>
                <th>Production Line</th>
                <th>KVA</th>
                <th>Jenis Trafo</th>
                <th>Quantity</th>
                <th>Deadline</th>
                <!-- Add other headers as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($dataMps as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->wo->id_wo }}</td>
                    <td>{{ $item->project }}</td>
                    <td>{{ $item->production_line }}</td>
                    <td>{{ $item->kva }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->qty_trafo }}</td>
                    <td>{{ $item->deadline }}</td>
                    <!-- Add other columns as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
