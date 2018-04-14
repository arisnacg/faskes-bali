<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<style type="text/css">
	
* {
	font-size: 12px !important;
}

.table th, .table tr, .table td {
	border-color: #000 !important;
} 

</style>
</head>
<body>
	<div class="container-fluid">
		{{asset('images/logo.png')}}
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Kode Rambu</th>
					<th>Kode Kontrak</th>
					<th width="100px">Latitude</th>
					<th width="100px">Longitude</th>
					<th>Tabel Rambu</th>
					<th>Volume</th>
					<th>Kondisi</th>
				</tr>
			</thead>
			<tbody>
				@foreach($rows as $i => $row)
					<tr>
						<td>{{ $i + 1 }}</td>
						<td>{{ $row->code }}</td>
						<td>{{ $row->contract_code }}</td>
						<td>{{ $row->latitude }}</td>
						<td>{{ $row->longitude }}</td>
						<td>{{ $row->traffic_sign_type_name }}</td>
						<td>{{ $row->volume }}</td>
						<td>{{ $row->condition_name }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	
</body>
</html>

