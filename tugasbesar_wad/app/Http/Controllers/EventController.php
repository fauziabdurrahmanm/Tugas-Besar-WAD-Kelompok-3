<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category; // Wajib: Import Model Kategori
use App\Models\Venue;    // Wajib: Import Model Venue
use Illuminate\Support\Facades\Auth; // Untuk ambil ID user login
use Carbon\Carbon;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    /**
     * 1. INDEX: Menampilkan Halaman "Semua Event"
     */
    public function index(Request $request)
{

    // --- 1. LOGIKA KALENDER ---

    // Ambil bulan/tahun dari URL, atau pakai bulan sekarang jika kosong
    $date = $request->has('month')
            ? Carbon::createFromFormat('Y-m', $request->month)
            : Carbon::now();

    // Data untuk navigasi kalender (Prev/Next)
    $prevMonth = $date->copy()->subMonth()->format('Y-m');
    $nextMonth = $date->copy()->addMonth()->format('Y-m');
    $currentMonthName = $date->format('F Y');

    // Hitung struktur kalender
    $startOfMonth = $date->copy()->startOfMonth();
    $endOfMonth = $date->copy()->endOfMonth();

    // Ambil hari pertama bulan ini jatuh di hari apa? (0=Minggu, 1=Senin, dst)
    // Carbon default Sunday=0.
    $firstDayOfWeek = $startOfMonth->dayOfWeek;
    $daysInMonth = $date->daysInMonth;

    // Ambil Event KHUSUS bulan ini saja untuk ditampilkan di Kalender
    // Kita kelompokkan berdasarkan tanggal (format: '2025-12-25')
    $calendarEvents = Event::whereBetween('tanggal_event', [$startOfMonth, $endOfMonth])
                        ->get()
                        ->groupBy(function($item) {
                            return $item->tanggal_event; // Group by tanggal 'YYYY-MM-DD'
                        });
    // 1. Siapkan Query Dasar (Belum dieksekusi / get)
    $query = Event::with(['category', 'venue'])->latest();

    // 2. Logika Filter Kategori
    if ($request->has('category_id') && $request->category_id != '') {
        $query->where('category_id', $request->category_id);
    }

    // 3. Logika Pencarian (Search) - Bonus agar Search bar juga jalan
    if ($request->has('search') && $request->search != '') {
        $query->where('nama_event', 'like', '%' . $request->search . '%');
    }

    // 4. Eksekusi Query
    $events = $query->paginate(5);

    // 5. Ambil Data Kategori untuk isi Dropdown Filter
    $categories = Category::all();

    return view('events.index', compact(
        'events', 'categories', // Data Tabel
        'calendarEvents', 'firstDayOfWeek', 'daysInMonth', 'date', // Data Kalender
        'prevMonth', 'nextMonth', 'currentMonthName' // Navigasi Kalender
    ));

}


    /**
     * 2. CREATE: Menampilkan Halaman "Tambah Event"
     */
    public function create()
    {
        // Ambil data untuk isi Dropdown di Form
        $categories = Category::all(); // Mengambil semua kategori (Seminar, Workshop, dll)
        $venues = Venue::all();       // Mengambil semua data ruangan dari Anggota 1

        return view('events.create', compact('categories', 'venues'));
    }

    /**
     * 3. STORE: Menyimpan Data dari Form ke Database
     */
    public function store(Request $request)
    {
        // A. Validasi Input (Security Layer)
        $request->validate([
            'nama_event'    => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id', // Harus ada di tabel categories
            'venue_id'      => 'required|exists:venues,id',     // Harus ada di tabel venues
            'tanggal_event' => 'required|date',
            'deskripsi'     => 'nullable|string',
            // Field tambahan jika ada di migrasi database kamu
            // 'waktu'      => 'required',
            // 'durasi'     => 'numeric',
        ]);

        // B. Simpan ke Database
        Event::create([
            'nama_event'    => $request->nama_event,
            'category_id'   => $request->category_id,
            'venue_id'      => $request->venue_id, // Penting: Ini Foreign Key ke tabel Venue
            'tanggal_event' => $request->tanggal_event,
            'deskripsi'     => $request->deskripsi,
            'user_id'       => Auth::id() ?? 1, // ID Admin yang login (Default 1 jika belum login)
        ]);

        // C. Redirect Balik dengan Pesan Sukses
        return redirect()->route('events.index')
            ->with('success', 'Event berhasil ditambahkan!');
    }

    /**
     * 4. EDIT: Menampilkan Form Edit
     */
    public function edit(Event $event)
    {
        // Mirip create, tapi kita kirim data $event yang mau diedit
        $categories = Category::all();
        $venues = Venue::all();

        return view('events.edit', compact('event', 'categories', 'venues'));
    }

    /**
     * 5. UPDATE: Menyimpan Perubahan
     */
    public function update(Request $request, Event $event)
    {
        // Validasi
        $request->validate([
            'nama_event'    => 'required|max:255',
            'category_id'   => 'required',
            'venue_id'      => 'required',
            'tanggal_event' => 'required|date',
        ]);

        // Update Data
        $event->update($request->all());

        return redirect()->route('events.index')
            ->with('success', 'Data event berhasil diperbarui!');
    }

    /**
     * 6. DESTROY: Menghapus Data
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')
            ->with('success', 'Event berhasil dihapus.');
    }
}
