@extends('layouts.app')

@section('content')

	{{-- navbar --}}
	@include('inc.navbar')
    {{-- sidebar --}}
	@include('inc.sidebar')
	{{-- sidebar --}}
	<div class="content">
		<div class="card-pengaturan box-white">
			<h1><b style="color: #5ebea9; margin-right: 2px">PENGATURAN</b> APLIKASI</h1>
			<form method="POST" action="/pengaturan" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="col-sm-12">
					<div class="form-group">
						<label class="label-control">Ganti Nama Aplikasi</label>
						<input type="text" class="form-control" name="name" placeholder="Nama Aplikasi" value="{{$app->name}}">
					</div>
					<div class="form-group">
						<label class="label-control">Ganti Logo Aplikasi</label>
						<input type="file" class="form-control" name="image">
					</div>
					<div class="form-group" style="margin-top: 40px">
						<center>
							<button type="submit" class="btn btn-success btn-block">
								<span class="fa fa-save"></span> SIMPAN
							</button>
						</center>
					</div>
				</div>
			</form>
		</div>

	</div>

@endsection