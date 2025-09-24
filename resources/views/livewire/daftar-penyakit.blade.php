<div class="container py-5 mt-5" id="penyakit">
    <div class="text-center mb-5">
        <h2 class="section-title">Daftar Penyakit Tanaman Kakao</h2>
        <p class="text-muted">Informasi mengenai penyakit, deskripsi, dan solusi penanganannya</p>
    </div>

    <!-- Search -->
    <div class="mb-4">
        <input type="text" class="form-control" placeholder="Cari penyakit..." wire:model.live="search">
    </div>

    <div class="row g-4">
        @foreach ($this->penyakitList as $penyakit)
            <div class="col-md-4 fade-up">
                <div class="disease-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $penyakit->nama }}</h5>
                        <h6 class="text-muted">Kode: {{ $penyakit->kode }}</h6>
                        <p class="mt-3">{{ Str::limit($penyakit->deskripsi, 120) }}</p>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#penyakitModal{{ $penyakit->id }}">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Detail Penyakit -->
            <div class="modal fade" id="penyakitModal{{ $penyakit->id }}" tabindex="-1" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-lg">
                    <div class="modal-content rounded-custom shadow-custom">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $penyakit->nama }} ({{ $penyakit->kode }})</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <h6>Deskripsi</h6>
                            <p>{{ $penyakit->deskripsi ?? '-' }}</p>
                            <h6>Solusi</h6>
                            <p>{{ $penyakit->solusi ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $this->penyakitList->links() }}
    </div>
</div>
