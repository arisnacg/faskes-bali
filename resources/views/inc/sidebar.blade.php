<nav class="sidebar" id="sidebar">
	<div class="logo-app" style="background-image: url('{{asset('images/logo.png')}}')"></div>
	<span>Pengelolaan</span>
	<ul>
		<li class="{{ Request::path() == '/' ? 'active' : '' }}">
			<a href="/"><span class="la la-home"></span>Beranda</a>
		</li>
		<li class="{{ Request::path() == 'faskes' ? 'active' : '' }}">
			<a href="/faskes"><span class="la la-road"></span>Kelola Faslitas</a>
		</li>
		<li class="{{ Request::path() == 'kontrak' ? 'active' : '' }}">
			<a href="/kontrak"><span class="la la-book"></span>Kelola Kontrak</a>
		</li>
		<li class="{{ Request::path() == 'rekanan' ? 'active' : '' }}">
			<a href="/rekanan"><span class="la la-building"></span>Kelola Rekanan</a>
		</li>
		<li class="{{ Request::path() == 'pegawai' ? 'active' : '' }}">
			<a href="/pegawai"><span class="la la-black-tie"></span>Kelola Pegawai</a>
		</li>
		<li class="{{ Request::path() == 'pengguna' ? 'active' : '' }}">
			<a href="/pengguna"><span class="la la-group"></span>Kelola User</a>
		</li>
	</ul>
	<span>Pencarian</span>
	<ul style="margin-bottom: 60px">
		<li class="{{ Request::path() == 'cari/faskes' ? 'active' : '' }}">
			<a href="/cari/faskes"><span class="la la-road"></span>Pencarian Fasilitas</a>
		</li>
		<li class="{{ Request::path() == 'cari/rambu' ? 'active' : '' }}">
			<a href="/cari/rambu"><span class="la la-map-signs"></span>Pencarian Rambu</a>
		</li>
		<li class="{{ Request::path() == 'cari/kontrak' ? 'active' : '' }}">
			<a href="/cari/kontrak"><span class="la la-book"></span>Pencarian Kontrak</a>
		</li>
		<li class="{{ Request::path() == 'cari/rekanan' ? 'active' : '' }}">
			<a href="/cari/rekanan"><span class="la la-building"></span>Pencarian Rekanan</a>
		</li>
		<li class="{{ Request::path() == 'cari/pegawai' ? 'active' : '' }}">
			<a href="/cari/pegawai"><span class="la la-black-tie"></span>Pencarian Pegawai</a>
		</li>
	</ul>
</nav>