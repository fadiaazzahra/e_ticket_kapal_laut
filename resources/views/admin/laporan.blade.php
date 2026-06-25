@extends('layouts.admin')

@section('title', 'Laporan Penjualan Tiket')

@section('content')
<!-- Filter Panel -->
<div class="row mb-4 btn-print-hide">
    <div class="col-12">
        <div class="admin-card">
            <h5 class="mb-3"><i class="fa-solid fa-filter me-2 text-primary"></i>Filter Laporan Penjualan</h5>
            
            <form action="{{ route('admin.laporan') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label fw-bold small text-muted">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="form-control form-control-custom" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label fw-bold small text-muted">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" class="form-control form-control-custom" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-custom btn-custom-primary flex-grow-1 py-2">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> Tampilkan
                        </button>
                        <!-- Excel Export -->
                        <a href="{{ route('admin.laporan.export') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" class="btn btn-custom btn-success py-2 px-3" title="Ekspor ke Excel (CSV)">
                            <i class="fa-solid fa-file-excel"></i> Export Excel
                        </a>
                        <!-- Print PDF -->
                        <button type="button" onclick="window.print()" class="btn btn-custom btn-custom-outline py-2 px-3" title="Cetak Laporan">
                            <i class="fa-solid fa-print"></i> Cetak PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Report Summary cards (Print visible) -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="admin-card stat-box bg-white border shadow-sm">
            <div>
                <span class="text-muted small uppercase fw-bold">Total Pendapatan Terfilter</span>
                <h3 class="fw-bold text-success mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <span class="small text-muted">Periode: {{ Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</span>
            </div>
            <div class="stat-icon bg-success bg-opacity-10 text-success btn-print-hide">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-card stat-box bg-white border shadow-sm">
            <div>
                <span class="text-muted small uppercase fw-bold">Total Tiket Terjual Terfilter</span>
                <h3 class="fw-bold text-primary mt-1">{{ number_format($totalTickets) }} Tiket</h3>
                <span class="small text-muted">Untuk penyeberangan status Lunas</span>
            </div>
            <div class="stat-icon bg-primary bg-opacity-10 text-primary btn-print-hide">
                <i class="fa-solid fa-ticket"></i>
            </div>
        </div>
    </div>
</div>

<!-- Laporan Table -->
<div class="row">
    <div class="col-12">
        <div class="admin-card">
            <!-- Header printed only on PDF -->
            <div class="d-none d-print-block text-center mb-4">
                <h3 class="fw-bold mb-1">LAPORAN PENJUALAN TIKET KAPAL LAUT</h3>
                <h5 class="text-muted mb-0">BahariLines Ticketing System</h5>
                <p class="small text-muted mt-2">Periode: {{ Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} s/d {{ Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
                <hr>
            </div>

            <h5 class="mb-3 btn-print-hide"><i class="fa-solid fa-table me-2 text-primary"></i>Rincian Transaksi Penjualan</h5>

            @if($pemesanans->isEmpty())
                <div class="text-center py-4 text-muted">
                    Tidak ada transaksi penjualan tiket pada periode terfilter.
                </div>
            @else
                <div class="table-responsive table-responsive-custom">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>Kode Booking</th>
                                <th>Tanggal Lunas</th>
                                <th>Nama Penumpang</th>
                                <th>Kapal & Kelas</th>
                                <th>Rute Penyeberangan</th>
                                <th class="text-center">Tiket</th>
                                <th class="text-end">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pemesanans as $p)
                                <tr>
                                    <td class="fw-bold text-primary">{{ $p->kode_booking }}</td>
                                    <td>{{ $p->updated_at->format('d/m/Y H:i') }}</td>
                                    <td class="fw-semibold">{{ $p->nama_lengkap }}</td>
                                    <td>{{ $p->jadwal->kapal->nama_kapal }} ({{ $p->jenis_kelas }})</td>
                                    <td>{{ $p->jadwal->asal }} → {{ $p->jadwal->tujuan }}</td>
                                    <td class="text-center">{{ $p->jumlah_penumpang }}</td>
                                    <td class="fw-bold text-success text-end">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold bg-light">
                                <td colspan="5" class="text-end py-3">GRAND TOTAL :</td>
                                <td class="text-center py-3">{{ $totalTickets }}</td>
                                <td class="text-end text-success py-3">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Laporan Print style adjustments */
@media print {
    .navbar-custom, .admin-sidebar, .btn-print-hide, .admin-content > div:first-of-type {
        display: none !important;
    }
    .admin-content {
        padding: 0 !important;
    }
    .admin-card {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
    }
    body {
        background-color: white !important;
        color: black !important;
    }
    table {
        border: 1px solid #ddd !important;
    }
    th, td {
        border-bottom: 1px solid #ddd !important;
        padding: 8px !important;
    }
}
</style>
@endsection
