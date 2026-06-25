@extends('layouts.admin')

@section('title', 'Kelola Pemesanan')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-0 text-dark">Kelola Data Pemesanan</h4>
        <p class="text-muted small mb-0">Lihat semua transaksi, rincian penumpang, serta kelola status pemesanan tiket kapal.</p>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="admin-card">
            @if($pemesanans->isEmpty())
                <div class="text-center py-4 text-muted">
                    Belum ada data pemesanan tiket.
                </div>
            @else
                <div class="table-responsive table-responsive-custom">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>Kode Booking</th>
                                <th>Nama Penumpang</th>
                                <th>Detail Kapal & Rute</th>
                                <th>Kelas / Jumlah</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pemesanans as $p)
                                <tr>
                                    <td class="fw-bold text-primary">{{ $p->kode_booking }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $p->nama_lengkap }}</div>
                                        <small class="text-muted">NIK: {{ $p->nik }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $p->jadwal->kapal->nama_kapal }}</div>
                                        <small class="text-muted">{{ $p->jadwal->asal }} → {{ $p->jadwal->tujuan }}</small>
                                    </td>
                                    <td>
                                        <div><span class="badge bg-primary">{{ $p->jenis_kelas }}</span></div>
                                        <small class="text-muted">{{ $p->jumlah_penumpang }} Orang</small>
                                    </td>
                                    <td class="fw-bold text-success">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        @if($p->status === 'pending')
                                            <span class="badge badge-custom badge-pending">Pending</span>
                                        @elseif($p->status === 'paid')
                                            <span class="badge badge-custom badge-paid">Lunas</span>
                                        @elseif($p->status === 'cancelled')
                                            <span class="badge badge-custom badge-cancelled">Batal</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-custom btn-custom-outline py-1 px-2" data-bs-toggle="modal" data-bs-target="#detailPemesananModal-{{ $p->id_pemesanan }}">
                                            <i class="fa-solid fa-eye me-1"></i> Detail
                                        </button>
                                    </td>
                                </tr>

                                <!-- DETAIL MODAL -->
                                <div class="modal fade" id="detailPemesananModal-{{ $p->id_pemesanan }}" tabindex="-1" aria-labelledby="detailModalLabel-{{ $p->id_pemesanan }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content glass-panel border-0 text-dark">
                                            <div class="modal-header border-bottom-0">
                                                <h5 class="modal-title" id="detailModalLabel-{{ $p->id_pemesanan }}"><i class="fa-solid fa-ticket me-2 text-primary"></i>Rincian Pemesanan Tiket</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3 d-flex justify-content-between border-bottom pb-2">
                                                    <span class="text-muted small">Kode Booking:</span>
                                                    <strong class="text-primary">{{ $p->kode_booking }}</strong>
                                                </div>
                                                <div class="mb-3 d-flex justify-content-between border-bottom pb-2">
                                                    <span class="text-muted small">Dipesan Oleh:</span>
                                                    <strong class="text-dark">{{ $p->user->name }} ({{ $p->user->email }})</strong>
                                                </div>
                                                <h6 class="fw-bold text-primary mt-4 mb-3"><i class="fa-solid fa-user me-2"></i>Data Penumpang Utama</h6>
                                                <div class="mb-2">
                                                    <span class="text-muted small d-block">Nama Lengkap:</span>
                                                    <strong class="text-dark">{{ $p->nama_lengkap }}</strong>
                                                </div>
                                                <div class="mb-2">
                                                    <span class="text-muted small d-block">NIK (No. KTP):</span>
                                                    <strong class="text-dark">{{ $p->nik }}</strong>
                                                </div>
                                                <div class="mb-2">
                                                    <span class="text-muted small d-block">Nomor HP / WhatsApp:</span>
                                                    <strong class="text-dark">{{ $p->no_hp }}</strong>
                                                </div>
                                                <div class="mb-2">
                                                    <span class="text-muted small d-block">Alamat Email:</span>
                                                    <strong class="text-dark">{{ $p->email }}</strong>
                                                </div>
                                                <div class="mb-2">
                                                    <span class="text-muted small d-block">Jenis Pengguna:</span>
                                                    <strong class="text-primary">{{ $p->jenis_pengguna }}</strong>
                                                </div>

                                                <h6 class="fw-bold text-primary mt-4 mb-3"><i class="fa-solid fa-ship me-2"></i>Informasi Pelayaran</h6>
                                                <div class="mb-2">
                                                    <span class="text-muted small d-block">Nama Kapal & Kelas:</span>
                                                    <strong class="text-dark">{{ $p->jadwal->kapal->nama_kapal }} ({{ $p->jenis_kelas }})</strong>
                                                </div>
                                                <div class="mb-2">
                                                    <span class="text-muted small d-block">Rute Pelabuhan:</span>
                                                    <strong class="text-dark">{{ $p->jadwal->asal }} → {{ $p->jadwal->tujuan }}</strong>
                                                </div>
                                                <div class="mb-2">
                                                    <span class="text-muted small d-block">Waktu Keberangkatan:</span>
                                                    <strong class="text-dark">{{ Carbon\Carbon::parse($p->jadwal->tanggal)->translatedFormat('d F Y') }}, {{ Carbon\Carbon::parse($p->jadwal->jam_berangkat)->format('H:i') }} WIB</strong>
                                                </div>

                                                <h6 class="fw-bold text-primary mt-4 mb-3"><i class="fa-solid fa-wallet me-2"></i>Rincian Pembayaran</h6>
                                                <div class="mb-2 d-flex justify-content-between">
                                                    <span class="text-muted small">Status Transaksi:</span>
                                                    @if($p->status === 'pending')
                                                        <span class="badge badge-custom badge-pending">Pending</span>
                                                    @elseif($p->status === 'paid')
                                                        <span class="badge badge-custom badge-paid">Lunas</span>
                                                    @elseif($p->status === 'cancelled')
                                                        <span class="badge badge-custom badge-cancelled">Batal</span>
                                                    @endif
                                                </div>
                                                <div class="mb-2 d-flex justify-content-between">
                                                    <span class="text-muted small">Total Biaya ({{ $p->jumlah_penumpang }} Orang):</span>
                                                    <strong class="text-success h5">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</strong>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top-0">
                                                <button type="button" class="btn btn-custom btn-custom-outline py-2" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
