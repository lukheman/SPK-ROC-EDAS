@php
use App\Enums\State;
@endphp
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">

                <!-- Modal Form Kriteria -->
                <div class="modal fade" id="{{ $idModal }}" tabindex="-1" wire:ignore.self>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content shadow-lg rounded-3">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title text-white" id="myModalLabel1">
                                    @if ($currentState === State::CREATE)
                                        Tambah Kriteria
                                    @elseif ($currentState === State::UPDATE)
                                        Perbarui Kriteria
                                    @elseif ($currentState === State::SHOW)
                                        Detail Kriteria
                                    @endif
                                </h5>
                                <button type="button" class="close rounded-pill"
                                    wire:click="$dispatch('closeModal', {id: '{{ $idModal }}'})">
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
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="kode">Kode Kriteria</label>
                                                <input wire:model="form.kode" type="text"
                                                    class="form-control" id="kode" placeholder="misal: pekerjaan_ayah"
                                                    @if ($currentState === State::SHOW) disabled @endif>
                                                @error('form.kode')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="nama">Nama Kriteria</label>
                                                <input wire:model="form.nama" type="text"
                                                    class="form-control" id="nama" placeholder="misal: Pekerjaan Ayah"
                                                    @if ($currentState === State::SHOW) disabled @endif>
                                                @error('form.nama')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="tipe">Tipe</label>
                                                <select wire:model="form.tipe" id="tipe"
                                                    class="form-control"
                                                    @if ($currentState === State::SHOW) disabled @endif>
                                                    <option value="benefit">Benefit (semakin tinggi semakin baik)</option>
                                                    <option value="cost">Cost (semakin rendah semakin baik)</option>
                                                </select>
                                                @error('form.tipe')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="urutan">Urutan Prioritas</label>
                                                <input wire:model="form.urutan" type="number"
                                                    class="form-control" id="urutan" min="1"
                                                    @if ($currentState === State::SHOW) disabled @endif>
                                                @error('form.urutan')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                @if ($currentState === State::SHOW && $form->kriteria)
                                    <hr class="mt-4 mb-3">
                                    <h6 class="font-weight-bold mb-3">Info Sub Kriteria</h6>
                                    @if ($form->kriteria->subKriteria && $form->kriteria->subKriteria->count() > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach ($form->kriteria->subKriteria as $sub)
                                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                    {{ $sub->nama }}
                                                    <span class="badge bg-primary rounded-pill">Nilai: {{ $sub->nilai }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="alert alert-light-secondary py-2" role="alert">
                                            <p class="mb-0 small"><i class="bi bi-info-circle me-1"></i> Kriteria ini tidak memiliki sub kriteria (menggunakan input angka bebas).</p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="modal-footer">
                                @if ($currentState === State::CREATE)
                                    <button type="button" wire:click="save"
                                        class="btn btn-primary">Tambahkan</button>
                                @elseif ($currentState === State::UPDATE)
                                    <button type="button" wire:click="save"
                                        class="btn btn-primary">Perbarui</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Sub Kriteria -->
                <div class="modal fade" id="{{ $idModalSub }}" tabindex="-1" wire:ignore.self>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                        <div class="modal-content shadow-lg rounded-3">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title text-white">
                                    Sub Kriteria — {{ $selectedKriteriaName }}
                                </h5>
                                <button type="button" class="close rounded-pill"
                                    wire:click="$dispatch('closeModal', {id: '{{ $idModalSub }}'})">
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
                                <!-- Add/Edit Sub Kriteria Form -->
                                <div class="card mb-3" style="background-color: #f8f9fa;">
                                    <div class="card-body py-3">
                                        <div class="row align-items-end">
                                            <div class="col-5">
                                                <div class="form-group mb-0">
                                                    <label for="subNama">Nama Pilihan</label>
                                                    <input wire:model="subNama" type="text" class="form-control"
                                                        id="subNama" placeholder="misal: Ya, Tidak, PNS...">
                                                    @error('subNama')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group mb-0">
                                                    <label for="subNilai">Nilai</label>
                                                    <input wire:model="subNilai" type="number" class="form-control"
                                                        id="subNilai" placeholder="0">
                                                    @error('subNilai')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-4 d-flex gap-2">
                                                <button wire:click="addSub" class="btn btn-{{ $editingSubId ? 'warning' : 'primary' }} btn-sm">
                                                    {{ $editingSubId ? 'Perbarui' : 'Tambah' }}
                                                </button>
                                                @if ($editingSubId)
                                                    <button wire:click="cancelEditSub" class="btn btn-secondary btn-sm">Batal</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sub Kriteria List -->
                                @if (count($subKriteriaList) > 0)
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Pilihan</th>
                                                <th>Nilai</th>
                                                <th class="text-end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subKriteriaList as $index => $sub)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $sub['nama'] }}</td>
                                                    <td><span class="badge bg-primary">{{ $sub['nilai'] }}</span></td>
                                                    <td class="text-end">
                                                        <button wire:click="editSub({{ $sub['id_sub_kriteria'] }})" class="btn btn-sm btn-warning">Edit</button>
                                                        <button wire:click="deleteSub({{ $sub['id_sub_kriteria'] }})" class="btn btn-sm btn-danger">Hapus</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center text-muted py-3">
                                        <p>Belum ada sub kriteria. Tambahkan pilihan di atas.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" wire:model.live="search" class="form-control" placeholder="Cari Kriteria..."
                        aria-label="Search" aria-describedby="button-addon2">
                </div>
            </div>

            <div class="col-6 d-flex justify-content-end">
                <button wire:click="add" class="btn btn-primary me-3">Tambah Kriteria</button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Urutan</th>
                        <th>Sub Kriteria</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->kriteria as $item)
                        <tr wire:key="{{ $item->id_kriteria }}">
                            <td scope="row">{{ $loop->index + $this->kriteria->firstItem() }}</td>
                            <td><code>{{ $item->kode }}</code></td>
                            <td>{{ $item->nama }}</td>
                            <td>
                                <span class="badge bg-{{ $item->tipe === 'benefit' ? 'success' : 'warning' }}">
                                    {{ ucfirst($item->tipe) }}
                                </span>
                            </td>
                            <td>{{ $item->urutan }}</td>
                            <td>
                                <span class="badge bg-{{ $item->sub_kriteria_count > 0 ? 'info' : 'secondary' }}">
                                    {{ $item->sub_kriteria_count }} pilihan
                                </span>
                            </td>
                            <td class="text-end">
                                <button wire:click="detail({{ $item->id_kriteria }})" class="btn btn-sm btn-secondary">Detail</button>
                                <button wire:click="manageSub({{ $item->id_kriteria }})" class="btn btn-sm btn-info">Sub Kriteria</button>
                                <button wire:click="edit({{ $item->id_kriteria }})" class="btn btn-sm btn-warning">Edit</button>
                                <button wire:click="delete({{ $item->id_kriteria }})" class="btn btn-sm btn-danger">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-pagination :items="$this->kriteria" />
    </div>
</div>
