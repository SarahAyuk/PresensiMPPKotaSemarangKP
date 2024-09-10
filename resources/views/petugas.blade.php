
@extends('master')
 
@section('judul_halaman')

@section('konten')

@include('flashMessage')
@yield('content')

    <a class="button-link add" href="/admin/petugas/addPetugas"> + Tambah Baru </a>	
	<br/>
 
	<table border="1">
		<tr>
			<th>Nama</th>
			<th>Instansi</th>
			<th>Nomor WA</th>
			<th>Status Aktif</th>
			<th>Action</th>
		</tr>
		@foreach($collection as $p)
		<tr>
			<td>{{ $p->petugas_name }}</td>
			<td>{{ $p->nama_anjungan }}</td>
			<!-- <td style='display:none;'>{{ $p->anjungan_id }}</td> -->
			<td>{{ $p->phone}}</td>
			<td>{{ ($p->active) == 'Y' ? 'YES':'NO' }}</td>
			<td class="action">
				<a class="action-icon" href="/admin/petugas/edit/{{ $p->id }}">
					<i class="fa fa-pencil"></i></a>
			</td>
		</tr>
		@endforeach
	</table>

	
	<ul class="center pagination">
		{{ $collection->render('pagination.custom') }}
	</ul>
 
	<script>
		$(document).ready(function() {
			var petugas = document.getElementById('petugas');

			petugas.classList.toggle('active');	
		});
	</script>


@endsection