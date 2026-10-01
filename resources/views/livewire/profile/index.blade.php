<div>

    @if (auth('admin')->check() || auth('kepala_sekolah')->check())

    <livewire:profile.pengguna />
    @elseif(auth('siswa')->check())
    <livewire:profile.siswa />

    @endif

</div>
