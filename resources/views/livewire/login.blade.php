@push('styles')

<style>
/* Glass effect untuk card login */
.glass-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
}
.glass-card input::placeholder {
    color: rgba(255, 255, 255, 0.6);
}
</style>

@endpush
<!-- Login Section -->
<section id="login" class="section">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold text-white">Masuk Ke Aplikasi</h2>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <!-- Glass Card -->
<div class="glass-card p-4 animate__animated animate__fadeInUp">
    <div class="card-body">
        <x-flash-message />
        <form wire:submit.prevent="submit">
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold text-white">
                    <i class="bi bi-envelope-fill me-1 text-info"></i> Email
                </label>
                <input type="text" class="form-control form-control-lg rounded-3 bg-transparent text-white border-light"
                       id="email" wire:model="identifier" placeholder="Masukkan email">
                @error('identifier')
                    <small class="text-warning">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold text-white">
                    <i class="bi bi-lock-fill me-1 text-info"></i> Password
                </label>
                <input type="password" class="form-control form-control-lg rounded-3 bg-transparent text-white border-light"
                       id="password" wire:model="password" placeholder="Masukkan password">
                @error('password')
                    <small class="text-warning">{{ $message }}</small>
                @enderror
            </div>

            <!-- Button Login -->
            <button type="submit" class="btn btn-info w-100 rounded-pill py-2 fw-semibold text-white mb-2">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </button>

            <!-- Link Register -->
            <div class="text-center mt-3">
                <span class="text-white">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="fw-semibold text-info ms-1">
                    Daftar di sini
                </a>
            </div>
        </form>
    </div>
</div>
                <p class="text-center text-light mt-3 small">
                    &copy; 2025 SMAN 1 Tanggetada
                </p>
            </div>
        </div>
    </div>
</section>


