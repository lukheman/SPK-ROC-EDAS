@push('styles')

<style>
.glass-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
}
.glass-card input::placeholder,
.glass-card textarea::placeholder {
    color: rgba(255, 255, 255, 0.6);
}
</style>

@endpush
<!-- Register Section -->
<section id="register" class="section">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold text-white">Daftar Akun Siswa Baru</h2>
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <!-- Glass Card -->
                <div class="glass-card p-4 animate__animated animate__fadeInUp">
                    <div class="card-body">
                        <form wire:submit.prevent="register">
                            @csrf

                            <!-- NISN -->
                            <div class="mb-3">
                                <label for="nisn" class="form-label fw-semibold text-white">
                                    <i class="bi bi-credit-card-2-front me-1 text-info"></i> NISN
                                </label>
                                <input type="text" id="nisn" wire:model="nisn" class="form-control form-control-lg rounded-3 bg-transparent text-white border-light" placeholder="Masukkan NISN" required>
                                @error('nisn') <small class="text-warning">{{ $message }}</small> @enderror
                            </div>

                            <!-- Nama -->
                            <div class="mb-3">
                                <label for="nama" class="form-label fw-semibold text-white">
                                    <i class="bi bi-person-fill me-1 text-info"></i> Nama Lengkap
                                </label>
                                <input type="text" id="nama" wire:model="nama" class="form-control form-control-lg rounded-3 bg-transparent text-white border-light" placeholder="Masukkan nama lengkap" required>
                                @error('nama') <small class="text-warning">{{ $message }}</small> @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label fw-semibold text-white">
                                    <i class="bi bi-telephone-fill me-1 text-info"></i> Nomor Telepon
                                </label>
                                <input type="text" id="phone" wire:model="phone" class="form-control form-control-lg rounded-3 bg-transparent text-white border-light" placeholder="Masukkan nomor telepon" required>
                                @error('phone') <small class="text-warning">{{ $message }}</small> @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-white">
                                    <i class="bi bi-gender-ambiguous me-1 text-info"></i> Jenis Kelamin
                                </label>
                                <select id="jenis_kelamin" wire:model="jenis_kelamin" class="form-control form-control-lg rounded-3 bg-transparent text-white border-light" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                @error('jenis_kelamin') <small class="text-warning">{{ $message }}</small> @enderror
                            </div>

                            <!-- Alamat -->
                            <div class="mb-3">
                                <label for="alamat" class="form-label fw-semibold text-white">
                                    <i class="bi bi-house-door-fill me-1 text-info"></i> Alamat
                                </label>
                                <textarea id="alamat" wire:model="alamat" class="form-control form-control-lg rounded-3 bg-transparent text-white border-light" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
                                @error('alamat') <small class="text-warning">{{ $message }}</small> @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label fw-semibold text-white">
                                    <i class="bi bi-calendar-date-fill me-1 text-info"></i> Tanggal Lahir
                                </label>
                                <input type="date" id="tanggal_lahir" wire:model="tanggal_lahir" class="form-control form-control-lg rounded-3 bg-transparent text-white border-light" required>
                                @error('tanggal_lahir') <small class="text-warning">{{ $message }}</small> @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold text-white">
                                    <i class="bi bi-lock-fill me-1 text-info"></i> Kata Sandi
                                </label>
                                <input type="password" id="password" wire:model="password" class="form-control form-control-lg rounded-3 bg-transparent text-white border-light" placeholder="Masukkan kata sandi" required>
                                @error('password') <small class="text-warning">{{ $message }}</small> @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label fw-semibold text-white">
                                    <i class="bi bi-lock-fill me-1 text-info"></i> Konfirmasi Kata Sandi
                                </label>
                                <input type="password" id="password_confirmation" wire:model="password_confirmation" class="form-control form-control-lg rounded-3 bg-transparent text-white border-light" placeholder="Ulangi kata sandi" required>
                            </div>

                            <!-- Button -->
                            <button type="submit" class="btn btn-info w-100 rounded-pill py-2 fw-semibold text-white">
                                <i class="bi bi-person-plus-fill me-1"></i> Daftar
                            </button>
                        </form>
                        <div class="text-center mt-3">
                            <p class="text-light">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none text-info">Masuk sekarang</a></p>
                        </div>
                    </div>
                </div>
                <p class="text-center text-light mt-3 small">
                    &copy; 2025 Tani Pedia
                </p>
            </div>
        </div>
    </div>
</section>

