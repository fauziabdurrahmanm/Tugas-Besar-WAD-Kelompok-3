<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator; // Import untuk pagination manual

class ReviewController extends Controller
{
    public function index()
    {
        // 1. KITA BUAT DUMMY DATA (DATA PALSU) DI SINI
        // Karena tidak pakai database, kita tulis manual array-nya.
        $dummyData = [
            [
                'id' => 1,
                'participant_name' => 'Budi Santoso',
                'rating' => 5,
                'komentar' => 'Acaranya sangat keren! Narasumber sangat menguasai materi. Makanannya juga enak.',
                'is_published' => true,
                'created_at' => now()->subDays(1),
            ],
            [
                'id' => 2,
                'participant_name' => 'Siti Aminah',
                'rating' => 4,
                'komentar' => 'Materinya bagus, tapi AC di ruangan agak terlalu dingin. Mohon diperbaiki untuk next event.',
                'is_published' => true,
                'created_at' => now()->subDays(2),
            ],
            [
                'id' => 3,
                'participant_name' => 'Joko Anwar',
                'rating' => 3,
                'komentar' => 'Cukup oke, tapi sertifikatnya agak lama keluarnya ya?',
                'is_published' => false, // Contoh status Hidden
                'created_at' => now()->subDays(5),
            ],
            [
                'id' => 4,
                'participant_name' => 'Rina Nose',
                'rating' => 5,
                'komentar' => 'Mantap betul! Ditunggu event selanjutnya.',
                'is_published' => true,
                'created_at' => now()->subWeeks(1),
            ],
            [
                'id' => 5,
                'participant_name' => 'Doni Salmanan',
                'rating' => 1,
                'komentar' => 'Parkirannya susah banget penuh.',
                'is_published' => false,
                'created_at' => now()->subWeeks(2),
            ],
        ];

        // 2. MENGUBAH ARRAY JADI OBJECT (Agar bisa dipanggil $review->nama di view)
        // Sekaligus kita generate link Avatar di sini karena tidak pakai Model
        $reviewsCollection = collect($dummyData)->map(function ($item) {
            $obj = (object) $item;
            // Generate Avatar URL Manual
            $name = urlencode($obj->participant_name);
            $obj->avatar_url = "https://ui-avatars.com/api/?name={$name}&background=random&color=fff&rounded=true";
            return $obj;
        });

        // 3. MEMBUAT PAGINATION PALSU (Agar tampilan {{ $links }} di bawah tidak error)
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $reviewsCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        
        $reviews = new LengthAwarePaginator($currentItems, count($reviewsCollection), $perPage);
        $reviews->setPath(request()->url());

        // Hitung rata-rata rating manual
        $avgRating = $reviewsCollection->avg('rating');

        return view('reviews.index', compact('reviews', 'avgRating'));
    }

    // Fungsi Toggle (Hanya Simulasi)
    public function toggleStatus($id)
    {
        // Karena tidak ada database, kita hanya kembalikan pesan sukses simulasi
        return redirect()->back()->with('success', 'Simulasi: Status review berhasil diubah (Data asli tidak berubah karena tanpa DB).');
    }

    // Fungsi Delete (Hanya Simulasi)
    public function destroy($id)
    {
        // Karena tidak ada database, kita hanya kembalikan pesan sukses simulasi
        return redirect()->back()->with('success', 'Simulasi: Review berhasil dihapus dari tampilan sementara.');
    }
}