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
        // 1. Get all Mata Kuliah for the ComboBox (Dropdown)
        $matakuliahs = Matakuliah::all();

        // 2. Get the selected date and mata kuliah from the request (or default to today)
        $selectedDate = $request->input('tanggal', date('Y-m-d'));
        $selectedMk = $request->input('matakuliah_id');

        // 3. Get all Mahasiswa
        $mahasiswas = Mahasiswa::all();

        // 4. Fetch existing attendance for the selected date and MK
        // We use keyBy('mahasiswa_id') so we can easily check if a student has a status in the view
        $absensis = Absensi::where('tanggal_absensi', $selectedDate)
            ->where('matakuliah_id', $selectedMk)
            ->get()
            ->keyBy('mahasiswa_id');

        return view('absensi.index', compact('matakuliahs', 'mahasiswas', 'absensis', 'selectedDate', 'selectedMk'));
    }

    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'tanggal_absensi' => 'required|date',
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'status' => 'required|array', // Array of statuses, e.g., ['mahasiswa_id' => 'hadir']
        ]);

        // Loop through the submitted statuses and update or create the records
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