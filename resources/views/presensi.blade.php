
@extends('master')
 
@section('judul_halaman', '')

@section('konten')

@include('flashMessage')
@yield('content')
 
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<table border="1">
		<tr>
			<th>Nama</th>
			<th>Instansi</th>
			<th>Nomor WA</th>
			<th>Tanggal</th>
			<th>Presensi Hadir</th>
			<th>Presensi Pulang</th>
			<th>Action</th>
		</tr>
		@foreach($collection as $p)
		<tr>
			<td>{{ $p->petugas_name }}</td>
			<td>{{ $p->nama_anjungan }}</td>
			<td>{{ $p->phone}}</td>
			<td>{{ $p->tanggal }}</td>
			<td>{{ $p->jam_masuk }}</td>
			<td>{{ $p->jam_pulang }}</td>
			<td class="action">
				<a class="action-icon" href="/admin/dataPresensi/edit/{{ $p->id }}">
					<i class="fa fa-pencil"></i></a>
				<!-- <a class="action-icon" href="/admin/dataPresensi/hapus/{{ $p->id }}">  -->
				<a href="#" class="action-icon-remove" data-id="{{ $p->id }}">
					<i class="fa fa-trash"></i> </a>
			</td>
		</tr>
		@endforeach
	</table>

	<ul class="pagination">
		{{ $collection->render('pagination.custom') }}
	</ul>

	
    <script src="/js/app.js"></script>
	<script>
		$(document).ready(function() {
			var presensi = document.getElementById('presensi');
			var csrfToken = $('meta[name="csrf-token"]').attr('content');
			presensi.classList.toggle('active');

			$('.action-icon-remove').click(function(e) {
				e.preventDefault();
				var id = $(this).data('id');    
                console.log(id);   
				if (confirm("Apakah Anda yakin ingin menghapus item ini?")) {
					$.ajax({
						url: '/admin/dataPresensi/hapus/ ' + id,
						type: 'DELETE',
						headers: {
							'X-CSRF-TOKEN': csrfToken
						},
						success: function(response) {
							alert("Item berhasil dihapus!");
							location.reload(); // Refresh halaman setelah penghapusan berhasil
						},
						error: function(xhr) {
							alert("Gagal menghapus item.");
						}
					});

					
				}
			});
	
		});
	</script>

@endsection