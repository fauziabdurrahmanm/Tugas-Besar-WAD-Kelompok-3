<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $table = 'Kota';

    protected $fillable = ['nama_kota', 'provinsi_id'];
}
