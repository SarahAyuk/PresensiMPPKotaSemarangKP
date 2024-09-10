<!DOCTYPE html>
<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Presensi Petugas MPP</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    <!-- Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
</head>
<body>
    
	<nav>
		<ul>
			<li></li>
			<li style="float:right"><a href="#">Presensi Mal Pelayanan Publik Terminal Mangkang</a></li>
		</ul>
	</nav>
    
    @include('flashMessage')
  
    @yield('content')
    <div class="container">
    <div class="frame-form">
        <form class="form" action="/presensi/updatePresensi" method="post" >
            {{ csrf_field() }}
            <p>
                <label> Anjungan </label>
                <select id="anjungan-dropdown" name="anjungan_id">
                    <option value="">-- Select Anjungan --</option>
                        @foreach ($anjungan as $data)
                        <option value="{{$data->Id}}">
                            {{$data->nama_anjungan}}
                        </option>
                        @endforeach
                </select>
            </p>
            <p>
                <label> Nama </label>
                <input type="text" id='petugas_name' name="petugas_name">
                <input type="hidden" id="petugas_id" name="petugas_id">
            </p>
            <p>
                <label> No WhatsApp </label>
                <input type="text" id='petugas_phone' disabled>
            </p>
            <p>        
                <label class="label-half"> Jam Masuk</label>
                <input type="text" id='jam_masuk' disabled> <br/>
            </p>
            <p>
                <label class="label-half"> Jam Pulang </label>
                <input type="text" id='jam_pulang' disabled> <br/><br/>
            <p>
                <input id="submit_button" name="presensi" type="submit" value="Hadir">
                <input type="hidden" id="presensi_id" name="presensi_id">
            </p>

        </form>
        </div>
        </div>

    <script src="/js/app.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            // Ketika data Anjungan berubah maka kolom petugas dan nomor wa akan dikosongkan
            $('#anjungan-dropdown').on('change', function (){
                $('#petugas_name').val(''); // kosongkan kolom petugas
                $('#petugas_phone').val(''); // kosongkan kolom phone
                $('#jam_masuk').val(''); // kosongkan kolom phone
                $('#jam_pulang').val(''); // kosongkan kolom phone
            });        

            const submitButton = document.getElementById('submit_button');
            const petugas = document.getElementById('petugas_name');
            
            document.getElementById("submit_button").style.visibility="hidden";
        
            // Ini untuk Autocomplete Pegawai Name 
            $('#petugas_name').autocomplete({
                source: function( request, response ) {
                // Fetch data
                    $.ajax({
                        url:"{{route('getPetugas')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: '{{csrf_token()}}',
                            anjungan_id: document.getElementById("anjungan-dropdown").value,
                            search: request.term
                        },
                        success: function( data ) {       
                            console.log(data);     
                            console.log(document.getElementById("anjungan-dropdown").value);
                            console.log(request.term);

                            response( data );
                        }, 
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('AJAX request failed:', textStatus, errorThrown);
                        }
                    });
                },
                
                select: function (event, ui) {
                    var selectedId = ui.item.id;

                    // Set selection
                    $('#petugas_name').val(ui.item.label); // display the selected text
                    $('#petugas_phone').val(ui.item.phone); // save selected phone to input
                    $('#petugas_id').val(selectedId); // save selected phone to input
                    $('#jam_masuk').val(''); // kosongkan kolom phone
                    $('#jam_pulang').val(''); // kosongkan kolom phone
                    $('#presensi_id').val(''); // kosongkan kolom presensi id
                    
                    $.ajax({
                        url: '/select-data/' + selectedId, // Replace with the actual route URL
                        type: 'GET',
                        success: function(response) {
                            // Handle the response data
                            var array = response;
                            var object = array[0];      
                            console.log(response);                      

                            if(object == null){
                                document.getElementById("submit_button").style.visibility="visible";
                                submitButton.value = "Hadir"
                            } else if(object.jam_pulang != "" ){                                
                                $('#jam_masuk').val(object.jam_masuk);
                                $('#jam_pulang').val(object.jam_pulang);
                                $('#presensi_id').val(object.id);

                                document.getElementById("submit_button").style.visibility="hidden";
                            } else {
                                $('#jam_masuk').val(object.jam_masuk);
                                $('#jam_pulang').val(object.jam_pulang);
                                $('#presensi_id').val(object.id);

                                document.getElementById("submit_button").style.visibility="visible";
                                submitButton.value = "Pulang"
                            } 
                        },
                        error: function(xhr, status, error) {
                            // Handle the error
                            console.log(error);
                            console.log(xhr);
                        }
                    });

                    return false;
                }
            });
        });
    </script>
 
</body>
</html>