@extends('layouts.app')

@section('title', 'Jadwal Kapal Laut Terbaru')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h1">Jadwal Keberangkatan Kapal</h2>
            <p class="text-muted">Cari jadwal keberangkatan, informasi kapal, dan ketersediaan tiket.</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card glass-panel border-0 p-4 shadow-sm">
                <form action="{{ route('jadwal') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="jenis_pengguna" class="form-label text-muted small fw-bold">Jenis Pengguna</label>
                            <select name="jenis_pengguna" id="jenis_pengguna" class="form-select form-select-custom" required>
                                <option value="" disabled selected>Pilih Jenis Pengguna</option>
                                @foreach(\App\Models\Pemesanan::$jenisPenggunaList as $jenis)
                                    <option value="{{ $jenis }}" {{ request('jenis_pengguna') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="asal" class="form-label text-muted small fw-bold">Pelabuhan Asal</label>
                            <select name="asal" id="asal" class="form-select form-select-custom">
                                <option value="">Semua Pelabuhan Asal</option>
                                @foreach($origins as $origin)
                                    <option value="{{ $origin }}" {{ request('asal') == $origin ? 'selected' : '' }}>{{ $origin }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="tujuan" class="form-label text-muted small fw-bold">Pelabuhan Tujuan</label>
                            <select name="tujuan" id="tujuan" class="form-select form-select-custom">
                                <option value="">Semua Pelabuhan Tujuan</option>
                                @foreach($destinations as $dest)
                                    <option value="{{ $dest }}" {{ request('tujuan') == $dest ? 'selected' : '' }}>{{ $dest }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="tanggal" class="form-label text-muted small fw-bold">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control form-control-custom" value="{{ request('tanggal') }}">
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-custom btn-custom-primary flex-grow-1 py-2">
                                <i class="fa-solid fa-filter me-2"></i> Filter
                            </button>
                            @if(request()->anyFilled(['asal', 'tujuan', 'tanggal', 'search']))
                                <a href="{{ route('jadwal') }}" class="btn btn-custom btn-custom-outline py-2">
                                    <i class="fa-solid fa-rotate-left"></i> Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Schedule Table -->
    <div class="row">
        <div class="col-12">
            @if($jadwals->isEmpty())
                <div class="card glass-panel border-0 p-5 text-center shadow-sm">
                    <i class="fa-solid fa-calendar-xmark text-danger" style="font-size: 4rem;"></i>
                    <h4 class="mt-4">Jadwal Tidak Ditemukan</h4>
                    <p class="text-muted mb-0">Maaf, saat ini tidak ada jadwal kapal yang sesuai dengan pencarian Anda.</p>
                </div>
            @else
                <div class="table-responsive table-responsive-custom shadow-sm">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>Nama Kapal</th>
                                <th>Asal</th>
                                <th>Tujuan</th>
                                <th>Tanggal</th>
                                <th>Jam Berangkat</th>
                                <th>Harga Dasar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwals as $j)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-primary"><i class="fa-solid fa-ship me-2"></i>{{ $j->kapal->nama_kapal }}</div>
                                        <small class="text-muted">{{ $j->kapal->kelas }}</small>
                                    </td>
                                    <td>{{ $j->asal }}</td>
                                    <td>{{ $j->tujuan }}</td>
                                    <td>
                                        <i class="fa-regular fa-calendar-check text-muted me-1"></i>
                                        {{ Carbon\Carbon::parse($j->tanggal)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>
                                        <i class="fa-regular fa-clock text-muted me-1"></i>
                                        {{ Carbon\Carbon::parse($j->jam_berangkat)->format('H:i') }} WIB
                                    </td>
                                    <td class="fw-bold text-success">
                                        Rp {{ number_format($j->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('booking.create') }}?id_jadwal={{ $j->id_jadwal }}&jenis_pengguna={{ request('jenis_pengguna') }}" class="btn btn-custom btn-custom-primary py-2 px-3">
                                            <i class="fa-solid fa-cart-shopping me-1"></i> Pesan Tiket
                                        </a>
                                    </td>
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
