<!-- navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
	<button v-show="check" type="button" id="sidebarCollapse">
		<span class="la la-bars"></span>
	</button>
	<a class="navbar-brand" href="#">
		<b style="color: #5ebea9; margin-right: 2px">FASKES</b>.DEV
	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="lalse" aria-label="Toggle navigation">
		<span class="la la-ellipsis-v"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav ml-auto" v-show="check">
			<li class="nav-item active">
				<a class="nav-link" href="#"><span class="la la-user"></span> Gus Arisna</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="#" @click.stop="logout">
					<span class="la la-power-off"></span>
					<div class="icon-typo">Log Out</div>
				</a>
			</li>
		</ul>
	</div>
</nav>
<!-- navbar -->