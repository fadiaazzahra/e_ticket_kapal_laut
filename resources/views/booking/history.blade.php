@extends('layouts.app')

@section('title', 'Riwayat Pemesanan Tiket')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="h1">Riwayat Pemesanan</h2>
            <p class="text-muted">Cek status pemesanan, konfirmasi pembayaran, dan cetak e-ticket Anda.</p>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-md-end">
            <!-- Search Filter -->
            <form action="{{ route('booking.history') }}" method="GET" class="w-100 max-width-400">
                <div class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control form-control-custom" placeholder="Cari Kode Booking / Kapal..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-custom btn-custom-primary"><i class="fa-solid fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <!-- History List -->
    <div class="row">
        <div class="col-12">
            @if($pemesanans->isEmpty())
                <div class="card glass-panel border-0 p-5 text-center shadow-sm">
                    <i class="fa-solid fa-receipt text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-4">Belum Ada Pemesanan</h4>
                    <p class="text-muted mb-0">Anda belum melakukan pemesanan tiket kapal laut apa pun saat ini.</p>
                </div>
            @else
                <div class="d-flex flex-column gap-3">
                    @foreach($pemesanans as $p)
                        <div class="card glass-panel border-0 shadow-sm p-4">
                            <div class="row align-items-center g-3">
                                
                                <div class="col-md-3">
                                    <span class="text-muted small uppercase d-block mb-1">Kode Booking / Tanggal</span>
                                    <strong class="text-primary h5">{{ $p->kode_booking }}</strong>
                                    <div class="small text-muted mt-1">
                                        <i class="fa-regular fa-clock me-1"></i>
                                        {{ $p->created_at->format('d M Y, H:i') }}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <span class="text-muted small uppercase d-block mb-1">Kapal & Rute</span>
                                    <strong class="text-dark">{{ $p->jadwal->kapal->nama_kapal }}</strong>
                                    <div class="small text-muted mt-1">
                                        {{ $p->jadwal->asal }} → {{ $p->jadwal->tujuan }}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <span class="text-muted small uppercase d-block mb-1">Total Biaya</span>
                                    <strong class="text-success">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</strong>
                                    <div class="small text-muted mt-1">
                                        {{ $p->jumlah_penumpang }} Penumpang ({{ $p->jenis_kelas }})<br>
                                        <span class="text-primary fw-semibold" style="font-size: 0.75rem;">{{ $p->jenis_pengguna }}</span>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <span class="text-muted small uppercase d-block mb-1">Status Pemesanan</span>
                                    @if($p->status === 'pending')
                                        @if($p->pembayaran)
                                            <span class="badge badge-custom badge-pending"><i class="fa-solid fa-spinner fa-spin me-1"></i>Verifikasi Admin</span>
                                        @else
                                            <span class="badge badge-custom badge-pending"><i class="fa-solid fa-hourglass-start me-1"></i>Menunggu Bayar</span>
                                        @endif
                                    @elseif($p->status === 'paid')
                                        <span class="badge badge-custom badge-paid"><i class="fa-solid fa-circle-check me-1"></i>Lunas</span>
                                    @elseif($p->status === 'cancelled')
                                        <span class="badge badge-custom badge-cancelled"><i class="fa-solid fa-circle-xmark me-1"></i>Batal</span>
                                    @endif
                                </div>

                                <div class="col-md-2 text-md-end">
                                    @if($p->status === 'pending' && !$p->pembayaran)
                                        <a href="{{ route('booking.payment', $p->id_pemesanan) }}" class="btn btn-custom btn-custom-primary btn-sm w-100 py-2">
                                            <i class="fa-solid fa-wallet me-1"></i> Bayar
                                        </a>
                                    @elseif($p->status === 'paid')
                                        <a href="{{ route('booking.ticket', $p->kode_booking) }}" class="btn btn-custom btn-custom-outline btn-sm w-100 py-2">
                                            <i class="fa-solid fa-ticket me-1"></i> E-Ticket
                                        </a>
                                    @else
                                        <button class="btn btn-custom btn-custom-outline btn-sm w-100 py-2" disabled>
                                            <i class="fa-solid fa-circle-minus me-1"></i> Selesai
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
