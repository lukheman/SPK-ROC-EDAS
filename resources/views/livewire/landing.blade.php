<div>

    <section class="hero-section" id="beranda">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 fade-up">
                    <h1 class="display-4 fw-bold mb-4">Jaga Kesehatan Tanaman Coklat Anda</h1>
                    <p class="lead mb-4">Sistem pakar berbasis AI untuk mendiagnosa penyakit tanaman coklat dengan cepat dan akurat.</p>
                    <a href="{{ route('konsultasi')}}" class="btn btn-primary btn-lg">Mulai Diagnosis</a>
                </div>
                <div class="col-lg-6 fade-up" style="animation-delay: 0.2s;">
                    <!-- <img src="https://source.unsplash.com/random/600x400/?cacao,plant" alt="Tanaman Coklat" class="img-fluid rounded-custom shadow-custom"> -->
                </div>
            </div>
        </div>
    </section>

    <!-- Diseases Section -->
<section class="py-5" id="penyakit">
    <div class="container">
        <h2 class="section-title text-center mb-5 fade-up">Penyakit Umum Tanaman Coklat</h2>
        <div class="row g-4">

            @foreach ($penyakit as $item)
            <div class="col-md-4 fade-up">
                <div class="disease-card h-100 d-flex flex-column">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $item->nama }}</h5>
                        <p class="card-text flex-grow-1">{{ $item->deskripsi }}</p>
                        <!-- <a href="#" class="btn btn-primary mt-auto">Pelajari Lebih Lanjut</a> -->
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>

    <!-- Call to Action -->
    <!-- <section class="cta-section" id="diagnosa"> -->
    <!--     <div class="container text-center fade-up"> -->
    <!--         <h2 class="mb-4">Siap Mendiagnosa Tanaman Coklat Anda?</h2> -->
    <!--         <p class="lead mb-4">Gunakan sistem pakar kami untuk mendeteksi penyakit pada tanaman coklat Anda sekarang juga!</p> -->
    <!--         <button class="btn btn-light btn-lg px-5">Mulai Diagnosis</button> -->
    <!--     </div> -->
    <!-- </section> -->
</div>
