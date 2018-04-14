@extends('layouts.app')

@section('content')

	{{-- navbar --}}
	@include('inc.navbar')
    {{-- sidebar --}}
	@include('inc.sidebar')
	{{-- sidebar --}}
	<div class="content">

		{{-- Navigasi --}}
		{{-- <nav aria-label="breadcrumb" role="navigation">
		  <ol class="breadcrumb box-white">
		    <li class="breadcrumb-item"><a href="#">Beranda</a></li>
		    <li class="breadcrumb-item " aria-current="page">Pegawai</li>
		  </ol>
		</nav> --}}

		<!-- tabel penjadwalan -->
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-body">
						<p class="card-title">Tabel Kelola Rekanan</p>
						<!-- tabel -->
						<div id="app">
							<rekanan-table></rekanan-table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

@endsection