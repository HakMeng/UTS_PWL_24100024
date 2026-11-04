<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('IndexMatakuliah', ['Matakuliahs' => Matakuliah::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('creatematakuliah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Matakuliah::create([
            'kode' => $request->kode,
            'nama_matakuliah' => $request->nama_matakuliah
        ]);

        return redirect()->route('matakuliah.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('matakuliah.show', ['matakuliah']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('matakuliah.update', ['matakuliah']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Matakuliah::find($id)->delete();
    }
}

