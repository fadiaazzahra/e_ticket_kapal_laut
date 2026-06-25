@extends('layouts.admin')

@section('title', 'Dashboard Panel Admin')

@section('content')
<!-- Metric Stats Section -->
<div class="row g-3 mb-4">
    <!-- Stat 1 -->
    <div class="col-xl-3 col-md-6">
        <div class="admin-card stat-box mb-0">
            <div>
                <span class="text-muted small uppercase fw-bold">Total Pendapatan</span>
                <h3 class="fw-bold text-success mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
            <div class="stat-icon bg-success bg-opacity-10 text-success">
                <i class="fa-solid fa-money-bill-trend-up"></i>
            </div>
        </div>
    </div>
    <!-- Stat 2 -->
    <div class="col-xl-3 col-md-6">
        <div class="admin-card stat-box mb-0">
            <div>
                <span class="text-muted small uppercase fw-bold">Tiket Terjual</span>
                <h3 class="fw-bold text-primary mt-1">{{ number_format($totalTiketTerjual, 0, ',', '.') }}</h3>
            </div>
            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                <i class="fa-solid fa-ticket-simple"></i>
            </div>
        </div>
    </div>
    <!-- Stat 3 -->
    <div class="col-xl-3 col-md-6">
        <div class="admin-card stat-box mb-0">
            <div>
                <span class="text-muted small uppercase fw-bold">Jumlah Kapal</span>
                <h3 class="fw-bold text-info mt-1">{{ $totalKapal }} Kapal</h3>
            </div>
            <div class="stat-icon bg-info bg-opacity-10 text-info">
                <i class="fa-solid fa-ship"></i>
            </div>
        </div>
    </div>
    <!-- Stat 4 -->
    <div class="col-xl-3 col-md-6">
        <div class="admin-card stat-box mb-0">
            <div>
                <span class="text-muted small uppercase fw-bold">Pengguna Terdaftar</span>
                <h3 class="fw-bold text-warning mt-1">{{ $totalUser }} User</h3>
            </div>
            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                <i class="fa-solid fa-user-group"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-4 mb-4">
    <!-- Chart 1: Sales by Ship -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <h5 class="mb-4"><i class="fa-solid fa-chart-pie me-2 text-primary"></i>Penjualan Tiket per Kapal</h5>
            <div style="position: relative; height:300px;">
                <canvas id="shipSalesChart"></canvas>
            </div>
        </div>
    </div>
    <!-- Chart 2: Revenue Trend -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <h5 class="mb-4"><i class="fa-solid fa-chart-line me-2 text-primary"></i>Tren Penjualan 7 Hari Terakhir</h5>
            <div style="position: relative; height:300px;">
                <canvas id="revenueTrendChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions Section -->
<div class="row">
    <div class="col-12">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Pemesanan Terbaru</h5>
                <a href="{{ route('admin.pemesanans') }}" class="btn btn-sm btn-custom btn-custom-outline py-1 px-3">Lihat Semua</a>
            </div>

            @if($recentBookings->isEmpty())
                <div class="text-center py-4">
                    <span class="text-muted">Tidak ada transaksi terbaru.</span>
                </div>
            @else
                <div class="table-responsive table-responsive-custom">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>Kode Booking</th>
                                <th>Penumpang</th>
                                <th>Kapal & Rute</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentBookings as $b)
                                <tr>
                                    <td class="fw-bold text-primary">{{ $b->kode_booking }}</td>
                                    <td>{{ $b->nama_lengkap }}</td>
                                    <td>
                                        <span class="fw-bold">{{ $b->jadwal->kapal->nama_kapal }}</span><br>
                                        <small class="text-muted">{{ $b->jadwal->asal }} → {{ $b->jadwal->tujuan }}</small>
                                    </td>
                                    <td class="fw-bold text-success">Rp {{ number_format($b->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        @if($b->status === 'pending')
                                            <span class="badge badge-custom badge-pending">Pending</span>
                                        @elseif($b->status === 'paid')
                                            <span class="badge badge-custom badge-paid">Lunas</span>
                                        @elseif($b->status === 'cancelled')
                                            <span class="badge badge-custom badge-cancelled">Batal</span>
                                        @endif
                                    </td>
                                    <td class="small text-muted">{{ $b->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Load Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Data for Ship Sales Chart
        const shipLabels = [
            @foreach($salesByShip as $s)
                "{{ $s->nama_kapal }}",
            @endforeach
        ];
        
        const shipSalesData = [
            @foreach($salesByShip as $s)
                {{ $s->total_sold }},
            @endforeach
        ];

        // 1. Render Ship Sales Chart (Doughnut)
        const ctxShip = document.getElementById('shipSalesChart').getContext('2d');
        new Chart(ctxShip, {
            type: 'doughnut',
            data: {
                labels: shipLabels.length ? shipLabels : ['Belum ada data'],
                datasets: [{
                    label: 'Tiket Terjual',
                    data: shipSalesData.length ? shipSalesData : [0],
                    backgroundColor: [
                        '#0284c7',
                        '#06b6d4',
                        '#10b981',
                        '#f59e0b',
                        '#ec4899'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#64748b',
                            font: { family: 'Plus Jakarta Sans' }
                        }
                    }
                }
            }
        });

        // Data for Daily Revenue Chart
        const dailyLabels = [
            @foreach($dailyRevenue as $d)
                "{{ Carbon\Carbon::parse($d->date)->format('d M') }}",
            @endforeach
        ];

        const dailyRevenueData = [
            @foreach($dailyRevenue as $d)
                {{ $d->revenue }},
            @endforeach
        ];

        // 2. Render Daily Revenue Chart (Line)
        const ctxRev = document.getElementById('revenueTrendChart').getContext('2d');
        new Chart(ctxRev, {
            type: 'line',
            data: {
                labels: dailyLabels.length ? dailyLabels : ['Belum ada data'],
                datasets: [{
                    label: 'Pendapatan (IDR)',
                    data: dailyRevenueData.length ? dailyRevenueData : [0],
                    borderColor: '#0284c7',
                    backgroundColor: 'rgba(2, 132, 199, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#64748b',
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: {
                            color: 'rgba(148, 163, 184, 0.1)'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#64748b'
                        },
                        grid: {
                            color: 'rgba(148, 163, 184, 0.1)'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
