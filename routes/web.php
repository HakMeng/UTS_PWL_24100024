<?php

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
Route::get('/mahasiswa-new', [MahasiswaController::class, 'create']);
Route::get('/mahasiswa', [MahasiswaController::class, 'store']);
Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'edit']);
Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy']);
Route::resource('matakuliah', MatakuliahController::class);
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
