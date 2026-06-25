<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Pemesanan Tiket Kapal Laut Online') - E-Ticket Kapal</title>
    
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

    <!-- Header Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fa-solid fa-ship"></i>
                <span>BahariLines</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ Request::routeIs('jadwal') ? 'active' : '' }}" href="{{ route('jadwal') }}">Jadwal Kapal</a>
                    </li>
                    @auth
                        @if(auth()->user()->role === 'user')
                            <li class="nav-item">
                                <a class="nav-link nav-link-custom {{ Request::routeIs('booking.create') ? 'active' : '' }}" href="{{ route('booking.create') }}?id_jadwal={{ App\Models\Jadwal::first()?->id_jadwal ?? '' }}">Pesan Tiket</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-custom {{ Request::routeIs('booking.history') ? 'active' : '' }}" href="{{ route('booking.history') }}">Riwayat Pemesanan</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom" href="{{ route('booking.create') }}?id_jadwal={{ App\Models\Jadwal::first()?->id_jadwal ?? '' }}">Pesan Tiket</a>
                        </li>
                    @endauth
                </ul>
                
                <div class="d-flex align-items-center gap-3">
                    <!-- Dark Mode Toggle -->
                    <div class="theme-switch-wrapper">
                        <i class="fa-solid fa-sun text-warning sun-icon" style="font-size: 1.1rem;"></i>
                        <label class="theme-switch" for="checkbox">
                            <input type="checkbox" id="checkbox" />
                            <div class="slider"></div>
                        </label>
                        <i class="fa-solid fa-moon text-primary moon-icon" style="font-size: 1.1rem;"></i>
                    </div>

                    <!-- Auth Actions -->
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-custom btn-custom-outline dropdown-toggle py-2" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user me-2"></i>{{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown">
                                @if(auth()->user()->role === 'admin')
                                    <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge-high me-2 text-primary"></i>Dashboard Admin</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-custom btn-custom-outline py-2">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-custom btn-custom-primary py-2">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <h5 class="text-white mb-3"><i class="fa-solid fa-ship me-2 text-primary"></i>BahariLines</h5>
                    <p class="mb-0 text-muted">Layanan pemesanan tiket online kapal laut terpercaya, cepat, dan aman. Nikmati kemudahan memesan tiket kapal kemana saja dan kapan saja.</p>
                </div>
                <div class="col-lg-4">
                    <h5 class="text-white mb-3">Tautan Pintas</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('jadwal') }}">Jadwal Kapal</a></li>
                        <li><a href="{{ route('booking.create') }}?id_jadwal={{ App\Models\Jadwal::first()?->id_jadwal ?? '' }}">Pesan Tiket</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="text-white mb-3">Kontak Layanan</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2 text-muted">
                        <li><i class="fa-solid fa-envelope me-2 text-primary"></i> support@baharilines.com</li>
                        <li><i class="fa-solid fa-phone me-2 text-primary"></i> +62 812-3456-7890</li>
                        <li><i class="fa-solid fa-clock me-2 text-primary"></i> Layanan Bantuan 24/7</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center text-muted small mt-3">
                &copy; {{ date('Y') }} BahariLines. All rights reserved. Made for professional ticketing services.
            </div>
        </div>
    </footer>

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

        @if(session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: "{{ session('info') }}",
                confirmButtonColor: '#0284c7'
            });
        @endif
    </script>

    @yield('scripts')
</body>
</html>
