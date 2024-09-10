<!DOCTYPE html>
<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
	<title>Presensi Petugas MPP</title>
</head>
<body>
    <!-- <a href="/admin"> Back </a> -->

    @include('flashMessage')
  
    @yield('content')
	<nav>
		<ul>
			<li><a>EDIT PRESENSI</a></li>
			<li style="float:right"><a href="#">Presensi Mal Pelayanan Publik Terminal Mangkang</a></li>
		</ul>
	</nav>

    @foreach($presensi as $p)
	<form action="/admin/edit/updatePresensi" method="post" class="form">
		{{ csrf_field() }}
		<input type="hidden" name="id" value="{{ $p->id }}">
		<input type="hidden" name="version" value="{{ $p->version }}">
		<p>
			<label>Anjungan</label>
			<input type="text" name="nama_anjungan" value="{{ $p->nama_anjungan }}" disabled>
		</p>
		<p>
			<label>Nama</label>
			<input type="text" name="nama_petugas" value="{{ $p->petugas_name }}" disabled>
		</p>
		<p>
			<label>No WhatsApp</label>
			<input type="text" name="phone" value="{{ $p->phone }}" disabled>
		</p>
		<p>
			<label>Tanggal</label>
			<input type="date" name="tanggal" value="{{ $p->tanggal }}"/>
		</p>
		<p>
			<label>Jam Hadir</label>
			<input type="time" step="1" name="jam_masuk" value="{{ $p->jam_masuk }}">
		</p>
		<p>
			<label>Jam Pulang</label>
			<input type="time" step="1" name="jam_pulang" value="{{ $p->jam_pulang }}">
		</p>
		<tr>
			<input type="submit" value="Update">
			<a class="button-link back" href="/admin"> Back </a>
		</tr>
	</form>

	@endforeach	
 
</body>
</html>