<!DOCTYPE html>
<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
	<title>Superadmin</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>

</head>
<body>
	<header>
		<nav>
			<ul>
				<li><a id="presensi" href="/admin">Data Presensi</a></li>
				<li><a id="petugas" href="/admin/petugas">Data Petugas</a></li>
				<li style="float:right"><a href="/">Presensi Mal Pelayanan Publik Terminal Mangkang</a></li>
			</ul>

		</nav>
	</header>
	<hr/>
 
	<!-- bagian judul halaman blog -->
	<h3> @yield('judul_halaman') </h3>
 
 
	<!-- bagian konten blog -->
	@yield('konten')
 
</body>
</html>