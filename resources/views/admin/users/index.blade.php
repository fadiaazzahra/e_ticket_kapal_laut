@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0 text-dark">Kelola Data Pengguna</h4>
            <p class="text-muted small mb-0">Atur hak akses akun sistem, tambah Administrator, atau perbarui data pelanggan.</p>
        </div>
        <button type="button" class="btn btn-custom btn-custom-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fa-solid fa-user-plus me-2"></i> Tambah Pengguna
        </button>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="admin-card">
            @if($users->isEmpty())
                <div class="text-center py-4 text-muted">
                    Belum ada data pengguna.
                </div>
            @else
                <div class="table-responsive table-responsive-custom">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>Alamat Email</th>
                                <th>Hak Akses / Role</th>
                                <th>Tanggal Registrasi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                                <tr>
                                    <td class="fw-bold text-dark"><i class="fa-regular fa-user text-muted me-2"></i>{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>
                                        @if($u->role === 'admin')
                                            <span class="badge bg-danger px-2"><i class="fa-solid fa-user-shield me-1"></i>Administrator</span>
                                        @else
                                            <span class="badge bg-primary px-2"><i class="fa-solid fa-user me-1"></i>User / Pelanggan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $u->created_at->format('d M Y, H:i') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Edit button triggers modal -->
                                            <button type="button" class="btn btn-sm btn-custom btn-custom-outline py-1 px-2" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $u->id }}">
                                                <i class="fa-solid fa-user-pen"></i>
                                            </button>
                                            
                                            <!-- Delete button triggers form -->
                                            @if($u->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $u->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger py-1 px-2">
                                                        <i class="fa-solid fa-user-xmark"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-sm btn-secondary py-1 px-2" disabled title="Tidak dapat menghapus akun sendiri yang sedang aktif">
                                                    <i class="fa-solid fa-user-lock"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- EDIT MODAL for this User -->
                                <div class="modal fade" id="editUserModal-{{ $u->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $u->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content glass-panel border-0 text-dark">
                                            <div class="modal-header border-bottom-0">
                                                <h5 class="modal-title" id="editModalLabel-{{ $u->id }}"><i class="fa-solid fa-user-pen me-2 text-primary"></i>Edit Data Pengguna</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.users.update', $u->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="name-{{ $u->id }}" class="form-label fw-bold small text-muted">Nama Lengkap</label>
                                                        <input type="text" name="name" id="name-{{ $u->id }}" class="form-control form-control-custom" value="{{ $u->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email-{{ $u->id }}" class="form-label fw-bold small text-muted">Alamat Email</label>
                                                        <input type="email" name="email" id="email-{{ $u->id }}" class="form-control form-control-custom" value="{{ $u->email }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password-{{ $u->id }}" class="form-label fw-bold small text-muted">Kata Sandi Baru <span class="text-muted font-weight-normal">(kosongkan jika tidak diubah)</span></label>
                                                        <input type="password" name="password" id="password-{{ $u->id }}" class="form-control form-control-custom" placeholder="••••••••">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="role-{{ $u->id }}" class="form-label fw-bold small text-muted">Hak Akses / Role</label>
                                                        <select name="role" id="role-{{ $u->id }}" class="form-select form-select-custom" required>
                                                            <option value="user" {{ $u->role === 'user' ? 'selected' : '' }}>User / Pelanggan</option>
                                                            <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                                                        </select>
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
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content glass-panel border-0 text-dark">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="addModalLabel"><i class="fa-solid fa-user-plus me-2 text-primary"></i>Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold small text-muted">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control form-control-custom" placeholder="Contoh: Siti Aminah" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold small text-muted">Alamat Email</label>
                        <input type="email" name="email" id="email" class="form-control form-control-custom" placeholder="siti@email.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold small text-muted">Kata Sandi</label>
                        <input type="password" name="password" id="password" class="form-control form-control-custom" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label fw-bold small text-muted">Hak Akses / Role</label>
                        <select name="role" id="role" class="form-select form-select-custom" required>
                            <option value="user" selected>User / Pelanggan</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-custom btn-custom-outline py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-custom btn-custom-primary py-2">Tambah Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
