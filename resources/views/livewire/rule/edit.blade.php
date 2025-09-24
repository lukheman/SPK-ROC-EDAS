@props(['hide' => ''])

@php

$classes = $hide ? 'd-none' : 'd-block';

@endphp

<div {{ $attributes->merge(['class' => $classes])}}>

    <div class="card" wire:show="edit_state === 'bobot'">

        <div class="card-header">
            <div class="row">

                <div class="col-6">
                    <h4 class="card-title">Edit Gejala Penyakit {{ $nama_penyakit ?? ''}}</h4>
                </div>

                <div class="col-6 d-flex justify-content-end">
                    <button x-on:click="$wire.edit_state = 'normal'" class="btn btn-warning">Pilih Gejala</button>
                </div>

            </div>
        </div>

        <div class="card-body">

            <form>
                @if (isset($penyakit))

                    @foreach ($penyakit->gejala as $index => $gejala)
                    <div class="form-group mb-3">
                        <span> {{ $gejala->kode . ' - ' . $gejala->nama }} </span>
                        <div class="row">
                        <div class="col-3">
                        <input type="number" wire:model="bobots.{{ $index }}.bobot" class="form-control" step="0.01">
                        </div>
                        </div>
                    </div>
                    @endforeach

                @endif
            </form>

            <div class="row">

                <div class="col-12 d-flex justify-content-end">

                    <button wire:click="updateBobotGejala" class="btn btn-warning" type="button">Simpan Perubahan</button>

                </div>
            </div>

            <x-flash-message/>
        </div>

    </div>

    <div class="card" wire:show="edit_state === 'normal'">

        <div class="card-header">
            <div class="row">

                <div class="col-6">
                    <h4 class="card-title">Edit Gejala Penyakit {{ $nama_penyakit ?? ''}}</h4>
                </div>

                <div class="col-6 d-flex justify-content-end">
                    <button x-on:click="$wire.edit_state = 'bobot'" class="btn btn-warning">Atur bobot</button>
                </div>

            </div>

        </div>

        <div class="card-body">

            <form>

                <ul class="list-unstyled">
                    @if (isset($gejala_penyakit_all))


                    @foreach ($gejala_penyakit_all as $gejala)

                    <li class="mb-2">
                        <div class="checkbox form-check form-check-lg">
                            <input wire:model="id_gejala_terpilih" id="gejala-{{ $gejala->id }}" value="{{ $gejala->id }}" type="checkbox" class="form-check-input">
                            <label for="gejala-{{ $gejala->id }}" class="ms-2 mt-1"> {{ $gejala->kode . ' - ' . $gejala->nama }} </label>
                        </div>
                    </li>

                    @endforeach

                    @endif
                </ul>


                <div class="row">

                    <div class="col-12 d-flex justify-content-end">

                        <button wire:click="updateGejala" class="btn btn-warning" type="button">Simpan Perubahan</button>

                    </div>
                </div>
            </form>

        </div>



    </div>
</div>
