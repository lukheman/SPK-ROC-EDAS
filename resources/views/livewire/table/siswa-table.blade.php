@php

use App\Enums\State;

@endphp
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
                                        Tambah Siswa
                                    @elseif ($currentState === \App\Enums\State::UPDATE)
                                        Perbarui Siswa
                                    @elseif ($currentState === \App\Enums\State::SHOW)
                                        Detail Siswa
                                    @endif
                                </h5>
                            </div>
                            <div class="modal-body">
<form>
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label for="nisn">NISN Siswa</label>
                <input wire:model="form.nisn" type="text" class="form-control" id="nisn" 

                    @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                @error('form.nisn')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="col-8">
            <div class="form-group">
                <label for="nama">Nama Siswa</label>
                <input wire:model="form.nama" type="text"
                    class="form-control" id="nama"
                    @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                @error('form.nama')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-12">
            <div class="form-group">
                <label for="phone">Phone</label>
                <input wire:model="form.phone" type="text"
                    class="form-control" id="phone"
                    @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                @error('form.phone')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    {{-- Tambahan field --}}
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select wire:model="form.jenis_kelamin"
                    class="form-control" id="jenis_kelamin"
                    @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
                @error('form.jenis_kelamin')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input wire:model="form.tanggal_lahir" type="date"
                    class="form-control" id="tanggal_lahir"
                    @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                @error('form.tanggal_lahir')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea wire:model="form.alamat"
            class="form-control" id="alamat" rows="2"
            @if ($currentState === \App\Enums\State::SHOW) disabled @endif></textarea>
        @error('form.alamat')
            <small class="text-danger">{{ $message }}</small>
        @enderror
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

                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" wire:model.live="search" class="form-control" placeholder="Cari Siswa..."
                        aria-label="Recipient's username" aria-describedby="button-addon2">
                </div>
            </div>

            <div class="col-6 d-flex justify-content-end align-items-start flex-wrap gap-2">
                <a href="{{ route('siswa-template') }}" class="btn btn-outline-success">
                    <i class="bi bi-file-earmark-arrow-down"></i> Template
                </a>
                <a href="{{ route('siswa-export') }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Export
                </a>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bi bi-file-earmark-arrow-up"></i> Import
                </button>
                <button wire:click="add" class="btn btn-primary">Tambah Siswa</button>
            </div>
        </div>
    </div>

    {{-- Import Modal --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg rounded-3">
                <form action="{{ route('siswa-import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="importModalLabel">
                            <i class="bi bi-file-earmark-arrow-up"></i> Import Data Siswa
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            Download <a href="{{ route('siswa-template') }}" class="fw-bold">template Excel</a> terlebih dahulu, isi data sesuai format, kemudian upload file-nya di sini.
                        </div>
                        <div class="form-group">
                            <label for="importFile" class="form-label">Pilih File Excel</label>
                            <input type="file" name="file" id="importFile" class="form-control"
                                accept=".xlsx,.xls,.csv" required>
                            <small class="text-muted">Format yang didukung: .xlsx, .xls, .csv (Maks. 10MB)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-upload"></i> Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NISN Siswa</th>
                        <th>Nama Siswa</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->Siswa as $item)
                        <tr wire:key="{{ $item->id }}">
                            <td scope="row">{{ $loop->index + $this->siswa->firstItem() }}</td>
                            <td>{{ $item->nisn }}</td>
                            <td>{{ $item->nama }}</td>
                            <td class="text-end">

                                <button wire:click="detail({{ $item->id_siswa }})" class="btn btn-sm btn-info">Lihat</button>
                                    <button wire:click="edit({{ $item->id_siswa }})"
                                        class="btn btn-sm btn-warning" type="button">Edit</button>
                                    <button wire:click="delete({{ $item->id_siswa }})"
                                        class="btn btn-sm btn-danger" type="button">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-pagination :items="$this->siswa" />
    </div>
</div>
