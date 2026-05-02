@php

use App\Enums\State;

@endphp
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">

                <!-- Modal Form -->
                <div class="modal fade" id="{{ $idModal }}" tabindex="-1" wire:ignore.self>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                        <div class="modal-content shadow-lg rounded-3">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title text-white" id="myModalLabel1">
                                    Data Penilaian Siswa
                                </h5>
                                <button type="button" class="close rounded-pill"
                                    wire:click="$dispatch('closeModal', {id: 'modal-form-siswa'})">
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
        @foreach ($this->kriteriaList as $index => $kriteria)
            <div class="col-6 {{ $index > 1 ? 'mt-2' : '' }}">
                <div class="form-group">
                    <label for="kriteria_{{ $kriteria->id_kriteria }}">
                        {{ $kriteria->nama }}
                        <span class="badge bg-{{ $kriteria->tipe === 'benefit' ? 'success' : 'warning' }} ms-1" style="font-size: 0.7em;">
                            {{ ucfirst($kriteria->tipe) }}
                        </span>
                    </label>

                    @if ($kriteria->subKriteria->count() > 0)
                        {{-- Dropdown for kriteria with sub kriteria --}}
                        <select wire:model="form.nilai.{{ $kriteria->id_kriteria }}"
                            class="form-control" id="kriteria_{{ $kriteria->id_kriteria }}"
                            @if ($currentState === State::SHOW) disabled @endif>
                            <option value="0">-- Pilih --</option>
                            @foreach ($kriteria->subKriteria as $sub)
                                <option value="{{ $sub->nilai }}">{{ $sub->nama }} (Nilai: {{ $sub->nilai }})</option>
                            @endforeach
                        </select>
                    @else
                        {{-- Number input for kriteria without sub kriteria --}}
                        <input wire:model="form.nilai.{{ $kriteria->id_kriteria }}" type="number"
                            class="form-control" id="kriteria_{{ $kriteria->id_kriteria }}"
                            @if ($currentState === State::SHOW) disabled @endif>
                    @endif

                    @error("form.nilai.{$kriteria->id_kriteria}")
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>
</form>
                            </div>
                            <div class="modal-footer">
                                    <button type="button" wire:click="save"
                                        class="btn btn-primary">Simpan</button>
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
                    @foreach ($this->siswa as $item)
                        <tr wire:key="{{ $item->id_siswa }}">
                            <td scope="row">{{ $loop->index + $this->siswa->firstItem() }}</td>
                            <td>{{ $item->nisn }}</td>
                            <td>{{ $item->nama }}</td>

                            <td class="text-end">

                                <button wire:click="alternatif({{ $item->id_siswa }})" class="btn btn-sm btn-info">Beri Nilai</button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-pagination :items="$this->siswa" />

    </div>
</div>
