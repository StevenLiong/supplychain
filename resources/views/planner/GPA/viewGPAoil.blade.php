<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Picking Area - Oil Trafo PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h2>Global Picking Area - Oil Trafo</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th style="width: 8rem">Work Order Code</th>
                <th style="width: 7.5rem">Production Line</th>
                <th>KVA</th>
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
                    <td>{{ $item->production_line }}</td>
                    <td>{{ $item->kva }}</td>
                    <td>{{ $item->qty_trafo }}</td>
                    <td style="width: 9rem">{{ \Carbon\Carbon::parse($item->deadline)->format('d-F-Y') }}</td>
                    <!-- Add other columns as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
