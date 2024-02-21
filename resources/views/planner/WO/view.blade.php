<!DOCTYPE html>
<html>
<head>
	<title>PDF Work Order</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<div>
		<center>	
			<img src="https://images.glints.com/unsafe/glints-dashboard.s3.amazonaws.com/company-banner-pic/7b746a35872418f5a9911c749a89bb0f.jpg" width="150px">
		</center>
	</div>
	<br>
	<center>
        <h5>Work Order @if($dataWo->isNotEmpty()) {{ $dataWo->first()->id_wo }} @endif</h5>
	</center>

	<table class='table table-bordered'>
    <thead>
            <tr>
                <th>No</th>
                <th>Kode BOM</th>
                <th>Kode WO</th>
                <th>Kode Man Hour</th>
                <th>Kode SO</th>
                <th>Quantity Trafo</th>
                <th>KVA</th>
                <th>Keterangan</th>
                <th>Start Date</th>
                <th>Finish Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataWo as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->id_boms }}</td>
                    <td>{{ $item->id_wo }}</td>
                    <td>{{ $item->standardize_work->kd_manhour }}</td>
                    <td>{{ $item->id_so }}</td>
                    <td>{{ $item->qty_trafo }}</td>
                    <td>{{ $item->kva }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->start_date }}</td>
                    <td>{{ $item->finish_date }}</td>
                </tr>
            @endforeach
        </tbody>
	</table>

</body>
</html>