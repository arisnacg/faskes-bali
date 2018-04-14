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
						<p class="card-title">Pencarian Kontrak</p>
						<!-- tabel -->
						<div id="app">
							<filter-kontrak></filter-kontrak>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

@endsection