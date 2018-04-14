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
				<th>Kode</th>
				<th>Nilai</th>
				<th>Konsultan</th>
				<th>Kontraktor</th>
				<th>PPK</th>
				<th>PPTK</th>
				<th>Tahun</th>
			</tr>
		</thead>
		<tbody>
			@foreach($rows as $i => $row)
				<tr>
					<td>{{ $i + 1 }}</td>
					<td>{{ $row->code }}</td>
					<td>Rp. {{ $row->value }}</td>
					<td>{{ $row->consultant->name }}</td>
					<td>{{ $row->contractor->name }}</td>
					<td>{{ $row->ppk->name }}</td>
					<td>{{ $row->pptk->name }}</td>
					<td>{{ $row->year }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>

