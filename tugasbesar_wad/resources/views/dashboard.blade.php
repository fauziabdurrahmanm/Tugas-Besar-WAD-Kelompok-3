@extends('layouts.app')

@section('title', 'Dashboard Utama')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Kegiatan</h5>
                <p class="card-text display-4">12</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Ruangan Terpakai</h5>
                <p class="card-text display-4">5</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Peserta Terdaftar</h5>
                <p class="card-text display-4">150</p>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header bg-white fw-bold">Grafik Aktivitas Kampus</div>
    <div class="card-body text-center py-5">
        <p class="text-muted">-- Placeholder Grafik--</p>
    </div>
</div>
@endsection
