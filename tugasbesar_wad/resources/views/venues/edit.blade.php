@extends('layouts.app')

@section('title')
<div class="d-flex align-items-center mb-0">
    <div>
        <h4 class="fw-bold text-dark mb-0">Manajemen Inventaris Tempat</h4>
        <h4 class="text-muted small mb-0" style="font-size: 15px;">
            Kelola ruangan dan fasilitas anda
        </h4>
    </div>

    <div class="ms-auto d-flex gap-2">
        <button class="btn btn-light btn-sm"><i class="fa-solid fa-share-nodes"></i></button>
        <button class="btn btn-light btn-sm"><i class="fa-regular fa-bell"></i></button>
        <button class="btn btn-light btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
</div>
@endsection

@include('venues.sidebar')

@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card border-0 shadow-sm rounded-4" style="width: 100%; max-width: 800px;">
        <div class="card-body p-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Edit Ruangan</h5>
                <span class="badge rounded-circle bg-primary p-2" style="background-color: #6366f1 !important;">
                    <i class="fa-solid fa-plus text-white"></i>
                </span>
            </div>

            <form action="{{ route('venues.update', $venue->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    {{-- Nama Ruangan --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Nama Ruangan</label>
                        <input type="text" name="nama_venue" class="form-control py-2" 
                               value="{{ $venue->nama_venue }}" placeholder="Enter room name" required>
                    </div>

                    {{-- Bangunan --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Bangunan</label>
                        <input type="text" name="gedung" class="form-control py-2" 
                               value="{{ $venue->gedung }}" placeholder="Enter building name" required>
                    </div>

                    {{-- Provinsi --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Provinsi</label>
                        <select name="provinsi_id" id="provinsi" class="form-select py-2" required>
                            <option value="">Choose province</option>
                        </select>
                    </div>

                    {{-- Kota --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Kota</label>
                        <select name="kota_id" id="kota" class="form-select py-2" required>
                            <option value="">Choose city</option>
                        </select>
                    </div>

                    {{-- Daerah --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Daerah</label>
                        <select name="kecamatan_id" id="kecamatan" class="form-select py-2" required>
                            <option value="">Choose district</option>
                        </select>
                    </div>

                    {{-- Kapasitas --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Kapasitas</label>
                        <input type="number" name="kapasitas" class="form-control py-2" 
                               value="{{ $venue->kapasitas }}" placeholder="Enter capacity" required>
                    </div>

                    {{-- Fasilitas --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Fasilitas</label>
                        <input type="text" name="fasilitas" class="form-control py-2" 
                               value="{{ $venue->fasilitas }}" placeholder="e.g., WiFi, Projector, AC">
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="col-12 text-end mt-5">
                        <a href="{{ route('venues.index') }}" class="btn btn-outline-secondary px-4 me-2 border-0 bg-light text-dark">Cancel</a>
                        <button type="submit" class="btn px-4 text-white shadow-sm" style="background-color: #00bfd8;">
                            Edit Ruangan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const provinceSelect = document.getElementById('provinsi');
    const citySelect = document.getElementById('kota');
    const districtSelect = document.getElementById('kecamatan');

    // Data lama dari database (old values)
    const oldProvince = "{{ $venue->provinsi_id }}";
    const oldCity = "{{ $venue->kota_id }}";
    const oldDistrict = "{{ $venue->kecamatan_id }}";

    // 1. Load Provinsi
    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json`)
        .then(response => response.json())
        .then(provinces => {
            provinces.forEach(p => {
                let opt = new Option(p.name, p.id);
                if(p.id == oldProvince) opt.selected = true;
                provinceSelect.add(opt);
            });
            if(oldProvince) provinceSelect.dispatchEvent(new Event('change'));
        });

    // 2. Load Kota
    provinceSelect.addEventListener('change', function() {
        citySelect.innerHTML = '<option value="">Choose city</option>';
        districtSelect.innerHTML = '<option value="">Choose district</option>';
        if (this.value) {
            fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${this.value}.json`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(r => {
                        let opt = new Option(r.name, r.id);
                        if(r.id == oldCity) opt.selected = true;
                        citySelect.add(opt);
                    });
                    if(oldCity) citySelect.dispatchEvent(new Event('change'));
                });
        }
    });

    // 3. Load Kecamatan
    citySelect.addEventListener('change', function() {
        districtSelect.innerHTML = '<option value="">Choose district</option>';
        if (this.value) {
            fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${this.value}.json`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(d => {
                        let opt = new Option(d.name, d.id);
                        if(d.id == oldDistrict) opt.selected = true;
                        districtSelect.add(opt);
                    });
                });
        }
    });
</script>
@endsection