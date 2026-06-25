@extends('layouts.app')

@section('title', 'Pembayaran Tiket Kapal')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center g-4">
        
        <!-- Summary card -->
        <div class="col-lg-5">
            <div class="card glass-panel border-0 shadow-sm p-4 h-100">
                <h4 class="mb-4 text-primary"><i class="fa-solid fa-receipt me-2"></i>Ringkasan Pemesanan</h4>
                
                <div class="mb-3 d-flex justify-content-between">
                    <span class="text-muted">Kode Booking</span>
                    <span class="fw-bold text-primary">{{ $pemesanan->kode_booking }}</span>
                </div>
                
                <div class="mb-3 d-flex justify-content-between">
                    <span class="text-muted">Kapal</span>
                    <span class="fw-bold">{{ $pemesanan->jadwal->kapal->nama_kapal }}</span>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <span class="text-muted">Rute Perjalanan</span>
                    <span class="fw-bold text-end">{{ $pemesanan->jadwal->asal }} <br>→ {{ $pemesanan->jadwal->tujuan }}</span>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <span class="text-muted">Tanggal & Jam</span>
                    <span class="fw-bold">{{ Carbon\Carbon::parse($pemesanan->jadwal->tanggal)->translatedFormat('d F Y') }} ({{ Carbon\Carbon::parse($pemesanan->jadwal->jam_berangkat)->format('H:i') }} WIB)</span>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <span class="text-muted">Penumpang</span>
                    <span class="fw-bold">{{ $pemesanan->nama_lengkap }} (NIK: {{ $pemesanan->nik }})</span>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <span class="text-muted">Kelas / Jumlah</span>
                    <span class="fw-bold">{{ $pemesanan->jenis_kelas }} / {{ $pemesanan->jumlah_penumpang }} Orang</span>
                </div>

                <hr class="border-secondary my-3">

                <div class="d-flex justify-content-between align-items-center">
                    <span class="h6 mb-0 font-weight-bold">Total Pembayaran</span>
                    <span class="h3 mb-0 fw-bold text-success">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment selector & upload form -->
        <div class="col-lg-7">
            <div class="card glass-panel border-0 shadow-sm p-4">
                <h4 class="mb-4 text-primary"><i class="fa-solid fa-wallet me-2"></i>Pilih Metode Pembayaran</h4>

                @if ($errors->any())
                    <div class="alert alert-danger border-0">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('booking.submitPayment', $pemesanan->id_pemesanan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Method choices -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <input type="radio" class="btn-check" name="metode" id="method-bank" value="Transfer Bank" checked>
                            <label class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center justify-content-center gap-2" for="method-bank">
                                <i class="fa-solid fa-university fs-3"></i>
                                <span class="small fw-bold">Transfer Bank</span>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input type="radio" class="btn-check" name="metode" id="method-ewallet" value="E-Wallet">
                            <label class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center justify-content-center gap-2" for="method-ewallet">
                                <i class="fa-solid fa-mobile-screen-button fs-3"></i>
                                <span class="small fw-bold">E-Wallet</span>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input type="radio" class="btn-check" name="metode" id="method-qris" value="QRIS">
                            <label class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center justify-content-center gap-2" for="method-qris">
                                <i class="fa-solid fa-qrcode fs-3"></i>
                                <span class="small fw-bold">QRIS</span>
                            </label>
                        </div>
                    </div>

                    <!-- Payment details changes dynamically -->
                    <div id="details-bank" class="payment-instruction-panel card border-0 bg-light p-3 mb-4 text-dark">
                        <h6 class="fw-bold mb-2"><i class="fa-solid fa-circle-info me-2 text-primary"></i>Instruksi Transfer Bank</h6>
                        <p class="small mb-3">Silakan transfer nominal pas ke rekening berikut:</p>
                        <div class="mb-2">
                            <strong class="text-primary">SeaBank (901086931023)</strong><br>
                            <span class="small text-muted">A.n Fadia Azzahra</span>
                        </div>
                    </div>

                    <div id="details-ewallet" class="payment-instruction-panel card border-0 bg-light p-3 mb-4 text-dark d-none">
                        <h6 class="fw-bold mb-2"><i class="fa-solid fa-circle-info me-2 text-primary"></i>Instruksi E-Wallet</h6>
                        <p class="small mb-3">Silakan lakukan pembayaran ke nomor E-Wallet berikut:</p>
                        <div class="mb-2">
                            <strong class="text-primary">DANA</strong><br>
                            <span class="h6 text-primary fw-bold">082128593608</span><br>
                            <span class="small text-muted">A.n Fadia Azzahra</span>
                        </div>
                    </div>

                    <div id="details-qris" class="payment-instruction-panel card border-0 bg-light p-3 mb-4 text-dark d-none text-center">
                        <h6 class="fw-bold mb-2"><i class="fa-solid fa-circle-info me-2 text-primary"></i>Instruksi Scan QRIS</h6>
                        <p class="small mb-3">Scan QR Code di bawah menggunakan aplikasi M-Banking atau E-Wallet Anda:</p>
                        <div class="d-inline-block p-2 bg-white rounded shadow-sm mb-2">
                            <!-- Dynamic QR Code API -->
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=BahariLines-BookingCode-{{ $pemesanan->kode_booking }}-Total-{{ $pemesanan->total_harga }}" alt="Mock QRIS" class="img-fluid" style="width: 160px; height: 160px;">
                        </div>
                        <div class="small fw-bold">BahariLines QRIS Merchant</div>
                    </div>

                    <!-- Receipt Upload -->
                    <div class="mb-4">
                        <label for="bukti_transfer" class="form-label text-muted small fw-bold">Unggah Bukti Pembayaran</label>
                        <div class="input-group">
                            <input type="file" name="bukti_transfer" id="bukti_transfer" class="form-control form-control-custom" accept="image/*" required>
                        </div>
                        <div class="form-text small text-muted">Format file yang didukung: JPG, JPEG, PNG (Maksimal 2MB).</div>
                    </div>

                    <button type="submit" class="btn btn-custom btn-custom-primary w-100 py-3">
                        <i class="fa-solid fa-upload me-2"></i> Unggah Bukti & Selesaikan
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radBank = document.getElementById('method-bank');
        const radEwallet = document.getElementById('method-ewallet');
        const radQris = document.getElementById('method-qris');

        const detBank = document.getElementById('details-bank');
        const detEwallet = document.getElementById('details-ewallet');
        const detQris = document.getElementById('details-qris');

        function togglePanels() {
            if (radBank.checked) {
                detBank.classList.remove('d-none');
                detEwallet.classList.add('d-none');
                detQris.classList.add('d-none');
            } else if (radEwallet.checked) {
                detBank.classList.add('d-none');
                detEwallet.classList.remove('d-none');
                detQris.classList.add('d-none');
            } else if (radQris.checked) {
                detBank.classList.add('d-none');
                detEwallet.classList.add('d-none');
                detQris.classList.remove('d-none');
            }
        }

        radBank.addEventListener('change', togglePanels);
        radEwallet.addEventListener('change', togglePanels);
        radQris.addEventListener('change', togglePanels);
    });
</script>
@endsection
