@extends('layouts.admin')

@section('title', 'Kelola Jadwal')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0 text-dark">Kelola Jadwal Kapal</h4>
            <p class="text-muted small mb-0">Atur jadwal penyeberangan, rute asal-tujuan, waktu keberangkatan, dan tarif tiket dasar.</p>
        </div>
        <button type="button" class="btn btn-custom btn-custom-primary" data-bs-toggle="modal" data-bs-target="#addJadwalModal">
            <i class="fa-solid fa-circle-plus me-2"></i> Tambah Jadwal
        </button>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="admin-card">
            @if($jadwals->isEmpty())
                <div class="text-center py-4 text-muted">
                    Belum ada data jadwal penyeberangan. Silakan tambah jadwal baru.
                </div>
            @else
                <div class="table-responsive table-responsive-custom">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>Kapal</th>
                                <th>Pelabuhan Rute</th>
                                <th>Tanggal & Jam</th>
                                <th>Harga Dasar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwals as $j)
                                <tr>
                                    <td class="fw-bold text-primary"><i class="fa-solid fa-ship me-2"></i>{{ $j->kapal->nama_kapal }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $j->asal }}</div>
                                        <div class="small text-muted">Ke: {{ $j->tujuan }}</div>
                                    </td>
                                    <td>
                                        <div><i class="fa-regular fa-calendar me-2"></i>{{ Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }}</div>
                                        <div class="small text-muted"><i class="fa-regular fa-clock me-2"></i>{{ Carbon\Carbon::parse($j->jam_berangkat)->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="fw-bold text-success">Rp {{ number_format($j->harga, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Edit button triggers modal -->
                                            <button type="button" class="btn btn-sm btn-custom btn-custom-outline py-1 px-2" data-bs-toggle="modal" data-bs-target="#editJadwalModal-{{ $j->id_jadwal }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            
                                            <!-- Delete button triggers form -->
                                            <form action="{{ route('admin.jadwals.destroy', $j->id_jadwal) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal rute {{ $j->asal }} ke {{ $j->tujuan }}? Semua pemesanan terkait akan terhapus.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger py-1 px-2">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- EDIT MODAL for this Jadwal -->
                                <div class="modal fade" id="editJadwalModal-{{ $j->id_jadwal }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $j->id_jadwal }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content glass-panel border-0 text-dark">
                                            <div class="modal-header border-bottom-0">
                                                <h5 class="modal-title" id="editModalLabel-{{ $j->id_jadwal }}"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Edit Jadwal Kapal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.jadwals.update', $j->id_jadwal) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="id_kapal-{{ $j->id_jadwal }}" class="form-label fw-bold small text-muted">Kapal</label>
                                                        <select name="id_kapal" id="id_kapal-{{ $j->id_jadwal }}" class="form-select form-select-custom" required>
                                                            @foreach($kapals as $kapal)
                                                                <option value="{{ $kapal->id_kapal }}" {{ $j->id_kapal == $kapal->id_kapal ? 'selected' : '' }}>{{ $kapal->nama_kapal }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-6">
                                                            <label for="asal-{{ $j->id_jadwal }}" class="form-label fw-bold small text-muted">Pelabuhan Asal</label>
                                                            <input type="text" name="asal" id="asal-{{ $j->id_jadwal }}" class="form-control form-control-custom" value="{{ $j->asal }}" required>
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="tujuan-{{ $j->id_jadwal }}" class="form-label fw-bold small text-muted">Pelabuhan Tujuan</label>
                                                            <input type="text" name="tujuan" id="tujuan-{{ $j->id_jadwal }}" class="form-control form-control-custom" value="{{ $j->tujuan }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-6">
                                                            <label for="tanggal-{{ $j->id_jadwal }}" class="form-label fw-bold small text-muted">Tanggal</label>
                                                            <input type="date" name="tanggal" id="tanggal-{{ $j->id_jadwal }}" class="form-control form-control-custom" value="{{ $j->tanggal }}" required>
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="jam_berangkat-{{ $j->id_jadwal }}" class="form-label fw-bold small text-muted">Jam Berangkat</label>
                                                            <input type="time" name="jam_berangkat" id="jam_berangkat-{{ $j->id_jadwal }}" class="form-control form-control-custom" value="{{ $j->jam_berangkat }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="harga-{{ $j->id_jadwal }}" class="form-label fw-bold small text-muted">Harga Dasar (IDR)</label>
                                                        <input type="number" name="harga" id="harga-{{ $j->id_jadwal }}" class="form-control form-control-custom" value="{{ $j->harga }}" min="0" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top-0">
                                                    <button type="button" class="btn btn-custom btn-custom-outline py-2" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-custom btn-custom-primary py-2">Simpan Perubahan</button>
                                                </div>
                                            </form>
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

<!-- ADD MODAL -->
<div class="modal fade" id="addJadwalModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content glass-panel border-0 text-dark">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="addModalLabel"><i class="fa-solid fa-circle-plus me-2 text-primary"></i>Tambah Jadwal Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.jadwals.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_kapal" class="form-label fw-bold small text-muted">Pilih Kapal</label>
                        <select name="id_kapal" id="id_kapal" class="form-select form-select-custom" required>
                            <option value="" disabled selected>Pilih Kapal</option>
                            @foreach($kapals as $kapal)
                                <option value="{{ $kapal->id_kapal }}">{{ $kapal->nama_kapal }} (Kapasitas: {{ $kapal->kapasitas }} pax)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="asal" class="form-label fw-bold small text-muted">Pelabuhan Asal</label>
                            <input type="text" name="asal" id="asal" class="form-control form-control-custom" placeholder="Contoh: Tanjung Priok (Jakarta)" required>
                        </div>
                        <div class="col-6">
                            <label for="tujuan" class="form-label fw-bold small text-muted">Pelabuhan Tujuan</label>
                            <input type="text" name="tujuan" id="tujuan" class="form-control form-control-custom" placeholder="Contoh: Belawan (Medan)" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="tanggal" class="form-label fw-bold small text-muted">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control form-control-custom" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-6">
                            <label for="jam_berangkat" class="form-label fw-bold small text-muted">Jam Berangkat</label>
                            <input type="time" name="jam_berangkat" id="jam_berangkat" class="form-control form-control-custom" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label fw-bold small text-muted">Harga Dasar (IDR)</label>
                        <input type="number" name="harga" id="harga" class="form-control form-control-custom" placeholder="250000" min="0" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-custom btn-custom-outline py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-custom btn-custom-primary py-2">Tambah Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
