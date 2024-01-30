<!DOCTYPE html>
<html>
<head>
	<title>PDF Bill of Material</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
        <h5>Bill of Material @if($dataBom->isNotEmpty()) {{ $dataBom->first()->id_boms }} @endif</h5>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th> 
				<th>Bom Code</th>
				<th>Nama Workcenter</th>
				<th>Kode Material</th>
				<th>Nama Material</th>
				<th>UOM</th>
                <th>Kebutuhan Material</th>
                <th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			@foreach($dataBom as $item)
			<tr>
				<td>{{ $item->id }}</td>
				<td>{{$item->id_boms}}</td>
				<td>{{$item->nama_workcenter}}</td>
				<td>{{$item->id_materialbom}}</td>
				<td>{{$item->nama_materialbom}}</td>
				<td>{{$item->uom_material}}</td>
                <td>{{$item->usage_material}}</td>
                <td>{{$item->keterangan}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
 
</body>
</html>