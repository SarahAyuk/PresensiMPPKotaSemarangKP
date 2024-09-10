<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Presensi;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index(){
        $data = Presensi::join('data_anjungan', 'mpp_presensi.anjungan_id', '=', 'data_anjungan.Id')
                        ->join('mpp_petugas', 'mpp_presensi.petugas_id', '=', 'mpp_petugas.id')
                        ->get(['mpp_petugas.petugas_name', 'mpp_petugas.phone','mpp_petugas.active', 
                        'data_anjungan.nama_anjungan', 'mpp_presensi.*']);
                        
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 5; // Jumlah item per halaman
    
        $collection = new LengthAwarePaginator(
            $data->forPage($currentPage, $perPage),
            $data->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    
        return view('presensi', compact('collection'));
    }

    public function hapusPresensi($id){
        log($id);
        Presensi::where('id', $id)
                ->delete();

        return response()->json(['success' => true]);

        // return redirect('/admin');      
    }

    public function editPresensi($id){
        $presensi = Presensi::where('mpp_presensi.id', $id)
            ->join('data_anjungan', 'mpp_presensi.anjungan_id', '=', 'data_anjungan.Id')
            ->join('mpp_petugas', 'mpp_presensi.petugas_id', '=', 'mpp_petugas.id')
            ->get(['mpp_petugas.petugas_name', 'mpp_petugas.phone','mpp_petugas.active', 
            'data_anjungan.nama_anjungan', 'mpp_presensi.*']);
        
        return view('editPresensi',['presensi' => $presensi]);
    }

    public function updatePresensi(Request $request){
        // Ambil datetime hari ini
        $nowDatetime = Carbon::now();

        if($request->filled('jam_pulang')){
            $jam_pulang = $request->jam_pulang;
        } else {
            $jam_pulang = '';
        };

        if($request->filled('jam_masuk')){
            $jam_masuk = $request->jam_masuk;
        } else {
            $jam_masuk = '';
        };

        // update data pegawai
        Presensi::where('id',$request->id)->update([
            'tanggal' => $request->tanggal,
            'jam_masuk' => $jam_masuk,
            'jam_pulang' => $jam_pulang,
            'update_datetime' => $nowDatetime,
            'version' => $request->version+1
        ]);

        // alihkan halaman ke halaman admin
        return redirect('/admin')->with('success','Data Berhasil di Ubah!');
    }
}
