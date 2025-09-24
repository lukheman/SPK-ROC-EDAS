@push('styles')

<style>
    .info-table {
        width: 100%;
        border-collapse: collapse;
    }
    .info-table td:first-child {
        width: 150px;        /* atur sesuai kebutuhan */
        font-weight: 600;
        vertical-align: top;
    }
    .colon {
        display: inline-block;
        width: 15px;         /* supaya semua titik dua rata */
        text-align: center;
    }
</style>


@endpush
<div class="card">

    <!-- Modal Form -->
                <div class="modal fade" id="{{ $idModal }}" tabindex="-1" wire:ignore.self>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content shadow-lg rounded-3">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title text-white" id="myModalLabel1">
                Hasil Diangosis
                                </h5>
                                <button type="button" class="close rounded-pill"
                                    wire:click="$dispatch('closeModal', {id: 'modal-riwayat'})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">


                    <!-- Data Konsultan -->
<div class="mb-4">
    <h6 class="fw-semibold text-primary border-bottom pb-2">Data Konsultan</h6>
    <table class="info-table mt-3">
        <tr>
            <td>Nama</td>
            <td><span class="colon">:</span> {{ $riwayatKonsultasi->nama ?? '' }}</td>
        </tr>
        <tr>
            <td>Umur</td>
            <td><span class="colon">:</span> {{ $riwayatKonsultasi->umur ?? '' }} tahun</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td><span class="colon">:</span> {{ $riwayatKonsultasi->jenis_kelamin ?? '' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><span class="colon">:</span> {{ $riwayatKonsultasi->alamat ?? '' }}</td>
        </tr>
    </table>
</div>

                    <!-- Hasil -->
                    <div class="p-3 bg-light rounded-3 border mb-4">
                        <p class="mb-0">
                            Terdeteksi menderita penyakit
                            <b>{{ $riwayatKonsultasi->penyakit->nama ?? ''}}</b>
                            dengan persentase keyakinan
                            <span class="badge bg-primary">{{ $riwayatKonsultasi->belief ?? '' }}%</span>
                        </p>
                    </div>

                    <!-- Detail Penyakit -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark">Deskripsi Penyakit</h6>
                        <p class="text-muted">{{ $riwayatKonsultasi->penyakit->deskripsi ?? ''}}</p>

                        <h6 class="fw-bold text-dark">Solusi</h6>
                        <p class="text-muted">{{ $riwayatKonsultasi->penyakit->solusi ?? '' }}</p>
                    </div>


                            </div>
                            <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-primary">Tutup</button> -->
                            </div>

                        </div>
                    </div>
                </div>

    <div class="card-header">
        <div class="row">
            <div class="col-6">


                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" wire:model.live="search" class="form-control" placeholder="Cari riwayat konsultasi..." >
                </div>
            </div>
            <div class="col-6">

                <a href="{{ route('laporan-riwayat-konsultasi')}}" class="btn btn-danger float-end">
                    <i class="bi bi-printer"></i>
                    Cetak Laporan
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Umur</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Tanggal Konsultasi</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->riwayat as $item)

                    <tr wire:key="{{ $item->id }}">
                        <td scope="row">{{ $loop->index + 1 }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->umur }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->tanggal_konsultasi}}</td>
                        <td class="text-end">
                            <a href="{{ route('laporan-riwayat-konsultasi-satu', ['id' => $item->id])}}"  class="btn btn-sm btn-danger" type="button">Download</a>
                            <button wire:click="detail({{ $item->id }})" class="btn btn-sm btn-primary" type="button">Lihat Hasil Diagnosis</button>
                            <button wire:click="delete({{ $item->id }})" class="btn btn-sm btn-danger" type="button">Hapus</button>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>

        </div>



    </div>

</div>
