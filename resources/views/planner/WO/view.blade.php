<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Order PDF</title>
</head>
<body>
    <h2>Work Order</h2>

    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                'ID',
            'Kode BOM',
            'Kode WO',
            'Kode Man Hour',
            'Quantity Trafo',
            'Kode SO',
            'Start Date',
            'Finish Date',
                <th>No</th>
                <th>Kode BOM</th>
                <th>Kode WO</th>
                <th>Kode Man Hour</th>
                <th>Quantity Trafo</th>
                <th>Kode SO</th>
                <th>Start Date</th>
                <th>Finish Date</th>
                <!-- Add other headers as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($dataWo as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->id_boms }}</td>
                    <td>{{ $item->id_wo }}</td>
                    <td>{{ $item->id_manhour }}</td>
                    <td>{{ $item->qty_trafo }}</td>
                    <td>{{ $item->id_so }}</td>
                    <td>{{ $item->start_date }}</td>
                    <td>{{ $item->finish_date }}</td>
                    <!-- Add other columns as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>