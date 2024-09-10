<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Petugas;

class AutoPetugasController extends Controller
{
   public function index(){

      // Load index view
      return view('autoPetugas.index');
   }

   // Fetch records
   public function getPetugas(Request $request){
      $search = $request->search;
      $anjungan_id = $request->anjungan_id;
      Log::debug('Showing the user : '.$anjungan_id);

      if($anjungan_id == '' && $search == ''){
          $petugas = Petugas::orderby('petugas_name','asc')
                            ->select('id','petugas_name','phone')
                            ->limit(15)->get();
       }else if($search == ''){
         $petugas = Petugas::orderby('petugas_name','asc')
                           ->select('mpp_petugas.id','mpp_petugas.petugas_name','mpp_petugas.phone')
                           ->where('mpp_petugas.anjungan_id', $anjungan_id)
                           ->limit(15)->get();
      }else{
          $petugas = Petugas::orderby('mpp_petugas.petugas_name','asc')
                            ->select('mpp_petugas.id','mpp_petugas.petugas_name', 'mpp_petugas.phone')
                            ->where('mpp_petugas.petugas_name', 'like', '%' .$search . '%')
                            ->where('mpp_petugas.anjungan_id', $anjungan_id)
                            ->limit(5)->get();
      }

      $response = array();
      foreach($petugas as $p){
         $response[] = array("phone"=>$p->phone,
                              "label"=>$p->petugas_name,
                              // "jam_masuk"=>$p->jam_masuk,
                              // "jam_pulang"=>$p->jam_pulang,
                              "id"=>$p->id);
      }

      return response()->json($response); 
   } 

}