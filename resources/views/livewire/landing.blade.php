<div>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="hero-content">
      <!-- Badge -->
      <div class="hero-badge">
        <i class="bi bi-stars"></i>
        <span>Sistem Pendukung Keputusan</span>
      </div>

      <!-- Main Heading -->
      <h1>
        <span>SMAN 1 Tanggetada</span>
      </h1>

      <!-- Description -->
      <p>
        Platform modern untuk mengelola data sekolah dengan metode ROC dan EDAS.
        Pengambilan keputusan yang lebih cepat, akurat, dan terstruktur.
      </p>

      <!-- Action Buttons -->
      <div class="hero-buttons">
        <a href="{{ route('login') }}" class="btn-hero-primary">
          <i class="bi bi-rocket-takeoff"></i>
          Mulai Sekarang
        </a>
        <a href="#features" class="btn-hero-secondary">
          <i class="bi bi-play-circle"></i>
          Lihat Fitur
        </a>
      </div>

      <!-- Stats -->
      <div class="hero-stats">
        <div class="stat-item">
          <div class="stat-number">ROC</div>
          <div class="stat-label">Pembobotan</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">EDAS</div>
          <div class="stat-label">Perankingan</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">100%</div>
          <div class="stat-label">Akurat</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="section">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold mb-3" style="font-size: 2.5rem; color: #1a1a2e;">
          Fitur <span
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Unggulan</span>
        </h2>
        <p style="color: #718096;">
          Sistem yang dirancang untuk membantu pengambilan keputusan di sekolah
        </p>
      </div>

      <div class="row g-4">
        <!-- Feature 1 -->
        <div class="col-md-4">
          <div class="glass-card h-100 text-center">
            <div class="feature-icon mb-4"
              style="width: 70px; height: 70px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);">
              <i class="bi bi-bar-chart-line-fill" style="font-size: 2rem; color: white;"></i>
            </div>
            <h4 class="fw-bold mb-3" style="color: #1a1a2e;">Metode ROC</h4>
            <p style="color: #718096;">
              Rank Order Centroid untuk menentukan bobot kriteria secara objektif berdasarkan urutan prioritas.
            </p>
          </div>
        </div>

        <!-- Feature 2 -->
        <div class="col-md-4">
          <div class="glass-card h-100 text-center">
            <div class="feature-icon mb-4"
              style="width: 70px; height: 70px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3);">
              <i class="bi bi-graph-up-arrow" style="font-size: 2rem; color: white;"></i>
            </div>
            <h4 class="fw-bold mb-3" style="color: #1a1a2e;">Metode EDAS</h4>
            <p style="color: #718096;">
              Evaluation Based on Distance from Average Solution untuk perankingan alternatif terbaik.
            </p>
          </div>
        </div>

        <!-- Feature 3 -->
        <div class="col-md-4">
          <div class="glass-card h-100 text-center">
            <div class="feature-icon mb-4"
              style="width: 70px; height: 70px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3);">
              <i class="bi bi-shield-check" style="font-size: 2rem; color: white;"></i>
            </div>
            <h4 class="fw-bold mb-3" style="color: #1a1a2e;">Keputusan Akurat</h4>
            <p style="color: #718096;">
              Hasil analisis yang terukur dan dapat dipertanggungjawabkan untuk pengambilan keputusan.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

</div>