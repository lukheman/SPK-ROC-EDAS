<div>
    <style>
        /* Login Page Specific Styles - Light Theme */
        .login-section {
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5rem 1rem 2rem;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            animation: fadeInUp 0.8s ease;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.3);
        }

        .login-icon i {
            font-size: 2.5rem;
            color: white;
        }

        .login-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #1a1a2e;
        }

        .login-header p {
            color: #718096;
            font-size: 0.95rem;
        }

        .login-card {
            background: white;
            border-radius: 24px;
            padding: 2.5rem;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
        }

        .login-card .form-floating {
            margin-bottom: 1.25rem;
        }

        .login-card .form-control {
            background: #f8f9fa;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 14px;
            color: #1a1a2e;
            height: 58px;
            padding: 1rem 1rem 0.5rem 3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .login-card .form-control:focus {
            background: #fff;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
            color: #1a1a2e;
        }

        .login-card .form-control::placeholder {
            color: transparent;
        }

        .login-card .form-floating label {
            color: #718096;
            padding-left: 3rem;
            font-size: 0.9rem;
        }

        .login-card .form-control:focus~label,
        .login-card .form-control:not(:placeholder-shown)~label {
            color: #667eea;
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
        }

        .login-card .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 1.25rem;
            z-index: 5;
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .login-card .form-floating:focus-within .input-icon {
            color: #667eea;
        }

        .login-card .input-wrapper {
            position: relative;
        }

        .login-card .error-message {
            color: #e53e3e;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .login-card .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 14px;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
        }

        .login-card .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .login-card .btn-login:active {
            transform: translateY(0);
        }

        .login-card .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .login-card .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
            color: #a0aec0;
            font-size: 0.85rem;
        }

        .login-card .divider::before,
        .login-card .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(0, 0, 0, 0.1);
        }

        .login-card .register-link {
            text-align: center;
            color: #4a5568;
            font-size: 0.95rem;
        }

        .login-card .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-card .register-link a:hover {
            color: #764ba2;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card .btn-login .spinner-border {
            width: 1.25rem;
            height: 1.25rem;
            border-width: 2px;
        }

        @media (max-width: 576px) {
            .login-section {
                padding: 6rem 1rem 2rem;
            }

            .login-card {
                padding: 1.75rem;
            }

            .login-icon {
                width: 70px;
                height: 70px;
            }

            .login-icon i {
                font-size: 2rem;
            }
        }
    </style>

    <!-- Login Section -->
    <section class="login-section">
        <div class="login-container">
            <!-- Login Header -->
            <div class="login-header">
                <div class="login-icon">
                    <i class="bi bi-person-circle"></i>
                </div>
                <h2>Selamat Datang</h2>
                <p>Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <!-- Login Card -->
            <div class="login-card">
                <x-flash-message />

                <form wire:submit.prevent="submit">
                    <!-- Email Input -->
                    <div class="input-wrapper">
                        <i class="bi bi-envelope-fill input-icon"></i>
                        <div class="form-floating">
                            <input type="text" class="form-control @error('identifier') is-invalid @enderror" id="email"
                                wire:model="identifier" placeholder="Email">
                            <label for="email">Email Address</label>
                        </div>
                        @error('identifier')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="input-wrapper">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <div class="form-floating">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" wire:model="password" placeholder="Password">
                            <label for="password">Password</label>
                        </div>
                        @error('password')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn btn-login" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="submit">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Masuk
                        </span>
                        <span wire:loading wire:target="submit">
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                            Memproses...
                        </span>
                    </button>
                </form>

                <!-- Register Link -->
            </div>
        </div>
    </section>
</div>
