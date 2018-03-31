<nav class="sidebar" id="sidebar">
	<span>Navigasi</span>
	<ul>
		<li class="{{ Request::path() == '/' ? 'active' : '' }}">
			<a href="/"><span class="la la-home"></span>Beranda</a>
		</li>
		<li class="{{ Request::path() == 'pengguna' ? 'active' : '' }}">
			<a href="/pengguna"><span class="la la-user"></span>Kelola User</a>
		</li>
		<li class="{{ Request::path() == 'pegawai' ? 'active' : '' }}">
			<a href="/pegawai"><span class="la la-black-tie"></span>Kelola Pegawai</a>
		</li>
		<li class="{{ Request::path() == 'rekanan' ? 'active' : '' }}">
			<a href="/rekanan"><span class="la la-building"></span>Kelola Rekanan</a>
		</li>
		<li class="{{ Request::path() == 'kontrak' ? 'active' : '' }}">
			<a href="/kontrak"><span class="la la-building"></span>Kelola Kontrak</a>
		</li>
	</ul>
</nav>