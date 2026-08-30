@php

use App\Enums\State;

@endphp
<div class="card">
    <div class="card-header">
        <div class="row">

            <div class="col-6">
@if ($laporan)

                <a href="{{ route('laporan-hasil-seleksi')}}" wire:click="add" class="btn btn-danger me-3">

<i class="bi bi-printer"></i>
Download Laporan</a>

@else

 <p class="fw-semibold text-primary mb-3">
        Berikut adalah daftar hasil seleksi siswa beserta status kelulusannya:
    </p>

                <!-- <div class="input-group"> -->
                <!--     <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span> -->
                <!--     <input type="text" wire:model.live="search" class="form-control" placeholder="Cari siswa..." -->
                <!--         aria-label="Recipient's username" aria-describedby="button-addon2"> -->
                <!-- </div> -->

@endif
            </div>
            <div class="col-6">


                <!-- Modal Form -->
                <div class="modal fade" id="{{ $idModal }}" tabindex="-1" wire:ignore.self>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content shadow-lg rounded-3">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title text-white" id="myModalLabel1">
                                    @if ($currentState === \App\Enums\State::CREATE)
                                        Tambah Ranking
                                    @elseif ($currentState === \App\Enums\State::UPDATE)
                                        Perbarui Ranking
                                    @elseif ($currentState === \App\Enums\State::SHOW)
                                        Detail Ranking
                                    @endif
                                </h5>
                                <button type="button" class="close rounded-pill"
                                    wire:click="$dispatch('closeModal', {id: 'modal-form-Ranking'})">
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
                                <form>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="nisn">NISN Ranking</label>
                                                <input wire:model="form.nisn" type="text"
                                                    class="form-control" id="nisn" @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                                @error('form.nisn')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="form-group">
                                                <label for="nama">Nama Ranking</label>
                                                <input wire:model="form.nama" type="text"
                                                    class="form-control" id="nama" @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                                @error('form.nama')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                @if ($currentState === \App\Enums\State::CREATE)
                                    <button type="button" wire:click="save"
                                        class="btn btn-primary">Tambahkan</button>
                                @elseif ($currentState === \App\Enums\State::UPDATE)
                                    <button type="button" wire:click="save"
                                        class="btn btn-primary">Perbarui</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>

    <div class="card-body">
        
        @if(!$laporan)
        <div class="accordion mb-4" id="accordionCalculation">
            
            <!-- Step 1: Bobot Kriteria & Rata-rata -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        1. Bobot ROC & Rata-rata Kriteria (AV)
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionCalculation">
                    <div class="accordion-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode / Nama Kriteria</th>
                                        <th>Tipe</th>
                                        <th>Rata-rata (AV)</th>
                                        <th>Bobot ROC (W)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kriteriaList as $kriteria)
                                    <tr>
                                        <td>{{ $kriteria->nama }}</td>
                                        <td>{{ ucfirst($kriteria->tipe) }}</td>
                                        <td>{{ $avgKriteria[$kriteria->id_kriteria] ?? 0 }}</td>
                                        <td>{{ $bobotROC[$kriteria->id_kriteria] ?? 0 }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Matriks Jarak PDA & NDA -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        2. Matriks Jarak (PDA & NDA)
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionCalculation">
                    <div class="accordion-body">
                        <div class="table-responsive mb-3">
                            <h6 class="fw-bold">Positive Distance from Average (PDA)</h6>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        @foreach($kriteriaList as $kriteria)
                                        <th>{{ $kriteria->nama }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siswaList as $siswa)
                                    <tr>
                                        <td>{{ $siswa->nama }}</td>
                                        @foreach($kriteriaList as $kriteria)
                                        <td>{{ $siswa->pda_values[$kriteria->id_kriteria] ?? 0 }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <h6 class="fw-bold">Negative Distance from Average (NDA)</h6>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        @foreach($kriteriaList as $kriteria)
                                        <th>{{ $kriteria->nama }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siswaList as $siswa)
                                    <tr>
                                        <td>{{ $siswa->nama }}</td>
                                        @foreach($kriteriaList as $kriteria)
                                        <td>{{ $siswa->nda_values[$kriteria->id_kriteria] ?? 0 }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: SP, SN, NSP, NSN -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        3. Perhitungan SP, SN & Normalisasi (NSP, NSN)
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionCalculation">
                    <div class="accordion-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>SP (Sum PDA*W)</th>
                                        <th>SN (Sum NDA*W)</th>
                                        <th>NSP (SP / Max SP)</th>
                                        <th>NSN (1 - (SN / Max SN) atau SN/Max SN)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siswaList as $siswa)
                                    <tr>
                                        <td>{{ $siswa->nama }}</td>
                                        <td>{{ $siswa->hasil_penjumlahan_jarak_positif }}</td>
                                        <td>{{ $siswa->hasil_penjumlahan_jarak_negatif }}</td>
                                        <td>{{ $siswa->nsp }}</td>
                                        <td>{{ $siswa->nsn }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nilai Maksimum</th>
                                        <th>{{ $max_sp }}</th>
                                        <th>{{ $max_sn }}</th>
                                        <th colspan="2"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endif

        <h5 class="fw-bold mb-3">Hasil Akhir (Ranking)</h5>
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
                        <tr wire:key="{{ $item->id }}">
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $item->nisn }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->skor }}</td>
                            <td>
                                @if(isset($item->lolos) && $item->lolos)
                                    <span class="badge bg-success">Lolos</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Lolos</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
