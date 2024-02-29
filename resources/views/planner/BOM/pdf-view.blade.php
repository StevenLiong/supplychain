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
	<div>
		<center>	
			<img src="{{ public_path('assets/LogoTrafoindo.png') }}" width="200px">
		</center>
	</div>
	<br>
	<center>
        <h5>Bill of Material @if($dataBom->isNotEmpty()) {{ $dataBom->first()->id_boms }} @endif</h5>
	</center>
	<!-- <img src="/public/templatetrafindo/assets/images/logotrafindo.png" style="width: 10rem;height:5rem;"> -->

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th> 
				<th>Nama Workcenter</th>
				<th>Kode Material</th>
				<th>Nama Material</th>
				<th>UOM</th>
                <th>Kebutuhan Material</th>
                <th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			@foreach($dataBom as $index => $item)
			<tr>
				<td>{{ $index + 1 }}</td>
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