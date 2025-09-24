<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem pakar berbasis AI untuk diagnosis penyakit tanaman coklat dengan cepat dan akurat.">
    <meta name="keywords" content="tanaman coklat, diagnosis penyakit, kakao, cacao care, sistem pakar">
    <title>CacaoCare - Sistem Pakar Diagnosa Tanaman Coklat</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #D4A373;  /* Warm brown */
            --secondary-color: #588157; /* Fresh green */
            --accent-color: #E76F51;   /* Coral orange */
            --light-bg: #FEFAE0;       /* Soft cream */
            --dark-text: #283618;      /* Dark green */
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark-text);
            scroll-behavior: smooth; /* Tambah smooth scroll */
        }

        .navbar-custom {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }

        .navbar-custom .navbar-brand {
            color: var(--primary-color);
            font-weight: 700;
        }

        .navbar-custom .nav-link {
            color: var(--dark-text) !important;
            font-weight: 500;
        }

        .navbar-custom .nav-link:hover {
            color: var(--accent-color) !important;
        }

        .hero-section {
            background-color: var(--light-bg);
            color: var(--dark-text);
            padding: 120px 0;
        }

        .btn-primary {
            background-color: var(--accent-color);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #d15a3c;
            transform: translateY(-2px);
        }

        .disease-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            background-color: white;
        }

        .disease-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .disease-card img {
            border-radius: 15px 15px 0 0;
            object-fit: cover;
            height: 200px;
        }

        .cta-section {
            background-color: var(--primary-color);
            color: white;
            padding: 80px 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--dark-text);
        }

        .card-title {
            color: var(--primary-color);
            font-weight: 600;
        }

        footer {
            background-color: var(--dark-text);
            color: white;
            padding: 60px 0;
        }

        /* Modern Utilities */
        .shadow-custom {
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .rounded-custom {
            border-radius: 15px;
        }

        /* Animasi */
        .fade-up {
            animation: fadeUp 0.5s ease-out;
            opacity: 0; /* Mulai dari invisible */
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Tambah observer buat animasi on scroll */
        .fade-up.visible {
            opacity: 1;
        }

        /* Tambahan CSS untuk Login Page */
        .login-section {
            background-color: var(--light-bg);
            padding: 100px 0;
            min-height: 100vh;
        }

        .login-card {
            max-width: 400px;
            margin: 0 auto;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background-color: white;
            padding: 2rem;
        }

        .login-card .btn-primary {
            width: 100%;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid var(--secondary-color);
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(231, 111, 81, 0.25);
        }

        .login-title {
            color: var(--primary-color);
            font-weight: 700;
        }

        .disease-card {
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            padding: 1rem;
        }
        .gejala-card {
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            padding: 1rem;
        }
    </style>
        @stack('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                🌱 CacaoCare
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('landing')}}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('daftar-penyakit')}}">Penyakit</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about-us')}}">Tentang Kami</a>
                    </li>

@auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard')}}">Dashboard</a>
                    </li>

@else

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login')}}" wire:navigate>Login</a>
                    </li>
@endauth
                </ul>
            </div>
        </div>
    </nav>

        {{ $slot }}

    <!-- Footer -->
    <footer id="kontak">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>CacaoCare</h5>
                    <p>Sistem pakar untuk diagnosis penyakit tanaman coklat.</p>
                </div>
                <!-- <div class="col-md-6 text-md-end"> -->
                <!--     <p>© 2025 CacaoCare. All rights reserved.</p> -->
                <!--     <div class="social-links mt-2"> -->
                <!--         <a href="#" class="text-white me-3">Facebook</a> -->
                <!--         <a href="#" class="text-white me-3">Instagram</a> -->
                <!--         <a href="#" class="text-white">Email</a> -->
                <!--     </div> -->
                <!-- </div> -->
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script buat animasi on scroll -->
    <script>
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        });

        document.querySelectorAll('.fade-up').forEach(el => {
            observer.observe(el);
        });
    </script>

</body>
</html>
