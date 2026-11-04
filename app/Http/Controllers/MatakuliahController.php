<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matakuliahs = Matakuliah::all();
        return view('matakuliah.index', compact('matakuliahs'));
    }

    public function create()
    {
        return view('matakuliah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:255|unique:matakuliahs,kode',
            'nama_matakuliah' => 'required|string|max:255',
        ]);

        Matakuliah::create([
            'kode' => $request->kode,
            'nama_matakuliah' => $request->nama_matakuliah,
        ]);

        return redirect()->route('matakuliah.index')->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    public function edit(Matakuliah $matakuliah)
    {
        return view('matakuliah.edit', compact('matakuliah'));
    }

    public function update(Request $request, Matakuliah $matakuliah)
    {
        $request->validate([
            'kode' => 'required|string|max:255|unique:matakuliahs,kode,' . $matakuliah->id,
            'nama_matakuliah' => 'required|string|max:255',
        ]);

        $matakuliah->update([
            'kode' => $request->kode,
            'nama_matakuliah' => $request->nama_matakuliah,
        ]);

        return redirect()->route('matakuliah.index')->with('success', 'Mata Kuliah berhasil diperbarui.');
    }

    public function destroy(Matakuliah $matakuliah)
    {
        $matakuliah->delete();
        return redirect()->route('matakuliah.index')->with('success', 'Mata Kuliah berhasil dihapus.');
    }
}
