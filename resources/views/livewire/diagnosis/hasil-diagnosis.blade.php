<!-- Hasil Diagnosis Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="gejala-card">
                    
                    <!-- Judul -->
                    <h4 class="text-center mb-4 fw-bold" style="color: var(--primary-color);">
                        Hasil Diagnosis
                    </h4>

                    <!-- Data Konsultan -->
                    <div class="mb-4">
                        <h5 class="fw-semibold text-primary border-bottom pb-2">Data Konsultan</h5>
                        <ul class="list-unstyled mt-3 mb-0">
                            <li><b>Nama:</b> {{ $nama }}</li>
                            <li><b>Umur:</b> {{ $umur }} tahun</li>
                            <li><b>Jenis Kelamin:</b> {{ $jenis_kelamin }}</li>
                            <li><b>Alamat:</b> {{ $alamat }}</li>
                        </ul>
                    </div>

                    <!-- Hasil -->
                    <div class="p-3 bg-light rounded-3 border mb-4">
                        <p class="mb-0">
                            Terdeteksi menderita penyakit 
                            <b>{{ $penyakit->nama }}</b> 
                            dengan persentase keyakinan 
                            <span class="badge bg-primary">{{ $penyakit->belief }}%</span>
                        </p>
                    </div>

                    <!-- Detail Penyakit -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark">Deskripsi Penyakit</h6>
                        <p class="text-muted">{{ $penyakit->deskripsi }}</p>

                        <h6 class="fw-bold text-dark">Solusi</h6>
                        <p class="text-muted">{{ $penyakit->solusi }}</p>
                    </div>

                    <!-- Tombol -->
                    <button wire:click="restartDiagnosisFlow" class="btn btn-primary px-4">
                        Ulangi Diagnosis
                    </button>

                </div>
            </div>
        </div>
    </div>
</section>
