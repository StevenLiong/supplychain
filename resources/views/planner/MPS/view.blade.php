<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Production Schedule PDF</title>
</head>
<body>
    <h2>Master Production Schedule</h2>

    <table border="1" cellspacing="0" cellpadding="5">
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