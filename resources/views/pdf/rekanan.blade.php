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
				<th>Nama</th>
				<th>Direktur</th>
				<th>Jenis</th>
				<th>Alamat</th>
				<th>Email</th>
				<th>Telepon</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$jenis = ["Konsultan", "Kontraktor"];
			?>
			@foreach($rows as $i => $row)
				<tr>
					<td>{{ $i + 1 }}</td>
					<td>{{ $row->name }}</td>
					<td>{{ $row->director }}</td>
					<td>{{ $jenis[$row->type-1] }}</td>
					<td>{{ $row->address }}</td>
					<td>{{ $row->email }}</td>
					<td>{{ $row->phone }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>

