@extends('layouts.app')

@section('content')

	{{-- navbar --}}
	@include('inc.navbar')
    {{-- sidebar --}}
	@include('inc.sidebar')
	{{-- sidebar --}}
	<div class="content">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-body">
						<p class="card-title">Pencarian Fasilitas</p>
						<!-- tabel -->
						<div id="app">
							<filter-faskes></filter-faskes>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

@endsection