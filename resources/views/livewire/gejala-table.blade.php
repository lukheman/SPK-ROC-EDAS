<div class="card">


    <div class="card-header">
        <div class="row">
            <div class="col-6">

                <!-- Modal Form -->
                <div class="modal fade" id="{{ $idModal }}" tabindex="-1" wire:ignore.self>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content shadow-lg rounded-3">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title text-white" id="myModalLabel1">
                                    @if ($currentState === \App\Enums\State::CREATE)
                                        Tambah Gejala
                                    @elseif ($currentState === \App\Enums\State::UPDATE)
                                        Perbarui Gejala
                                    @elseif ($currentState === \App\Enums\State::SHOW)
                                        Detail Gejala
                                    @endif
                                </h5>
                                <button type="button" class="close rounded-pill"
                                    wire:click="$dispatch('closeModal', {id: 'modal-form-gejala'})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            <form wire:submit="save">
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label for="kode">Kode Gejala</label>
                                            <input wire:model="form.kode" type="text"
                                                class="form-control" id="kode" @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                            @error('form.kode')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                    </div>
                                            <div class="form-group">
                                                <label for="nama">Nama Gejala</label>
                                                <input wire:model="form.nama" type="text"
                                                    class="form-control" id="nama" @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                                @error('form.nama')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                    <div class="form-group">

                                    <label for="bobot">Bobot</label>
                                    <input wire:model="form.bobot" step="0.01" type="number" class="form-control" id="bobot"                class="form-control" id="kode" @if ($currentState === \App\Enums\State::SHOW) disabled @endif>

                                    @error('form.bobot')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror

                            </div>

                            </div>
                            <div class="modal-footer">
                                @if ($currentState === \App\Enums\State::CREATE)
                                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                                @elseif ($currentState === \App\Enums\State::UPDATE)
                                    <button type="submit" class="btn btn-primary">Perbarui</button>
                                @endif
                            </div>

                                </form>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" wire:model.live="search" class="form-control" placeholder="Cari gejala..."
                        aria-label="Recipient's username" aria-describedby="button-addon2">
                </div>
            </div>
            <div class="col-6 d-flex justify-content-end">

                <button wire:click="add" class="btn btn-primary me-3">Tambah Gejala</button>

            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Gejala</th>
                        <th>Nama Gejala</th>
                        <th>Bobot</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->gejala as $item)

                    <tr wire:key="{{ $item->id }}">
                        <td scope="row">{{ $loop->index + $this->gejala->firstItem() }}</td>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->nama }}</td>
                        <td><span class="badge bg-secondary">{{ $item->bobot }}</span></td>
                        <td class="text-end">

                                <!-- <button wire:click="detail({{ $item->id }})" class="btn btn-sm btn-info">Lihat</button> -->
                                    <button wire:click="edit({{ $item->id }})"
                                        class="btn btn-sm btn-warning" type="button">Edit</button>
                                    <button wire:click="delete({{ $item->id }})"
                                        class="btn btn-sm btn-danger" type="button">Hapus</button>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>

            <x-pagination :items="$this->gejala"></x-pagination>
        </div>



    </div>

</div>



