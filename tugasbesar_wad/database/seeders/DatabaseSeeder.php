<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Venue;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat User Admin (Agar bisa login/disimpan di event)
        User::create([
            'name' => 'Admin Kampus',
            'email' => 'admin@telkomuniversity.ac.id',
            'password' => bcrypt('password'), // passwordnya: password
            'role' => 'admin'
        ]);

        // 2. Isi Data Kategori (Dropdown Kategori)
        Category::insert([
            ['nama_kategori' => 'Seminar Nasional'],
            ['nama_kategori' => 'Workshop / Pelatihan'],
            ['nama_kategori' => 'Lomba / Kompetisi'],
            ['nama_kategori' => 'Rapat Organisasi'],
            ['nama_kategori' => 'Pentas Seni'],
        ]);

        // 3. Isi Data Venue (Dropdown Lokasi - Tugas Anggota 1)
        Venue::insert([
            [
                'nama_venue' => 'Auditorium Gd. K',
                'gedung' => 'Gedung K',
                'kapasitas' => 500,
                'fasilitas' => 'AC, Sound System, Proyektor Besar',
                'provinsi_id' => '32', // Jawa Barat
                'kota_id' => '3204',   // Kab. Bandung
                'kecamatan_id' => '3204050' // Bojongsoang
            ],
            [
                'nama_venue' => 'Lab Komputer Dasar',
                'gedung' => 'Gedung Tokong Nanas',
                'kapasitas' => 40,
                'fasilitas' => '40 PC, AC, Whiteboard',
                'provinsi_id' => '32',
                'kota_id' => '3204',
                'kecamatan_id' => '3204050'
            ],
        ]);
    }
}
