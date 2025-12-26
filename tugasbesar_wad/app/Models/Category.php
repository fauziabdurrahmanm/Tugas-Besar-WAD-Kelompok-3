<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // 1. Tentukan nama tabel (Opsional jika sesuai standar, tapi baik untuk kejelasan)
    protected $table = 'categories';

    // 2. Izinkan kolom mana saja yang boleh diisi (Mass Assignment)
    protected $fillable = ['nama_kategori'];

    // 3. Definisi Relasi: Satu Kategori punya BANYAK Event
    public function events()
    {
        return $this->hasMany(Event::class, 'category_id');
    }
}
