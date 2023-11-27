<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Global Picking Area - Dry Type PDF</title>
</head>
<body>
    <h2>Detail Global Picking Area - Dry Type ({{ $dataMps->first()->id_wo }})</h2>
    <form>
        <div class="form-row">
            <div class="col-md-4 mb-2">
                <label for="id_wo">Work Order</label>
                <input type="text" class="form-control" name="id_wo" value="{{ $dataMps->first()->id_wo }}"required disabled>
            </div>
            <div class="col-md-4 mb-2">
                <label for="production_line">Production Line</label>
                <input type="text" class="form-control" name="production_line" value="{{ $dataMps->first()->production_line }}"required disabled>
            </div>
            <div class="col-md-4 mb-2">
                <label for="kva">KVA</label>
                <input type="text" class="form-control" name="kva" value="{{ $dataMps->first()->kva }}"required disabled>
            </div>
            <div class="col-md-4 mb-2">
                <label for="qty_trafo">Quantity</label>
                <input type="text" class="form-control" name="qty_trafo" value="{{ $dataMps->first()->qty_trafo }}"required disabled>
            </div>
            <div class="col-md-4 mb-2">
                <label for="lead_time">Lead Time</label>
                <input type="text" class="form-control" name="lead_time" value="{{ $dataMps->first()->lead_time }}"required disabled>
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
            <tr>
                <td>Bill of Material</td>
                <td>{{ \Carbon\Carbon::parse($dataMps->first()->deadline)->subDays(2)->format('d-F-Y') }}</td>
            </tr>
            <tr>
                <td>Insulation Paper</td>
                <td>DD-MMMM-YYYY</td>
            </tr>
            <tr>
                <td>Supply Material Insulation & Coil</td>
                <td>DD-MMMM-YYYY</td>
            </tr>
            <tr>
                <td>Core</td>
                <td>DD-MMMM-YYYY</td>
            </tr>
            <tr>
                <td>Winding</td>
                <td>DD-MMMM-YYYY</td>
            </tr>
            <tr>
                <td>Core & Winding</td>
                <td>DD-MMMM-YYYY</td>
            </tr>
            <tr>
                <td>Assembly</td>
                <td>DD-MMMM-YYYY</td>
            </tr>
            <tr>
                <td>Insulation</td>
                <td>DD-MMMM-YYYY</td>
            </tr>
            <tr>
                <td>Inspection</td>
                <td>DD-MMMM-YYYY</td>
            </tr>
            <tr>
                <td>Painting</td>
                <td>DD-MMMM-YYYY</td>
            </tr>
            <tr>
                <td>Finishing</td>
                <td>DD-MMMM-YYYY</td>
            </tr>
            <tr>
                <td>Final Inspection</td>
                <td>DD-MMMM-YYYY</td>
            </tr>
            <tr>
                <td>Packing</td>
                <td>DD-MMMM-YYYY</td>
            </tr>
            <tr>
                <td>Delivery</td>
                <td>DD-MMMM-YYYY</td>
            </tr>
        </tbody>
    </table>
</body>
</html>