<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-6">
                <p class="fw-semibold text-primary mb-1">
                    Laporan Hasil Akhir — hanya yang status seleksinya lolos.
                </p>
                <small class="text-muted">Data diambil dari hasil verifikasi kepala sekolah / pusat.</small>
            </div>
            <div class="col-6 text-end">
                <a href="{{ route('laporan-hasil-akhir') }}" class="btn btn-danger">
                    <i class="bi bi-printer"></i>
                    Download Laporan
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <h5 class="fw-bold mb-3">Hasil Akhir (Lolos Seleksi)</h5>

        @if($siswaList->isEmpty())
            <div class="alert alert-light-warning">
                Belum ada siswa yang lolos seleksi. Silakan lakukan verifikasi di menu Laporan Rekomendasi.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>NISN Siswa</th>
                            <th>Nama Siswa</th>
                            <th>Skor (AS)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswaList as $item)
                            <tr wire:key="hasil-akhir-{{ $item->id_siswa }}">
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{ $item->nisn }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->skor }}</td>
                                <td>
                                    <span class="badge bg-success">DITERIMA</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
