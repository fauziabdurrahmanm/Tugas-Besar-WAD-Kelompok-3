<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Resources\EventResource; // Panggil Resource yang sudah dibuat
use Illuminate\Support\Facades\Validator;

class EventApiController extends Controller
{
    /**
     * GET /api/events
     */
    public function index(Request $request)
    {
        // 1. Query Dasar + Relasi
        $query = Event::with(['category', 'venue']);

        // 2. Filter Search (Opsional)
        if ($request->has('search')) {
            $query->where('nama_event', 'like', '%' . $request->search . '%');
        }

        // 3. Filter Kategori (Opsional)
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 4. Ambil data (Latest)
        $events = $query->latest()->get();

        // 5. Return JSON pakai Resource Collection
        return response()->json([
            'status'  => true,
            'message' => 'List Data Events',
            'data'    => EventResource::collection($events)
        ], 200);
    }

    /**
     * GET /api/events/{id}
     */
    public function show($id)
    {
        $event = Event::with(['category', 'venue'])->find($id);

        if (!$event) {
            return response()->json([
                'status'  => false,
                'message' => 'Event tidak ditemukan',
                'data'    => null
            ], 404);
        }

        // Return JSON pakai Resource Single
        return response()->json([
            'status'  => true,
            'message' => 'Detail Data Event',
            'data'    => new EventResource($event)
        ], 200);
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'nama_event'    => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'venue_id'      => 'required|exists:venues,id',
            'tanggal_event' => 'required|date',
            'deskripsi'     => 'nullable|string'
        ]);

        // Jika validasi gagal, kembalikan JSON error 422
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi Gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        // 2. Simpan Data
        $event = Event::create([
            'nama_event'    => $request->nama_event,
            'category_id'   => $request->category_id,
            'venue_id'      => $request->venue_id,
            'tanggal_event' => $request->tanggal_event,
            'deskripsi'     => $request->deskripsi,
            'user_id'       => 1, // Hardcode ID Admin dulu (karena belum ada auth API)
        ]);

        // 3. Return JSON Sukses (Code 201 = Created)
        return response()->json([
            'status'  => true,
            'message' => 'Event Berhasil Ditambahkan',
            'data'    => new EventResource($event)
        ], 201);
    }

    /**
     * PUT /api/events/{id}
     * Update Event via API
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['status' => false, 'message' => 'Event tidak ditemukan'], 404);
        }

        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_event'    => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'venue_id'      => 'required|exists:venues,id',
            'tanggal_event' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        // Update
        $event->update($request->all());

        return response()->json([
            'status'  => true,
            'message' => 'Event Berhasil Diupdate',
            'data'    => new EventResource($event)
        ], 200);
    }

    /**
     * DELETE /api/events/{id}
     * Hapus Event via API
     */
    public function destroy($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['status' => false, 'message' => 'Event tidak ditemukan'], 404);
        }

        $event->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Event Berhasil Dihapus'
        ], 200);
    }
}
