@extends('layouts.app')

@section('title', 'Pesan Tiket Kapal Laut Online - Tercepat & Teraman')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center text-white d-flex align-items-center">
    <div class="hero-overlay"></div>
    <div class="container hero-content py-5">
        <h1 class="hero-title text-white">Jelajahi Nusantara <br>dengan Kenyamanan Terbaik</h1>
        <p class="lead mb-4 text-white opacity-75 max-width-600 mx-auto">
            Temukan jadwal, bandingkan harga, dan pesan tiket kapal laut ke seluruh pelabuhan utama di Indonesia secara online, aman, dan instan.
        </p>
        <a href="#search-container" class="btn btn-custom btn-custom-primary btn-lg">
            <i class="fa-solid fa-compass me-2"></i> Cari Tiket Sekarang
        </a>
    </div>
</section>

<!-- Floating Search Card -->
<div class="container" id="search-container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card glass-panel search-form-card border-0 shadow-lg p-4 mb-5">
                <h4 class="mb-4 text-primary"><i class="fa-solid fa-magnifying-glass me-2"></i>Cari Jadwal & Tiket Kapal</h4>
                
                <form action="{{ route('jadwal') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="asal" class="form-label text-muted small fw-bold">Pelabuhan Asal</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fa-solid fa-ship"></i></span>
                                <select name="asal" id="asal" class="form-select form-select-custom border-start-0" required>
                                    <option value="" disabled selected>Pilih Pelabuhan Asal</option>
                                    @foreach($origins as $origin)
                                        <option value="{{ $origin }}">{{ $origin }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="tujuan" class="form-label text-muted small fw-bold">Pelabuhan Tujuan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fa-solid fa-location-dot"></i></span>
                                <select name="tujuan" id="tujuan" class="form-select form-select-custom border-start-0" required>
                                    <option value="" disabled selected>Pilih Pelabuhan Tujuan</option>
                                    @foreach($destinations as $dest)
                                        <option value="{{ $dest }}">{{ $dest }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="tanggal" class="form-label text-muted small fw-bold">Tanggal Keberangkatan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fa-solid fa-calendar-days"></i></span>
                                <input type="date" name="tanggal" id="tanggal" class="form-control form-control-custom border-start-0" min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-custom btn-custom-primary w-100 py-3">
                                <i class="fa-solid fa-circle-arrow-right me-2"></i> Cari Tiket
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Advantage Section -->
<section class="container py-5 mb-5">
    <div class="text-center mb-5">
        <h2 class="h1 mb-2">Mengapa Memilih Kami?</h2>
        <p class="text-muted">Layanan penyeberangan terbaik dengan jaminan keamanan dan kenyamanan perjalanan Anda.</p>
    </div>
    
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card glass-panel feature-card border-0 shadow-sm">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-ticket"></i>
                </div>
                <h5>Pemesanan Mudah</h5>
                <p class="small text-muted mb-0">Hanya butuh beberapa klik untuk mengamankan tiket perjalanan laut Anda.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card glass-panel feature-card border-0 shadow-sm">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h5>Pembayaran Aman</h5>
                <p class="small text-muted mb-0">Metode transaksi terenkripsi melalui bank transfer, e-wallet, dan QRIS.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card glass-panel feature-card border-0 shadow-sm">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-qrcode"></i>
                </div>
                <h5>E-Ticket Otomatis</h5>
                <p class="small text-muted mb-0">Tiket digital langsung terbit lengkap dengan QR Code unik setelah pembayaran diverifikasi.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card glass-panel feature-card border-0 shadow-sm">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h5>Layanan 24 Jam</h5>
                <p class="small text-muted mb-0">Hubungi tim customer support kami kapan saja Anda memerlukan bantuan perjalanan.</p>
            </div>
        </div>
    </div>
</section>
@endsection
