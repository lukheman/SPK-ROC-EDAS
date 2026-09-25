<div>
    @if (($terverifikasi ?? false) && ($lolos ?? false))

    <div class="alert alert-light-success">
Selamat! Anda dinyatakan DITERIMA sebagai penerima Program Indonesia Pintar (PIP) berdasarkan hasil verifikasi kepala sekolah / pusat. Semoga bantuan ini dapat menunjang semangat belajar dan mendukung keberhasilan Anda di sekolah.
    </div>

    @elseif (($terverifikasi ?? false) && ! ($lolos ?? false))

    <div class="alert alert-light-danger">

Terima kasih telah mengikuti proses seleksi Program Indonesia Pintar (PIP). Mohon maaf, pengajuan Anda DITOLAK berdasarkan hasil verifikasi kepala sekolah / pusat. Tetap semangat belajar dan terus berprestasi untuk kesempatan berikutnya.
    </div>

    @elseif ($lolos)

    <div class="alert alert-light-warning">
Selamat! Anda LOLOS seleksi admin dan masuk daftar rekomendasi. Status akhir Anda masih MENUNGGU verifikasi kepala sekolah / pusat.
    </div>

    @else

    <div class="alert alert-light-danger">

Terima kasih telah mengikuti proses seleksi Program Indonesia Pintar (PIP). Mohon maaf, saat ini Anda belum dapat diterima sebagai penerima PIP. Tetap semangat belajar dan terus berprestasi untuk kesempatan berikutnya.
    </div>

    @endif
</div>
