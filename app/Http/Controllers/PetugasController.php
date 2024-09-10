<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Models\Petugas;
use App\Models\Anjungan;
use Carbon\Carbon;

class PetugasController extends Controller
{
    public function index(){
        $data = Petugas::join('data_anjungan', 'mpp_petugas.anjungan_id', '=', 'data_anjungan.Id')
                        ->get(['data_anjungan.nama_anjungan', 'mpp_petugas.*']);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 5; // Jumlah item per halaman
    
        $collection = new LengthAwarePaginator(
            $data->forPage($currentPage, $perPage),
            $data->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    
        return view('petugas', compact('collection'));
    }

    public function addPetugas(){
        $anjungan = Anjungan::get(["nama_anjungan", "Id"]);

        // return view('editPetugas',['petugas' => $petugas]);
        return view('addPetugas', ['anjungan' => $anjungan]);
    }

    public function insertPetugas(Request $request){
        $nowDatetime = Carbon::now();

        Petugas::insert([
            'petugas_name' => $request->petugas_name,
            'anjungan_id' => $request->anjungan_id,
            'phone' => $request->phone,
            'active' => $request->active,
            'create_datetime' => $nowDatetime,
            'update_datetime' => $nowDatetime,
            'version' => 1
        ]);

        return redirect('/admin/petugas')->with('success','Petugas Berhasil di Tambahkan!');
    }

    public function editPetugas($id){
        // Preparing data Petugas untuk di edit
        $petugas = Petugas::where('mpp_petugas.id', $id)
            ->join('data_anjungan', 'mpp_petugas.anjungan_id', '=', 'data_anjungan.Id')
            ->get(['mpp_petugas.petugas_name', 'mpp_petugas.phone','mpp_petugas.active', 
            'data_anjungan.nama_anjungan', 'data_anjungan.Id as anjungan_id', 'mpp_petugas.*']);
        
        // Ambil data Anjungan untuk Dropdown 
        $anjungan = Anjungan::get(["nama_anjungan", "Id"]);

        // return view('editPetugas',['petugas' => $petugas]);
        return view('editPetugas', ['petugas' => $petugas, 'anjungan' => $anjungan]);
    }

    public function updatePetugas(Request $request){
        $nowDatetime = Carbon::now();

        // update data Petugas
        Petugas::where('id',$request->id)->update([
                'petugas_name' => $request->petugas_name,
                'anjungan_id' => $request->anjungan_id,
                'phone' => $request->phone,
                'active' => $request->active,
                'update_datetime' => $nowDatetime,
                'version' => $request->version+1
            ]);

        // alihkan halaman ke halaman Data Petugas
        return redirect('/admin/petugas')->with('success','Data Berhasil di Ubah!');
    }
}
