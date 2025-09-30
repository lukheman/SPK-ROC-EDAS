<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SMAN 1 Tanggetada - Admin App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      color: #fff;
      background: url('https://images.unsplash.com/photo-1516321497487-e288fb19713f') no-repeat center center/cover;
      background-attachment: fixed;
      position: relative;
      min-height: 100vh;
      scroll-behavior: smooth;
    }

    /* Overlay untuk seluruh halaman */
    body::before {
      content: "";
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.55);
      z-index: 0;
    }

    /* Konten di atas overlay */
    .content-wrapper {
      position: relative;
      z-index: 1;
    }

    /* Navbar */
    .navbar {
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(6px);
      z-index: 2;
    }
    .navbar a {
      color: #fff !important;
      font-weight: 500;
    }
    .navbar a:hover {
      color: #0dcaf0 !important;
    }

    /* Hero Section (tanpa background, biar ikut body) */
    .hero-section {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }
    .hero-content {
      animation: fadeInUp 1.2s ease;
    }
    .hero-content h1 {
      font-size: 3.5rem;
      font-weight: 700;
      text-shadow: 2px 2px 6px rgba(0,0,0,0.7);
    }
    .hero-content p {
      font-size: 1.25rem;
      margin-bottom: 2rem;
      opacity: 0.95;
    }
    .hero-btn {
      background: #0d6efd;
      border: none;
      padding: 12px 28px;
      font-size: 1rem;
      border-radius: 50px;
      transition: all 0.3s;
    }
    .hero-btn:hover {
      background: #0b5ed7;
      transform: translateY(-3px);
      box-shadow: 0 6px 15px rgba(0,0,0,0.3);
    }

    /* Section umum */
    .section {
      padding: 80px 0;
    }

    /* Card/box dengan background putih transparan */
    .glass-card {
      background: rgba(255,255,255,0.1);
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.2);
      backdrop-filter: blur(8px);
      color: #fff;
    }

    /* Footer */
    footer {
      background: rgba(0,0,0,0.6);
      color: #ccc;
      padding: 25px 0;
      text-align: center;
      z-index: 2;
      position: relative;
    }

    /* Animations */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
      .hero-content h1 {
        font-size: 2.5rem;
      }
      .hero-content p {
        font-size: 1rem;
      }
    }

    @stack('styles')
  </style>
</head>
<body>

<div class="content-wrapper">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand text-white fw-bold" href="#">SMAN 1 Tanggetada</a>
      <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="{{ route('landing')}}">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('login')}}">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>


  <!-- Dynamic Content -->
  <main class="container my-5">
    {{ $slot }}
  </main>

  <!-- Footer -->
  <footer>
    <div class="container">
      <p>&copy; 2025 SMAN 1 Tanggetada. All rights reserved. | <a href="#">Privacy Policy</a></p>
    </div>
  </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
