<div>

    @if (auth('pengguna')->check())

    <livewire:profile.pengguna />
    @elseif(auth('siswa')->check())
    <livewire:profile.siswa />

    @endif

</div>
