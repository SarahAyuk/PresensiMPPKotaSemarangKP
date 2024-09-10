<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Anjungan;
use App\Models\Presensi;
use Carbon\Carbon;

class IndexController extends Controller
{
    //awal halaman
    public function index(){
        // Ambil hari libur dalam setahun
        $url = 'https://api-harilibur.vercel.app/api';
        $isi_kalender = file_get_contents($url);
        $kalender = json_decode($isi_kalender, true);

        // Ambil datetime hari ini
        $nowDatetime = Carbon::now();
        $date = $nowDatetime->toDateString();

        // Cek apakah hari ini libur atau tidak
        $collection = collect($kalender);
        $filtered = $collection->where('holiday_date', $date)
                            ->where('is_national_holiday', true);

        if($filtered->isEmpty()){
            // Ambil data Anjungan
            $data['anjungan'] = Anjungan::get(["nama_anjungan", "Id"]);
            return view('index', $data);

        } else {

            return $filtered;
        }

    }

    public function updatePresensi(Request $request){
        
        // Ambil datetime hari ini
        $nowDatetime = Carbon::now();
        $date = $nowDatetime->toDateString();
        $time = $nowDatetime->toTimeString();
        $presensi = $request->presensi;

        if($presensi=="Pulang"){
            Presensi::where('id',$request->presensi_id)->update([
                'jam_pulang' => $time,
                'update_datetime' => $nowDatetime,
                'version' => $request->version+1
            ]);

            return redirect('/presensi')->with('success','Selesai, Jam Pulang Diperbaharui!');;
            
        } else {
            Presensi::insert([
                'petugas_id' => $request->petugas_id,
                'anjungan_id' => $request->anjungan_id,
                'tanggal' => $date,
                'jam_masuk' => $time,
                'jam_pulang' => '',
                'create_datetime' => $nowDatetime,
                'update_datetime' => $nowDatetime,
                'version' => 1
            ]);            

            return redirect('/presensi') ->with('success','Selamat datang, Presensi Berhasil!');
        }
    }

    public function getData(Request $request, $id){

        $today = Carbon::now()->format('Y-m-d');
        $data = Presensi::where( "petugas_id", $id)
                        ->where("tanggal", $today)
                        ->get(["id", "petugas_id", "anjungan_id", "tanggal", "jam_masuk", "jam_pulang"]);

        return response()->json($data);
    }

}
