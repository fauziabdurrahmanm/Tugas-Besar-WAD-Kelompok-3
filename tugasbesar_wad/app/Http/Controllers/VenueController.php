<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    // GET /venues - Menampilkan daftar ruangan
    public function index()
    {
        $venues = Venue::all();
        return view('venues.index', compact('venues'));
    }

    // GET /venues/create - Menampilkan form tambah (Opsional jika form ada di index)
    public function create()
    {
        return view('venues.create');
    }

    // POST /venues - Menyimpan data ruangan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_venue'   => 'required|string|max:255',
            'gedung'       => 'required|string|max:255',
            'provinsi_id'  => 'required',
            'kota_id'      => 'required',
            'kecamatan_id' => 'required',
            'kapasitas'    => 'required|integer',
            'fasilitas'    => 'nullable|string',
        ]);

        Venue::create([
            'nama_venue'   => $request->nama_venue,
            'gedung'       => $request->gedung,
            'provinsi_id'  => $request->provinsi_id,
            'kota_id'      => $request->kota_id,
            'kecamatan_id' => $request->kecamatan_id,
            'kapasitas'    => $request->kapasitas,
            'fasilitas'    => $request->fasilitas,
        ]);

        return redirect()->route('venues.index')->with('success', 'Ruangan berhasil ditambahkan!');
    }

    // GET /venues/{id}/edit - Menampilkan form edit
    public function edit($id)
    {
        $venue = Venue::findOrFail($id);
        return view('venues.edit', compact('venue'));
    }

    // PUT/PATCH /venues/{id} - Memperbarui data ruangan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_venue'   => 'required|string|max:255',
            'gedung'       => 'required|string|max:255',
            'provinsi_id'  => 'required',
            'kota_id'      => 'required',
            'kecamatan_id' => 'required',
            'kapasitas'    => 'required|integer',
            'fasilitas'    => 'nullable|string',
        ]);

        $venue = Venue::findOrFail($id);
        $venue->update($request->all());

        return redirect()->route('venues.index')->with('success', 'Data ruangan berhasil diperbarui!');
    }

    // DELETE /venues/{id} - Menghapus data ruangan
    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);
        $venue->delete();

        return redirect()->route('venues.index')->with('success', 'Ruangan berhasil dihapus!');
    }
}