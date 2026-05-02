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

                                    <div class="row">

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="nama">Phone</label>
                                                <input wire:model="form.phone" type="text"
                                                    class="form-control" id="nama" @if ($currentState === \App\Enums\State::SHOW) disabled @endif>
                                                @error('form.phone')
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
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NISN Siswa</th>
                        <th>Nama Siswa</th>
                        <th>Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswaList as $item)
                        <tr wire:key="{{ $item->id }}">
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $item->nisn }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->skor }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
