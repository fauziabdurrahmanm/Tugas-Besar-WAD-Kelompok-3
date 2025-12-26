<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    // Agar aman, kita kunci kolom 'id', sisanya boleh diisi
    protected $guarded = ['id'];

    // --- DEFINISI RELASI (PENTING UNTUK RUBRIK 40%) ---

    // 1. Event "Milik" satu Kategori (Inverse One-to-Many)
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // 2. Event "Memakai" satu Venue
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    // 3. Event "Dibuat Oleh" satu User (Admin)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
