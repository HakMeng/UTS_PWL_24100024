<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $matakuliahs = Matakuliah::all();

        $selectedDate = $request->input('tanggal', date('Y-m-d'));
        $selectedMk = $request->input('matakuliah_id');

        $mahasiswas = Mahasiswa::all();

        $absensis = Absensi::where('tanggal_absensi', $selectedDate)
            ->where('matakuliah_id', $selectedMk)
            ->get()
            ->keyBy('mahasiswa_id');

        return view('absensi.index', compact('matakuliahs', 'mahasiswas', 'absensis', 'selectedDate', 'selectedMk'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'tanggal_absensi' => 'required|date',
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'status' => 'required|array',
        ]);

        foreach ($request->status as $mahasiswa_id => $status) {
            Absensi::updateOrCreate(
                [
                    'tanggal_absensi' => $request->tanggal_absensi,
                    'matakuliah_id' => $request->matakuliah_id,
                    'mahasiswa_id' => $mahasiswa_id,
                ],
                [
                    'status_absen' => $status,
                ]
            );
        }

        return redirect()->back()->with('success', 'Data absensi berhasil disimpan!');
    }
}
