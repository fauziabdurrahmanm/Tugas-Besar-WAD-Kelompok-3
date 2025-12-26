<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'nama_event'    => $this->nama_event,
            'tanggal_event' => $this->tanggal_event, // Bisa di-format: date('d F Y', strtotime($this->tanggal_event))
            'deskripsi'     => $this->deskripsi,

            // Relasi: Kita ambil namanya saja, bukan ID-nya
            // Menggunakan $this->whenLoaded agar tidak error jika relasi belum di-load
            'kategori'      => $this->whenLoaded('category', function() {
                return $this->category->nama_kategori;
            }),

            'lokasi'        => $this->whenLoaded('venue', function() {
                return [
                    'nama_venue' => $this->venue->nama_venue,
                    'gedung'     => $this->venue->gedung,
                ];
            }),
        ];
    }
}
