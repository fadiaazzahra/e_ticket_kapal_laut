@extends('layouts.app')

@section('title', 'Pesan Tiket Kapal')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <!-- Route and Ship summary -->
        <div class="col-lg-4">
            <div class="card glass-panel border-0 shadow-sm p-4 h-100">
                <h4 class="mb-4 text-primary"><i class="fa-solid fa-anchor me-2"></i>Detail Perjalanan</h4>
                
                <div class="mb-4">
                    <label class="text-muted small uppercase fw-bold">Kapal</label>
                    <div class="h5 fw-bold"><i class="fa-solid fa-ship text-muted me-2"></i>{{ $jadwal->kapal->nama_kapal }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <label class="text-muted small uppercase fw-bold">Asal</label>
                        <div class="fw-bold">{{ $jadwal->asal }}</div>
                    </div>
                    <div class="col-6">
                        <label class="text-muted small uppercase fw-bold">Tujuan</label>
                        <div class="fw-bold">{{ $jadwal->tujuan }}</div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <label class="text-muted small uppercase fw-bold">Tanggal</label>
                        <div>{{ Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}</div>
                    </div>
                    <div class="col-6">
                        <label class="text-muted small uppercase fw-bold">Jam Berangkat</label>
                        <div>{{ Carbon\Carbon::parse($jadwal->jam_berangkat)->format('H:i') }} WIB</div>
                    </div>
                </div>

                <hr class="border-secondary my-3">

                <div>
                    <label class="text-muted small uppercase fw-bold">Harga Dasar (Ekonomi)</label>
                    <div class="h4 fw-bold text-success">Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="col-lg-8">
            <div class="card glass-panel border-0 shadow-sm p-4">
                <h4 class="mb-4 text-primary"><i class="fa-solid fa-id-card me-2"></i>Data Penumpang & Pemesanan</h4>

                @if ($errors->any())
                    <div class="alert alert-danger border-0">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('booking.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal }}">

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="jenis_pengguna" class="form-label text-muted small fw-bold">Jenis Pengguna</label>
                            <select name="jenis_pengguna" id="jenis_pengguna" class="form-select form-select-custom" required>
                                <option value="" disabled selected>Pilih Jenis Pengguna</option>
                                @foreach(\App\Models\Pemesanan::$jenisPenggunaList as $jenis)
                                    <option value="{{ $jenis }}" {{ old('jenis_pengguna', request('jenis_pengguna')) == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama_lengkap" class="form-label text-muted small fw-bold">Nama Lengkap Penumpang</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control form-control-custom" value="{{ old('nama_lengkap', auth()->user()->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nik" class="form-label text-muted small fw-bold">NIK (Nomor Induk Kependudukan)</label>
                            <input type="text" name="nik" id="nik" class="form-control form-control-custom" value="{{ old('nik') }}" placeholder="16 Digit NIK" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label text-muted small fw-bold">Nomor HP / WhatsApp</label>
                            <input type="text" name="no_hp" id="no_hp" class="form-control form-control-custom" value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label text-muted small fw-bold">Alamat Email</label>
                            <input type="email" name="email" id="email" class="form-control form-control-custom" value="{{ old('email', auth()->user()->email) }}" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="jenis_kelas" class="form-label text-muted small fw-bold">Kelas Tiket</label>
                            <select name="jenis_kelas" id="jenis_kelas" class="form-select form-select-custom" required>
                                @foreach($classOptions as $class)
                                    <option value="{{ $class }}" {{ old('jenis_kelas') == $class ? 'selected' : '' }}>{{ $class }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="jumlah_penumpang" class="form-label text-muted small fw-bold">Jumlah Penumpang</label>
                            <input type="number" name="jumlah_penumpang" id="jumlah_penumpang" class="form-control form-control-custom" value="{{ old('jumlah_penumpang', 1) }}" min="1" required>
                        </div>
                    </div>

                    <!-- Interactive Price Summary Panel -->
                    <div class="card bg-light border-0 p-3 mb-4 text-dark shadow-sm rounded-3">
                        <h6 class="mb-3 text-secondary uppercase fw-bold small"><i class="fa-solid fa-calculator me-1"></i>Rincian Biaya</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Harga Dasar ({{ $jadwal->kapal->nama_kapal }})</span>
                            <span class="fw-bold" id="base-price-display">Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Multiplier Kelas (<span id="class-label">Ekonomi</span>)</span>
                            <span class="fw-bold" id="multiplier-display">x 1.0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Jumlah Tiket</span>
                            <span class="fw-bold" id="ticket-count-display">1 Tiket</span>
                        </div>
                        <hr class="border-secondary my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h6 mb-0 font-weight-bold">Total Pembayaran</span>
                            <span class="h4 mb-0 fw-bold text-primary" id="total-price-display">Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-custom btn-custom-primary w-100 py-3">
                        <i class="fa-solid fa-credit-card me-2"></i> Lanjutkan ke Pembayaran
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
        const basePrice = {{ $jadwal->harga }};
        const classSelect = document.getElementById('jenis_kelas');
        const quantityInput = document.getElementById('jumlah_penumpang');
        
        const classLabel = document.getElementById('class-label');
        const multiplierDisplay = document.getElementById('multiplier-display');
        const ticketCountDisplay = document.getElementById('ticket-count-display');
        const totalPriceDisplay = document.getElementById('total-price-display');

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number).replace('IDR', 'Rp').trim();
        }

        function calculateTotal() {
            const selectedClass = classSelect.value;
            const quantity = parseInt(quantityInput.value) || 1;
            
            let multiplier = 1.0;
            if (selectedClass === 'Bisnis') {
                multiplier = 1.5;
            } else if (selectedClass === 'VIP') {
                multiplier = 2.0;
            }

            const total = basePrice * multiplier * quantity;

            classLabel.textContent = selectedClass;
            multiplierDisplay.textContent = 'x ' + multiplier.toFixed(1);
            ticketCountDisplay.textContent = quantity + ' Tiket';
            totalPriceDisplay.textContent = formatRupiah(total);
        }

        classSelect.addEventListener('change', calculateTotal);
        quantityInput.addEventListener('input', calculateTotal);
        
        // Initial run
        calculateTotal();
    });
</script>
@endsection
