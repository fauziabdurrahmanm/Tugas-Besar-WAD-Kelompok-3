<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'Kecamatan';

    protected $fillable = ['nama_kecamatan', 'kota_id'];
}
