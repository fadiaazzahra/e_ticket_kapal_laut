<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard Admin') - BahariLines Admin</title>

    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Inline script to apply dark mode before page render to avoid flash -->
    <script>
        const currentTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', currentTheme);
    </script>
</head>
<body>

    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar d-flex flex-column justify-content-between">
            <div>
                <div class="admin-sidebar-brand">
                    <i class="fa-solid fa-ship text-primary"></i>
                    <span>BahariAdmin</span>
                </div>
                
                <nav class="admin-menu-list">
                    <a href="{{ route('admin.dashboard') }}" class="admin-menu-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-gauge-high"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.kapals') }}" class="admin-menu-link {{ Request::routeIs('admin.kapals*') ? 'active' : '' }}">
                        <i class="fa-solid fa-ship"></i> Kelola Kapal
                    </a>
                    <a href="{{ route('admin.jadwals') }}" class="admin-menu-link {{ Request::routeIs('admin.jadwals*') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-days"></i> Kelola Jadwal
                    </a>
                    <a href="{{ route('admin.pemesanans') }}" class="admin-menu-link {{ Request::routeIs('admin.pemesanans*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i> Kelola Pemesanan
                    </a>
                    <a href="{{ route('admin.pembayarans') }}" class="admin-menu-link {{ Request::routeIs('admin.pembayarans*') ? 'active' : '' }}">
                        <i class="fa-solid fa-money-bill-wave"></i> Kelola Pembayaran
                    </a>
                    <a href="{{ route('admin.users') }}" class="admin-menu-link {{ Request::routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-gear"></i> Kelola Pengguna
                    </a>
                    <a href="{{ route('admin.laporan') }}" class="admin-menu-link {{ Request::routeIs('admin.laporan*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-invoice-dollar"></i> Laporan Penjualan
                    </a>
                </nav>
            </div>

            <!-- Sidebar Footer -->
            <div>
                <hr class="border-secondary my-3">
                
                <!-- Dark Mode Toggle in Admin -->
                <div class="d-flex align-items-center justify-content-between px-3 mb-3">
                    <span class="small text-muted"><i class="fa-solid fa-circle-half-stroke me-2"></i>Tema</span>
                    <div class="theme-switch-wrapper">
                        <label class="theme-switch" for="checkbox">
                            <input type="checkbox" id="checkbox" />
                            <div class="slider"></div>
                        </label>
                    </div>
                </div>

                <a href="{{ route('home') }}" class="admin-menu-link">
                    <i class="fa-solid fa-globe"></i> Lihat Website
                </a>

                <form action="{{ route('logout') }}" method="POST" class="d-block">
                    @csrf
                    <button type="submit" class="admin-menu-link border-0 bg-transparent w-100 text-start text-danger">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout Admin
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-content">
            <!-- Header bar inside Admin panel -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-1">Panel Administrasi</h2>
                    <p class="text-muted mb-0 small">Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong></p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-primary px-3 py-2"><i class="fa-solid fa-user-shield me-2"></i>Administrator</span>
                </div>
            </div>

            <!-- Page content injections -->
            @yield('content')
        </main>
    </div>

    <!-- JS Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Theme Switch Script -->
    <script>
        const toggleSwitch = document.querySelector('#checkbox');
        const theme = localStorage.getItem('theme') || 'light';
        
        if (theme === 'dark') {
            toggleSwitch.checked = true;
        }

        toggleSwitch.addEventListener('change', function(e) {
            if (e.target.checked) {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
                localStorage.setItem('theme', 'light');
            }
        });
    </script>

    <!-- SweetAlert Success/Error Alerts -->
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#0284c7'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#ef4444'
            });
        @endif
    </script>

    @yield('scripts')
</body>
</html>
