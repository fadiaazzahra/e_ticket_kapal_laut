@extends('layouts.admin')

@section('title', 'Metode Pembayaran')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-0 text-dark">Kelola Metode Pembayaran</h4>
        <p class="text-muted small mb-0">Atur rekening bank transfer dan kode QRIS pembayaran yang aktif untuk pemesanan tiket.</p>
    </div>
</div>

<div class="row g-4">
    <!-- SECTION A: TRANSFER BANK -->
    <div class="col-lg-7">
        <div class="admin-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0 text-primary"><i class="fa-solid fa-university me-2"></i>A. Transfer Bank</h5>
                <button type="button" class="btn btn-sm btn-custom btn-custom-primary" data-bs-toggle="modal" data-bs-target="#addBankModal">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Rekening
                </button>
            </div>

            @if($banks->isEmpty())
                <div class="text-center py-5 text-muted small">
                    <i class="fa-solid fa-info-circle mb-2 fs-3 text-secondary"></i><br>
                    Belum ada rekening bank yang terdaftar.
                </div>
            @else
                <div class="table-responsive table-responsive-custom">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>Bank</th>
                                <th>No. Rekening</th>
                                <th>Atas Nama</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banks as $bank)
                                <tr>
                                    <td class="fw-bold">{{ $bank->nama_bank }}</td>
                                    <td><code>{{ $bank->nomor_rekening }}</code></td>
                                    <td>{{ $bank->nama_pemilik }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.payment-methods.banks.toggle', $bank->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm border-0 bg-transparent">
                                                @if($bank->is_aktif)
                                                    <span class="badge bg-success py-1.5 px-2.5 rounded"><i class="fa-solid fa-circle-check me-1"></i>Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary py-1.5 px-2.5 rounded"><i class="fa-solid fa-circle-minus me-1"></i>Non-aktif</span>
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-sm btn-custom btn-custom-outline py-1 px-2" data-bs-toggle="modal" data-bs-target="#editBankModal-{{ $bank->id }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <form action="{{ route('admin.payment-methods.banks.destroy', $bank->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rekening {{ $bank->nama_bank }} ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger py-1 px-2">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- EDIT BANK MODAL -->
                                <div class="modal fade" id="editBankModal-{{ $bank->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content glass-panel border-0 text-dark">
                                            <div class="modal-header border-bottom-0">
                                                <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Edit Rekening Bank</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.payment-methods.banks.update', $bank->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body text-start">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold small text-muted">Nama Bank</label>
                                                        <input type="text" name="nama_bank" class="form-control form-control-custom" value="{{ $bank->nama_bank }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold small text-muted">Nomor Rekening</label>
                                                        <input type="text" name="nomor_rekening" class="form-control form-control-custom" value="{{ $bank->nomor_rekening }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold small text-muted">Nama Pemilik Rekening</label>
                                                        <input type="text" name="nama_pemilik" class="form-control form-control-custom" value="{{ $bank->nama_pemilik }}" required>
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

    <!-- SECTION B: QRIS -->
    <div class="col-lg-5">
        <div class="admin-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0 text-primary"><i class="fa-solid fa-qrcode me-2"></i>B. QRIS</h5>
                <button type="button" class="btn btn-sm btn-custom btn-custom-primary" data-bs-toggle="modal" data-bs-target="#uploadQrisModal">
                    <i class="fa-solid fa-plus me-1"></i> Unggah QRIS
                </button>
            </div>

            @if($qrisList->isEmpty())
                <div class="text-center py-5 text-muted small">
                    <i class="fa-solid fa-qrcode mb-2 fs-3 text-secondary"></i><br>
                    Belum ada QRIS yang diunggah.
                </div>
            @else
                <div class="row g-3">
                    @foreach($qrisList as $qris)
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="card p-3 h-100 border text-center relative bg-light">
                                <div class="mb-2 d-flex justify-content-center">
                                    <img src="{{ asset($qris->image_path) }}" alt="QRIS" class="img-thumbnail" style="max-height: 150px; object-fit: contain;">
                                </div>
                                
                                <div class="mt-2 d-flex justify-content-center align-items-center gap-2">
                                    <form action="{{ route('admin.payment-methods.qris.toggle', $qris->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-xs p-0 border-0 bg-transparent">
                                            @if($qris->is_aktif)
                                                <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i>Aktif</span>
                                            @else
                                                <span class="badge bg-secondary"><i class="fa-solid fa-minus me-1"></i>Mati</span>
                                            @endif
                                        </button>
                                    </form>
                                </div>

                                <div class="mt-3 d-flex justify-content-center gap-2">
                                    <!-- Edit Image Button -->
                                    <button type="button" class="btn btn-sm btn-custom btn-custom-outline py-1 px-2" data-bs-toggle="modal" data-bs-target="#editQrisModal-{{ $qris->id }}">
                                        <i class="fa-solid fa-upload"></i> Ganti
                                    </button>
                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.payment-methods.qris.destroy', $qris->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar QRIS ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger py-1 px-2">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- EDIT QRIS MODAL -->
                        <div class="modal fade" id="editQrisModal-{{ $qris->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content glass-panel border-0 text-dark">
                                    <div class="modal-header border-bottom-0">
                                        <h5 class="modal-title"><i class="fa-solid fa-upload me-2 text-primary"></i>Ganti Gambar QRIS</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.payment-methods.qris.update', $qris->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body text-start text-center">
                                            <div class="mb-3">
                                                <img src="{{ asset($qris->image_path) }}" class="img-fluid img-thumbnail mb-3" style="max-height: 120px;" alt="QRIS Lama">
                                            </div>
                                            <div class="mb-3 text-start">
                                                <label class="form-label fw-bold small text-muted">Pilih Gambar QRIS Baru (jpg, png)</label>
                                                <input type="file" name="image" class="form-control form-control-custom" accept="image/*" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0">
                                            <button type="button" class="btn btn-custom btn-custom-outline py-2" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-custom btn-custom-primary py-2">Ganti Gambar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- ADD BANK ACCOUNT MODAL -->
<div class="modal fade" id="addBankModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content glass-panel border-0 text-dark">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title"><i class="fa-solid fa-plus me-2 text-primary"></i>Tambah Rekening Bank Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.payment-methods.banks.store') }}" method="POST">
                @csrf
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label for="nama_bank" class="form-label fw-bold small text-muted">Nama Bank</label>
                        <input type="text" name="nama_bank" id="nama_bank" class="form-control form-control-custom" placeholder="Contoh: Bank Mandiri, Bank BCA" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_rekening" class="form-label fw-bold small text-muted">Nomor Rekening</label>
                        <input type="text" name="nomor_rekening" id="nomor_rekening" class="form-control form-control-custom" placeholder="1234567890" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_pemilik" class="form-label fw-bold small text-muted">Nama Pemilik Rekening</label>
                        <input type="text" name="nama_pemilik" id="nama_pemilik" class="form-control form-control-custom" placeholder="Contoh: PT Bahari Lines" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-custom btn-custom-outline py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-custom btn-custom-primary py-2">Tambah Rekening</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- UPLOAD QRIS MODAL -->
<div class="modal fade" id="uploadQrisModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content glass-panel border-0 text-dark">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title"><i class="fa-solid fa-upload me-2 text-primary"></i>Unggah Kode QRIS Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.payment-methods.qris.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label for="image_qris" class="form-label fw-bold small text-muted">Pilih File Gambar QRIS (JPG, JPEG, PNG)</label>
                        <input type="file" name="image" id="image_qris" class="form-control form-control-custom" accept="image/*" required>
                        <div class="form-text small text-muted">Rekomendasi ukuran file tidak melebihi 2MB.</div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-custom btn-custom-outline py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-custom btn-custom-primary py-2">Unggah QRIS</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
