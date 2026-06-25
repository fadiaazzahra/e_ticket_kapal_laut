@extends('layouts.admin')

@section('title', 'Kelola Kapal')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0 text-dark">Kelola Data Kapal</h4>
            <p class="text-muted small mb-0">Kelola informasi kapal, kapasitas penumpang, dan kelas penyeberangan.</p>
        </div>
        <button type="button" class="btn btn-custom btn-custom-primary" data-bs-toggle="modal" data-bs-target="#addKapalModal">
            <i class="fa-solid fa-circle-plus me-2"></i> Tambah Kapal
        </button>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="admin-card">
            @if($kapals->isEmpty())
                <div class="text-center py-4 text-muted">
                    Belum ada data kapal. Silakan tambah data kapal baru.
                </div>
            @else
                <div class="table-responsive table-responsive-custom">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Kapal</th>
                                <th>Kapasitas Max</th>
                                <th>Kelas Tersedia</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kapals as $k)
                                <tr>
                                    <td>#{{ $k->id_kapal }}</td>
                                    <td class="fw-bold"><i class="fa-solid fa-ship text-muted me-2"></i>{{ $k->nama_kapal }}</td>
                                    <td>{{ number_format($k->kapasitas) }} Penumpang</td>
                                    <td>
                                        @foreach(explode(',', $k->kelas) as $cls)
                                            <span class="badge bg-secondary me-1">{{ trim($cls) }}</span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Edit button triggers modal -->
                                            <button type="button" class="btn btn-sm btn-custom btn-custom-outline py-1 px-2" data-bs-toggle="modal" data-bs-target="#editKapalModal-{{ $k->id_kapal }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            
                                            <!-- Delete button triggers form -->
                                            <form action="{{ route('admin.kapals.destroy', $k->id_kapal) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kapal {{ $k->nama_kapal }}? Semua jadwal yang terhubung akan ikut terhapus.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger py-1 px-2">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- EDIT MODAL for this specific Kapal -->
                                <div class="modal fade" id="editKapalModal-{{ $k->id_kapal }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $k->id_kapal }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content glass-panel border-0 text-dark">
                                            <div class="modal-header border-bottom-0">
                                                <h5 class="modal-title" id="editModalLabel-{{ $k->id_kapal }}"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Edit Data Kapal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.kapals.update', $k->id_kapal) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="nama_kapal-{{ $k->id_kapal }}" class="form-label fw-bold small text-muted">Nama Kapal</label>
                                                        <input type="text" name="nama_kapal" id="nama_kapal-{{ $k->id_kapal }}" class="form-control form-control-custom" value="{{ $k->nama_kapal }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="kapasitas-{{ $k->id_kapal }}" class="form-label fw-bold small text-muted">Kapasitas Penumpang</label>
                                                        <input type="number" name="kapasitas" id="kapasitas-{{ $k->id_kapal }}" class="form-control form-control-custom" value="{{ $k->kapasitas }}" min="1" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold small text-muted d-block">Kelas Tersedia</label>
                                                        @php $kapalClasses = array_map('trim', explode(',', $k->kelas)); @endphp
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="kelas[]" id="cls-eko-{{ $k->id_kapal }}" value="Ekonomi" {{ in_array('Ekonomi', $kapalClasses) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="cls-eko-{{ $k->id_kapal }}">Ekonomi</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="kelas[]" id="cls-bis-{{ $k->id_kapal }}" value="Bisnis" {{ in_array('Bisnis', $kapalClasses) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="cls-bis-{{ $k->id_kapal }}">Bisnis</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="kelas[]" id="cls-vip-{{ $k->id_kapal }}" value="VIP" {{ in_array('VIP', $kapalClasses) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="cls-vip-{{ $k->id_kapal }}">VIP</label>
                                                        </div>
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
<div class="modal fade" id="addKapalModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content glass-panel border-0 text-dark">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="addModalLabel"><i class="fa-solid fa-circle-plus me-2 text-primary"></i>Tambah Kapal Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.kapals.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kapal" class="form-label fw-bold small text-muted">Nama Kapal</label>
                        <input type="text" name="nama_kapal" id="nama_kapal" class="form-control form-control-custom" placeholder="Contoh: KM Kelud" required>
                    </div>
                    <div class="mb-3">
                        <label for="kapasitas" class="form-label fw-bold small text-muted">Kapasitas Penumpang</label>
                        <input type="number" name="kapasitas" id="kapasitas" class="form-control form-control-custom" placeholder="1000" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted d-block">Kelas Tersedia</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="kelas[]" id="cls-eko" value="Ekonomi" checked>
                            <label class="form-check-label" for="cls-eko">Ekonomi</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="kelas[]" id="cls-bis" value="Bisnis">
                            <label class="form-check-label" for="cls-bis">Bisnis</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="kelas[]" id="cls-vip" value="VIP">
                            <label class="form-check-label" for="cls-vip">VIP</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-custom btn-custom-outline py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-custom btn-custom-primary py-2">Tambah Kapal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
