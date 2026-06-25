@extends('layouts.app')

@section('title', 'Daftar Akun Baru')

@section('content')
<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card glass-panel border-0 shadow-lg p-4">
                <div class="text-center mb-4">
                    <i class="fa-solid fa-ship text-primary" style="font-size: 3rem;"></i>
                    <h3 class="mt-3 font-weight-bold">Daftar Akun Bahari</h3>
                    <p class="text-muted small">Buat akun untuk mulai memesan tiket kapal</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label text-muted small fw-bold">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fa-regular fa-user"></i></span>
                            <input type="text" name="name" id="name" class="form-control form-control-custom border-start-0" value="{{ old('name') }}" placeholder="Budi Santoso" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label text-muted small fw-bold">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fa-regular fa-envelope"></i></span>
                            <input type="email" name="email" id="email" class="form-control form-control-custom border-start-0" value="{{ old('email') }}" placeholder="budi@email.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label text-muted small fw-bold">Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control form-control-custom border-start-0" placeholder="Min. 6 karakter" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label text-muted small fw-bold">Konfirmasi Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fa-solid fa-circle-check"></i></span>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-custom border-start-0" placeholder="Ulangi kata sandi" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-custom btn-custom-primary w-100 py-3 mb-3">
                        <i class="fa-solid fa-user-plus me-2"></i> Daftar Akun
                    </button>
                </form>

                <div class="text-center">
                    <p class="text-muted small mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Masuk Disini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
