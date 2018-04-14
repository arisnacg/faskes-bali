@extends('layouts.app')

@section('content')

	{{-- navbar --}}
	@include('inc.navbar')
    {{-- sidebar --}}
	@include('inc.sidebar')

	<div class="content">
		<h4>Dashboard</h4>
		<p>Selamat Datang di Panel Administrasi</p>
		
		<!-- info data -->
		<div class="row">
			<div class="col-sm-12 col-md-6 col-lg-3">
				<div class="card">
					<div class="card-body">
						<div class="data-db">
							<div class="data-img" style="background: #d5f6fb; border-color: #23d3eb">
								<span class="la la-black-tie" style="color: #23d3eb"></span>
							</div>
							<div class="data-detail">
								<span>{{$num_employee}}</span>
								<p>Jumlah pegawai</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-6 col-lg-3">
				<div class="card">
					<div class="card-body">
						<div class="data-db">
							<div class="data-img" style="border-color: #fb7eaa; background: #fee2eb">
								<span class="la la-building" style="color: #fb7eaa"></span>
							</div>
							<div class="data-detail">
								<span>{{$num_partner}}</span>
								<p>Jumlah rekanan</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-6 col-lg-3">
				<div class="card">
					<div class="card-body">
						<div class="data-db">
							<div class="data-img" style="border-color: #6f63ba; background: #d9d5ec">
								<span class="la la-book" style="color: #6f63ba"></span>
							</div>
							<div class="data-detail">
								<span>{{$num_contract}}</span>
								<p>Jumlah kontrak</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-6 col-lg-3">
				<div class="card">
					<div class="card-body">
						<div class="data-db">
							<div class="data-img" style="border-color: #88cb70; background: #e4f5df">
								<span class="la la-road" style="color: #88cb70"></span>
							</div>
							<div class="data-detail">
								<span>{{$num_facility}}</span>
								<p>Jumlah fasilitas</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- info data -->
	</div>

	

@endsection