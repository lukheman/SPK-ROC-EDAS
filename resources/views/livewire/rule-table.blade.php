<div class="card">

                <!-- Modal Form -->
                <div class="modal fade" id="{{ $idModal }}" tabindex="-1" wire:ignore.self>
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content shadow-lg rounded-3">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title text-white" id="myModalLabel1">
                                    @if ($currentState === \App\Enums\State::CREATE)
                                        Tambah Gejala
                                    @elseif ($currentState === \App\Enums\State::UPDATE)
                                        Perbarui Gejala Penyakit {{ $selectedPenyakit->nama ?? ''}}
                                    @elseif ($currentState === \App\Enums\State::SHOW)
                                        Detail Gejala Penyakit {{ $selectedPenyakit->nama ?? ''}}
                                    @endif
                                </h5>
                                <button type="button" class="close rounded-pill"
                                    wire:click="$dispatch('closeModal', {id: 'modal-rule'})">
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


            @if ($currentState === \App\Enums\State::UPDATE)


                @if (isset($listGejala))

            <table class="table table-bordered">

                <thead>
                    <tr>
                <th>Kode Gejala</th>
                <th>Nama Gejala</th>
                <th>Bobot</th>
                <th>Pilih</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($listGejala as $gejala)
                <tr>
                <td>{{ $gejala->kode}}</td>
                <td>{{ $gejala->nama}}</td>
                <td>
                    <span class="badge bg-secondary">{{ $gejala->bobot}}</span>
                </td>
                <td>

                    <div class="checkbox form-check form-check-lg">
                        <input wire:model="id_gejala_terpilih" id="gejala-{{ $gejala->id }}" value="{{ $gejala->id }}" type="checkbox" class="form-check-input">

                </td>
                </tr>
                @endforeach
                </tbody>

            </table>



                @endif


            @elseif($currentState === \App\Enums\State::SHOW)
            @if (isset($selectedPenyakit))
            <table class="table table-bordered">

                <thead>
                    <tr>
                <th>Kode Gejala</th>
                <th>Nama Gejala</th>
                <th>Bobot</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($selectedPenyakit->gejala as $gejala)
                <tr>
                <td>{{ $gejala->kode}}</td>
                <td>{{ $gejala->nama}}</td>
                    <td>
                    <span class="badge bg-secondary">{{ $gejala->bobot}}</span>
                        </td>
                </tr>
                @endforeach
                </tbody>

            </table>


            @endif

            @endif
                            </div>
                            <div class="modal-footer">
                                @if ($currentState === \App\Enums\State::UPDATE)
                                    <button type="button" class="btn btn-primary" wire:click="save">Simpan Perubahan</button>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" wire:model.live="search" class="form-control" placeholder="Cari gejala..."
                        aria-label="Recipient's username" aria-describedby="button-addon2">
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Penyakit</th>
                        <th>Nama Penyakit</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->penyakit as $item)

                    <tr wire:key="{{ $item->id }}">
                        <td scope="row">{{ $loop->index + 1 }}</td>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->nama }}</td>
                        <td class="text-end">
                            <button wire:click="detail({{ $item->id }})" class="btn btn-sm btn-primary" type="button">Lihat Gejala</button>
                            <button wire:click="edit({{ $item->id }})" class="btn btn-sm btn-warning" type="button">Edit Gejala</button>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>

        </div>



    </div>

</div>
