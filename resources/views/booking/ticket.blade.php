@extends('layouts.app')

@section('title', 'E-Ticket Digital: ' . $pemesanan->kode_booking)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <!-- Actions buttons header -->
            <div class="d-flex justify-content-between align-items-center mb-4 btn-print-hide">
                <a href="{{ route('booking.history') }}" class="btn btn-custom btn-custom-outline">
                    <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Riwayat
                </a>
                <button onclick="window.print()" class="btn btn-custom btn-custom-primary">
                    <i class="fa-solid fa-print me-2"></i> Cetak / Simpan PDF
                </button>
            </div>

            <!-- E-Ticket Card -->
            <div class="ticket-container card border-0 shadow-lg">
                <!-- Ticket Header -->
                <div class="ticket-header">
                    <div class="logo-container">
                        <i class="fa-solid fa-ship"></i>
                    </div>
                    <h3 class="mb-1 text-white">BOARDING PASS</h3>
                    <p class="mb-0 text-white opacity-75 small">E-TICKET RESMI PENYEBERANGAN LAUT</p>
                </div>

                <!-- Ticket Body -->
                <div class="ticket-body">
                    <div class="row g-4">
                        <!-- Left Side Info -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-6 ticket-info-row">
                                    <div class="ticket-label">Kode Booking</div>
                                    <div class="ticket-value text-primary">{{ $pemesanan->kode_booking }}</div>
                                </div>
                                <div class="col-6 ticket-info-row">
                                    <div class="ticket-label">Nama Penumpang</div>
                                    <div class="ticket-value">{{ $pemesanan->nama_lengkap }}</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 ticket-info-row">
                                    <div class="ticket-label">NIK</div>
                                    <div class="ticket-value">{{ $pemesanan->nik }}</div>
                                </div>
                                <div class="col-6 ticket-info-row">
                                    <div class="ticket-label">Kelas Tiket</div>
                                    <div class="ticket-value"><span class="badge bg-primary">{{ $pemesanan->jenis_kelas }}</span></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 ticket-info-row">
                                    <div class="ticket-label">Kapal</div>
                                    <div class="ticket-value">{{ $pemesanan->jadwal->kapal->nama_kapal }}</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 ticket-info-row">
                                    <div class="ticket-label">Pelabuhan Asal</div>
                                    <div class="ticket-value text-danger">{{ $pemesanan->jadwal->asal }}</div>
                                </div>
                                <div class="col-6 ticket-info-row">
                                    <div class="ticket-label">Pelabuhan Tujuan</div>
                                    <div class="ticket-value text-success">{{ $pemesanan->jadwal->tujuan }}</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 ticket-info-row">
                                    <div class="ticket-label">Tanggal Keberangkatan</div>
                                    <div class="ticket-value">{{ Carbon\Carbon::parse($pemesanan->jadwal->tanggal)->translatedFormat('d F Y') }}</div>
                                </div>
                                <div class="col-6 ticket-info-row">
                                    <div class="ticket-label">Jam Keberangkatan</div>
                                    <div class="ticket-value">{{ Carbon\Carbon::parse($pemesanan->jadwal->jam_berangkat)->format('H:i') }} WIB</div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side QR Code (Desktop only/aligned) -->
                        <div class="col-md-4 d-flex flex-column align-items-center justify-content-center text-center border-start border-light-subtle ps-md-4">
                            <div class="p-2 bg-white rounded border mb-2">
                                <canvas id="qr-code"></canvas>
                            </div>
                            <div class="small text-muted">Scan QR saat check-in di pelabuhan untuk mencetak boarding pass fisik.</div>
                        </div>
                    </div>
                </div>

                <!-- Ticket Footer -->
                <div class="ticket-footer">
                    <div class="row text-center text-md-start align-items-center g-3">
                        <div class="col-md-8">
                            <h6 class="mb-1 fw-bold text-dark"><i class="fa-solid fa-circle-exclamation text-warning me-1"></i>Informasi Penting:</h6>
                            <ul class="small text-muted mb-0 ps-3">
                                <li>Tunjukkan E-Ticket ini beserta KTP/SIM asli saat check-in.</li>
                                <li>Check-in ditutup 60 menit sebelum keberangkatan kapal.</li>
                                <li>Dilarang membawa barang-barang berbahaya & terlarang.</li>
                            </ul>
                        </div>
                        <div class="col-md-4 text-center text-md-end">
                            <div class="small text-muted">Status Boarding</div>
                            <div class="h5 fw-bold text-success"><i class="fa-solid fa-circle-check me-1"></i>SIAP JALAN</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Load QRious Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Generate QR code for ticket details
        var qr = new QRious({
            element: document.getElementById('qr-code'),
            value: '{{ $pemesanan->kode_booking }}|{{ $pemesanan->nama_lengkap }}|{{ $pemesanan->jadwal->kapal->nama_kapal }}',
            size: 150,
            background: 'white',
            foreground: 'black',
            level: 'H'
        });
    });
</script>
@endsection
