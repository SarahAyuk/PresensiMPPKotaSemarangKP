<!DOCTYPE html>
<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
	<title>Petugas Petugas MPP</title>
</head>
<body>	
	
@include('flashMessage')
  
  @yield('content')
  
	<nav>
		<ul>
			<li><a>TAMBAH PETUGAS MPP</a></li>
			<li style="float:right"><a href="#">Presensi Mal Pelayanan Publik Terminal Mangkang</a></li>
		</ul>
	</nav>

	<form action="/admin/petugas/add/insertPetugas" method="post" class="form">
		{{ csrf_field() }}
		<p>
			<label> Nama </label>
			<input type="text" name="petugas_name">
		</p>
			<label> Anjungan </label>
			<select class="select" id="anjungan-dropdown" name="anjungan_id">
				<option value="">-- Select Anjungan --</option>
					@foreach ($anjungan as $data)
					<option value="{{ $data->Id }}">
						{{ $data->nama_anjungan }}
					</option>
					@endforeach
			</select>
		</p>
		<p>
			<label> No WhatsApp </label>
			<input type="tel" name="phone">
		</p>
		<p>	
		<div class='field'>
			<label> Active </label>	
			<ul class='options'>
				<li class='option'>
					<input class='option-input' type="radio" id="option1" name="active" value="Y" checked >
					<label class='option-label' for="option1">YES</label>
				</li>
				<li class='option'>
					<input class='option-input' type="radio" id="option2" name="active" value="N" >
					<label class='option-label' for="option2">NO</label>
				</li>
			</ul>
		</div>
		</p>
		<p>
			<input type="submit" value="Simpan Data">
			<a class="button-link back" href="/admin/petugas"> Back </a>
		</p>
	</form>
    
</body>
</html>