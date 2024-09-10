<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutoPetugasController; 
use App\Http\Controllers\IndexController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index');
Route::get('/presensi', 'IndexController@index');
Route::post('/presensi/updatePresensi', 'IndexController@updatePresensi');
Route::post('/dropdown/petugas', 'IndexController@petugas');

Route::get('/admin', 'PresensiController@index');
Route::delete('/admin/dataPresensi/hapus/{id}', 'PresensiController@hapusPresensi');
Route::get('/admin/dataPresensi/edit/{id}', 'PresensiController@editPresensi');
Route::post('/admin/edit/updatePresensi', 'PresensiController@updatePresensi');
// Route::delete('/admin/dataPresensi/hapus/{id}', 'DataPresensiController@delete')->name('dataPresensi.hapusPresensi');
// Route::get('/admin/dataPresensi/hapus/{id}', [DataPresensiController::class, 'getData'])->name('hapusPresensi');

Route::get('/admin/petugas', 'PetugasController@index');
Route::get('/admin/petugas/addPetugas', 'PetugasController@addPetugas');
Route::post('/admin/petugas/add/insertPetugas', 'PetugasController@insertPetugas');
Route::get('/admin/petugas/edit/{id}', 'PetugasController@editPetugas');
Route::post('/admin/petugas/edit/updatePetugas', 'PetugasController@updatePetugas');
// Route::post('/admin/petugas/hapus/{id}', 'PetugasController@hapusPetugas');

// Autocomplete
Route::post('/getPetugas', [AutoPetugasController::class, 'getPetugas'])->name('getPetugas');
Route::get('/select-data/{id}', [IndexController::class, 'getData'])->name('select-data');

?>