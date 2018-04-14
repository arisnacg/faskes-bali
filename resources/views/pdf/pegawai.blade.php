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
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>No</th>
				<th>NIP</th>
				<th>Nama</th>
				<th>Jabatan</th>
			</tr>
		</thead>
		<tbody>
			@foreach($rows as $i => $row)
				<tr>
					<td>{{ $i + 1 }}</td>
					<td>{{ $row->nip }}</td>
					<td>{{ $row->name }}</td>
					<td>{{ $row->position->name }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>

