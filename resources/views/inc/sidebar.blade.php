<nav class="sidebar" id="sidebar">
	<span>Navigasi</span>
	<ul>
		<li class="{{ Request::path() == '/' ? 'active' : '' }}">
			<a href="/"><span class="la la-home"></span>Beranda</a>
		</li>
		<li class="{{ Request::path() == 'pegawai' ? 'active' : '' }}">
			<a href="/pegawai"><span class="la la-user"></span>Kelola Pegawai</a>
		</li>
	</ul>
</nav>