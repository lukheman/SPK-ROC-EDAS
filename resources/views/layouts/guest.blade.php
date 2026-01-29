<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SMAN 1 Tanggetada - Admin App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  <style>
    :root {
      --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
      --light-gradient: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 50%, #f0f4f8 100%);
      --glass-bg: rgba(255, 255, 255, 0.85);
      --glass-border: rgba(0, 0, 0, 0.08);
      --text-primary: #1a1a2e;
      --text-secondary: #4a5568;
      --text-muted: #718096;
      --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      color: var(--text-primary);
      background: var(--light-gradient);
      min-height: 100vh;
      overflow-x: hidden;
      position: relative;
    }

    /* Animated background shapes */
    .bg-shapes {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
      overflow: hidden;
      pointer-events: none;
    }

    .shape {
      position: absolute;
      border-radius: 50%;
      animation: floatShape 20s infinite ease-in-out;
      opacity: 0.5;
    }

    .shape:nth-child(1) {
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(102, 126, 234, 0.15) 0%, transparent 70%);
      top: -150px;
      right: -150px;
      animation-delay: 0s;
    }

    .shape:nth-child(2) {
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(118, 75, 162, 0.12) 0%, transparent 70%);
      bottom: 5%;
      left: -100px;
      animation-delay: -7s;
    }

    .shape:nth-child(3) {
      width: 300px;
      height: 300px;
      background: radial-gradient(circle, rgba(79, 172, 254, 0.12) 0%, transparent 70%);
      top: 40%;
      right: 15%;
      animation-delay: -12s;
    }

    .shape:nth-child(4) {
      width: 350px;
      height: 350px;
      background: radial-gradient(circle, rgba(240, 147, 251, 0.1) 0%, transparent 70%);
      bottom: 25%;
      right: 5%;
      animation-delay: -5s;
    }

    @keyframes floatShape {

      0%,
      100% {
        transform: translate(0, 0) scale(1);
      }

      25% {
        transform: translate(20px, -20px) scale(1.05);
      }

      50% {
        transform: translate(-15px, 15px) scale(0.98);
      }

      75% {
        transform: translate(15px, 20px) scale(1.02);
      }
    }

    /* Content wrapper */
    .content-wrapper {
      position: relative;
      z-index: 1;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Navbar */
    .navbar {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 1px solid var(--glass-border);
      padding: 1rem 0;
      transition: all 0.3s ease;
      box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
    }

    .navbar.scrolled {
      background: rgba(255, 255, 255, 0.97);
      padding: 0.75rem 0;
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
    }

    .navbar-brand {
      font-weight: 700;
      font-size: 1.4rem;
      background: var(--primary-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .navbar-brand::before {
      content: "🎓";
      font-size: 1.5rem;
      -webkit-text-fill-color: initial;
    }

    .nav-link {
      color: var(--text-secondary) !important;
      font-weight: 500;
      padding: 0.5rem 1.25rem !important;
      border-radius: 50px;
      transition: all 0.3s ease;
      position: relative;
    }

    .nav-link:hover,
    .nav-link.active {
      color: var(--text-primary) !important;
      background: rgba(102, 126, 234, 0.1);
    }

    .nav-link.btn-login {
      background: var(--primary-gradient);
      color: white !important;
      padding: 0.5rem 1.5rem !important;
      margin-left: 0.5rem;
    }

    .nav-link.btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(102, 126, 234, 0.35);
    }

    .navbar-toggler {
      border: none;
      padding: 0.5rem;
      background: rgba(102, 126, 234, 0.1);
      border-radius: 8px;
    }

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2874, 85, 104, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    /* Hero Section */
    .hero-section {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 8rem 1rem 4rem;
      position: relative;
    }

    .hero-content {
      max-width: 800px;
      animation: fadeInUp 1s ease;
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: rgba(102, 126, 234, 0.1);
      border: 1px solid rgba(102, 126, 234, 0.2);
      padding: 0.5rem 1.25rem;
      border-radius: 50px;
      font-size: 0.875rem;
      font-weight: 500;
      color: #667eea;
      margin-bottom: 1.5rem;
    }

    .hero-badge i {
      color: #667eea;
    }

    .hero-content h1 {
      font-size: clamp(2.5rem, 5vw, 4rem);
      font-weight: 800;
      line-height: 1.1;
      margin-bottom: 1.5rem;
      color: var(--text-primary);
    }

    .hero-content h1 span {
      background: var(--primary-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .hero-content p {
      font-size: 1.25rem;
      color: var(--text-secondary);
      margin-bottom: 2.5rem;
      line-height: 1.7;
    }

    .hero-buttons {
      display: flex;
      gap: 1rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn-hero-primary {
      background: var(--primary-gradient);
      color: white;
      border: none;
      padding: 1rem 2rem;
      font-size: 1rem;
      font-weight: 600;
      border-radius: 50px;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
      text-decoration: none;
    }

    .btn-hero-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
      color: white;
    }

    .btn-hero-secondary {
      background: white;
      color: var(--text-primary);
      border: 1px solid var(--glass-border);
      padding: 1rem 2rem;
      font-size: 1rem;
      font-weight: 600;
      border-radius: 50px;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
      text-decoration: none;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .btn-hero-secondary:hover {
      background: #f8f9fa;
      transform: translateY(-3px);
      color: var(--text-primary);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    /* Stats Section */
    .hero-stats {
      display: flex;
      justify-content: center;
      gap: 3rem;
      margin-top: 4rem;
      padding-top: 3rem;
      border-top: 1px solid var(--glass-border);
    }

    .stat-item {
      text-align: center;
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: 700;
      background: var(--primary-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .stat-label {
      font-size: 0.875rem;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    /* Glass Card */
    .glass-card {
      background: var(--glass-bg);
      border-radius: 20px;
      padding: 2rem;
      border: 1px solid var(--glass-border);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      box-shadow: var(--card-shadow);
      transition: all 0.3s ease;
    }

    .glass-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
    }

    /* Section */
    .section {
      padding: 5rem 0;
    }

    /* Main content area */
    main {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    /* Footer */
    footer {
      background: rgba(255, 255, 255, 0.95);
      border-top: 1px solid var(--glass-border);
      color: var(--text-muted);
      padding: 2rem 0;
      text-align: center;
      margin-top: auto;
    }

    footer a {
      color: #667eea;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    footer a:hover {
      color: #764ba2;
    }

    /* Animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(40px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Responsive */
    @media (max-width: 768px) {
      .hero-stats {
        gap: 1.5rem;
        flex-wrap: wrap;
      }

      .stat-number {
        font-size: 2rem;
      }

      .hero-buttons {
        flex-direction: column;
        align-items: center;
      }

      .btn-hero-primary,
      .btn-hero-secondary {
        width: 100%;
        max-width: 280px;
        justify-content: center;
      }
    }

    @stack('styles')
  </style>
</head>

<body>

  <!-- Animated Background Shapes -->
  <div class="bg-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
  </div>

  <div class="content-wrapper">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
      <div class="container">
        <a class="navbar-brand" href="{{ route('landing') }}">SMAN 1 Tanggetada</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav align-items-center">
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('landing') ? 'active' : '' }}" href="{{ route('landing') }}">
                <i class="bi bi-house-door me-1"></i> Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn-login" href="{{ route('login') }}">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Dynamic Content -->
    <main>
      {{ $slot }}
    </main>

    <!-- Footer -->
    <footer>
      <div class="container">
        <p class="mb-0">© {{ date('Y') }} SMAN 1 Tanggetada. All rights reserved. | <a href="#">Privacy Policy</a></p>
      </div>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navbar scroll effect
    window.addEventListener('scroll', function () {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  </script>
</body>

</html>