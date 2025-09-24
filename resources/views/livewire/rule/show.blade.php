@props(['hide' => ''])

@php

$classes = $hide ? 'd-none' : 'd-block';

@endphp

<div {{ $attributes->merge(['class' => $classes])}} >
    <div class="card">

        <div class="card-header">
            <h4 class="card-title">Gejala Penyakit {{ $penyakit->nama ?? ''}}</h4>
        </div>

        <div class="card-body">

            @if (isset($penyakit))
            <ul>

                @foreach ($penyakit->gejala as $gejala)
                <li>
                    {{ $gejala->kode . ' - ' . $gejala->nama}}
                    <span class="badge bg-light-success">{{ $gejala->pivot->bobot}}</span>
                </li>
                @endforeach

            </ul>
            @endif

            <x-flash-message/>

        </div>
    </div>
</div>
