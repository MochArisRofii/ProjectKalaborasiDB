<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Bangunan')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #121212; /* Background hitam */
            color: #f1f1f1; /* Teks putih */
            font-family: 'Arial', sans-serif;
        }
    
        /* Navbar */
        .navbar {
            background-color: #000; /* Background hitam */
            padding: 4px 12px; /* Padding lebih kecil */
            border-bottom: 1px solid #444; /* Border bawah lebih tipis */
        }
    
        .navbar-brand {
            color: #fff !important; /* Teks putih pada navbar */
            font-weight: 400;
            font-size: 1.5rem; /* Ukuran font diperbesar */
            letter-spacing: 0.8px;
            transition: color 0.3s ease, transform 0.3s ease;
        }
    
        .navbar-brand:hover {
            color: #ff6f00 !important; /* Warna teks oranye saat hover */
            transform: scale(1.05); /* Efek perbesaran saat hover */
        }
    
        .nav-link {
            color: #fff !important; /* Teks putih pada navbar */
            font-weight: 400;
            letter-spacing: 0.8px;
            font-size: 0.9rem; /* Ukuran font lebih kecil */
            transition: color 0.3s ease, transform 0.3s ease;
        }
    
        .nav-link:hover {
            color: #ff6f00 !important; /* Warna teks oranye saat hover */
            transform: scale(1.05); /* Efek perbesaran saat hover */
        }
    
        .navbar-toggler-icon {
            background-color: #fff; /* Icon toggle berwarna putih */
        }
    
        /* Dropdown Style */
        .dropdown-item {
            background-color: transparent;
            color: #f1f1f1;
            transition: background-color 0.3s ease, color 0.3s ease;
            padding: 8px 20px; /* Padding lebih besar agar lebih nyaman diklik */
        }
    
        .dropdown-item:hover {
            background-color: rgba(255, 105, 0, 0.2); /* Efek hover dengan latar belakang oranye transparan */
            color: #ff6f00; /* Warna teks oranye saat hover */
        }
    
        .dropdown-menu {
            background-color: #1f1f1f; /* Latar belakang dropdown gelap */
            border-radius: 5px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3); /* Bayangan lembut */
            transition: opacity 0.3s ease, transform 0.3s ease;
            opacity: 0; /* Menyembunyikan dropdown awalnya */
            transform: translateY(-10px); /* Dropdown dimulai dari posisi lebih tinggi */
        }
    
        .dropdown-menu.show {
            opacity: 1; /* Menampilkan dropdown secara halus */
            transform: translateY(0); /* Menurunkan posisi dropdown ke tempatnya */
        }
    
        /* Button */
        .btn {
            border-radius: 30px; /* Tombol dengan sudut bulat */
            padding: 6px 12px;
            background-color: #ff6f00; /* Warna oranye */
            color: #fff;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
    
        .btn:hover {
            background-color: #ff8c00; /* Warna tombol lebih terang saat hover */
            transform: scale(1.05); /* Efek perbesaran saat hover */
        }
    
        /* Container */
        .container {
            background: rgba(0, 0, 0, 0.6); /* Transparansi gelap di container */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Bayangan halus */
        }
    
        /* Footer */
        footer {
            background-color: #222;
            padding: 20px;
            text-align: center;
            color: #fff;
            margin-top: 50px;
        }
    
        footer a {
            color: #ff6f00;
            text-decoration: none;
        }
    
        footer a:hover {
            text-decoration: underline;
        }
    
        /* Card */
        .card {
            background: rgba(255, 255, 255, 0.1); /* Latar belakang transparan pada card */
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: white;
        }
    
        .card:hover {
            transform: translateY(-10px); /* Efek terangkat saat hover */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3); /* Efek bayangan lebih kuat */
        }
    </style>
    
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            @auth
                @if (auth()->user()->role === 'admin')
                    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Toko Bangunan</a>
                @elseif(auth()->user()->role === 'kasir')
                    <a class="navbar-brand" href="{{ route('kasir.dashboard') }}">Toko Bangunan</a>
                @endif
            @endauth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('produk.index') }}">Produk</a>
                            </li>
                        @elseif(auth()->user()->role === 'kasir')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('kasir.produk.index') }}">Produk</a>
                            </li>
                        @endif
                        @if (auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('transaksi.index') }}">Transaksi</a>
                            </li>
                        @elseif(auth()->user()->role === 'kasir')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('kasir.transaksi.index') }}">Transaksi</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Halo, {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Toko Bangunan. All rights reserved. <a href="#">Privacy Policy</a></p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
