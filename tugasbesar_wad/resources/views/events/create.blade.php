@extends('layouts.app')

<head><title>Vettix - Tambah Event</title></head>
@section('title')
<div class="mb-0">
        <h4 class="fw-bold text-dark mb-1">Tambahkan Event Baru</h4>
        <h4 class="text-muted small" style="font-size: 15px; height: 7px;">Buat dan jadwalkan event baru</h4>
    </div>
@endsection
@include('events.sidebar')
@section('content')
<div class="container-fluid px-0">

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">

            <form action="{{ route('events.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold small">Nama Event</label>
                    <input type="text" name="nama_event" class="form-control" placeholder="Masukkan nama event" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Kategori</label>
                    <div class="input-group">
                        <select name="category_id" class="form-select">
                            <option selected disabled>Pilih Kategori...</option>
                             @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                             @endforeach
                        </select>
                        <span class="input-group-text bg-white"><i class="fa-solid fa-chevron-down"></i></span>
                    </div>
                </div>

                <div class="row align-items-center mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Tanggal Event</label>
                        <div class="input-group">
                            <input type="date" id="tanggal_event" name="tanggal_event" class="form-control" placeholder="dd/mm/yyyy">

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div id="holiday-alert" class="alert alert-danger d-none d-flex align-items-center p-2 mb-0"
                            style="background-color: #fee2e2; border-color: #fecaca; color: #991b1b; margin-top: 30px;">

                            <i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i>

                            <div style="line-height: 1.2;">
                                <strong style="font-size: 0.85rem;">Warning</strong><br>
                                <span style="font-size: 0.75rem;">Tanggal yang dipilih adalah hari libur nasional</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Deskripsi Event</label>
                    <textarea name="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi event..."></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold small">Waktu Event</label>
                        <div class="input-group">
                            <input type="text" name="waktu" class="form-control" placeholder="--:--">
                            <span class="input-group-text bg-white"><i class="fa-regular fa-clock"></i></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Durasi (jam)</label>
                        <input type="number" name="durasi" class="form-control" placeholder="">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small">Lokasi (Venue Kampus)</label>
                    <div class="input-group">
                        <select name="venue_id" class="form-select">
                            <option selected disabled>Pilih Ruangan...</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}">{{ $venue->nama_venue }} - Kapasitas: {{ $venue->kapasitas }}</option>
                            @endforeach
                        </select>
                        <span class="input-group-text bg-white"><i class="fa-solid fa-building"></i></span>
                    </div>
                    <div class="form-text text-muted">Data ruangan diambil dari database Anggota 1</div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary px-4 fw-bold">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 fw-bold" style="background-color: #2563eb; border: none;">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Save
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('tanggal_event').addEventListener('change', async function() {
        // 1. Ambil tanggal yang dipilih user
        const selectedDate = this.value; // Format: YYYY-MM-DD
        const alertBox = document.getElementById('holiday-alert');
        const holidayNameSpan = document.getElementById('holiday-name'); // Pastikan span ini ada ID-nya di HTML

        if (!selectedDate) return;

        // Ambil Tahun dari tanggal yang dipilih (misal: 2025)
        const year = selectedDate.split('-')[0];

        try {
            // 2. TEMBAK API EKSTERNAL (Konsumsi API)
            // Kita ambil data libur untuk tahun tersebut
            const response = await fetch(`https://dayoffapi.vercel.app/api`);
            const data = await response.json();

            // 3. Cek apakah tanggal yang dipilih ada di daftar libur?
            // API mengembalikan array, kita cari yang tanggalnya sama
            const isHoliday = data.find(holiday => holiday.tanggal === selectedDate);

            if (isHoliday) {
                // JIKA LIBUR: Munculkan Alert & Tampilkan Nama Liburnya
                alertBox.classList.remove('d-none');

                // Cari elemen teks warning di HTML Anda dan update isinya
                // Kita update teks "Warning" atau span di sebelahnya
                // Pastikan struktur HTML alert Anda mendukung ini
                const textContainer = alertBox.querySelector('span') || alertBox.querySelector('div');
                if(textContainer) {
                    textContainer.innerHTML = `<strong>Stop!</strong> Tanggal ini adalah <u>${isHoliday.keterangan}</u>.`;
                }

            } else {
                // JIKA TIDAK LIBUR: Sembunyikan Alert
                alertBox.classList.add('d-none');
            }

        } catch (error) {
            console.error("Gagal mengambil data hari libur:", error);
        }
    });
</script>
@endsection
