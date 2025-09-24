    <!-- Login Section -->
    <section class="login-section">
        <div class="container">
            <div class="row align-items-center">

                <!-- Bagian Kanan: Login Card Lama -->
                <div class="col-md-6" style="animation-delay: 0.2s;">
                    <div class="login-card">
                        <h2 class="login-title text-center mb-4">Login ke CacaoCare</h2>
                        <x-flash-message />
                        <form wire:submit="submit">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input wire:model="email" type="email" class="form-control" id="email" name="email">
                                @error('email')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input wire:model="password" type="password" class="form-control" id="password" name="password">
                                @error('password')
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>

                <!-- Bagian Kiri: Deskripsi -->
                <div class="col-md-6">
                    <h3 class="section-title mb-4">CacaoCare</h3>
                    <p><b>CacaoCare</b> adalah aplikasi berbasis web yang membantu petani mendiagnosis hama dan penyakit tanaman kakao berdasarkan gejala yang muncul. Dengan dukungan metode Forward Chaining dan Dempster-Shafer, sistem ini memberikan solusi cepat dan akurat, terutama bagi petani yang sulit mengakses penyuluh pertanian. Kami hadir untuk mempermudah perawatan tanaman kakao secara mandiri dan berkelanjutan.</p>
                    <a href="{{ route('konsultasi')}}" class="btn btn-primary mt-3" wire:navigate>Mulai Konsultasi</a>
                </div>
            </div>
        </div>
    </section>
