<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'participant_name', 'komentar', 'rating', 'is_published'];

    // Ini adalah 'Virtual Attribute' sesuai proposal untuk API UI Avatars
    // Cara panggil di view nanti: $review->avatar_url
    public function getAvatarUrlAttribute()
    {
        // Menggunakan layanan UI Avatars API
        $name = urlencode($this->participant_name);
        return "https://ui-avatars.com/api/?name={$name}&background=random&color=fff&rounded=true";
    }
}