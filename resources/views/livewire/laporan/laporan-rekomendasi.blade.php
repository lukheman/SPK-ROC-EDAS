<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-6">
                <p class="fw-semibold text-primary mb-1">
                    Laporan Rekomendasi — semua hasil seleksi dari admin.
                </p>
                <small class="text-muted">
                    @if(auth('kepala_sekolah')->check())
                    Ubah status seleksi melalui kolom Aksi Verifikasi.
                    @else
                    Status seleksi ditentukan melalui verifikasi kepala sekolah / pusat.
                    @endif
                </small>
            </div>
            <div class="col-6 text-end">
                <a href="{{ route('laporan-rekomendasi') }}" class="btn btn-danger">
                    <i class="bi bi-printer"></i>
                    Download Laporan
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <h5 class="fw-bold mb-3">Hasil Seleksi (Rekomendasi)</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>NISN Siswa</th>
                        <th>Nama Siswa</th>
                        <th>Skor (AS)</th>
                        <th>Status Seleksi</th>
                        @if(auth('kepala_sekolah')->check())
                        <th class="text-end">Aksi Verifikasi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswaList as $item)
                        <tr wire:key="rekomendasi-{{ $item->id_siswa }}">
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $item->nisn }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->skor }}</td>
                            <td>
                                @if($item->lolos)
                                    <span class="badge bg-success">Lolos Seleksi</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Lolos</span>
                                @endif
                                @if(!empty($item->terverifikasi))
                                    <small class="d-block text-muted">Terverifikasi</small>
                                @endif
                            </td>
                            @if(auth('kepala_sekolah')->check())
                            <td class="text-end">
                                @if(!$item->lolos)
                                    <button wire:click="terima({{ $item->id_siswa }})"
                                        class="btn btn-sm btn-success" type="button">
                                        Terima
                                    </button>
                                @endif
                                @if($item->lolos)
                                    <button wire:click="tolak({{ $item->id_siswa }})"
                                        class="btn btn-sm btn-outline-danger" type="button">
                                        Tolak
                                    </button>
                                @endif
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth('kepala_sekolah')->check() ? 6 : 5 }}" class="text-center text-muted">Belum ada data seleksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
