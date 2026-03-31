<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <style>
        /* ── Reset ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --login-bg-dark: #0A0A0A;
            --login-bg-dark-2: #111827;
            --login-border: rgba(255,255,255,.10);
            --login-text: rgba(255,255,255,.90);
            --login-text-soft: rgba(255,255,255,.60);
            --login-input-bg: rgba(255,255,255,.06);
            --login-input-border: rgba(255,255,255,.10);
            --login-input-focus: rgba(192,57,43,.45);
        }

        body.login-page {
            min-height: 100vh;
            background:
                radial-gradient(ellipse 80% 60% at 20% 20%, rgba(192,57,43,.10) 0%, transparent 60%),
                radial-gradient(ellipse 65% 55% at 80% 80%, rgba(59,130,246,.07) 0%, transparent 60%),
                linear-gradient(135deg, var(--login-bg-dark) 0%, var(--login-bg-dark-2) 50%, var(--login-bg-dark) 100%);
            color: var(--login-text);
            position: relative;
            overflow-x: hidden;
        }

        body.login-page::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,.035) 1px, transparent 0);
            background-size: 32px 32px;
            pointer-events: none;
            z-index: 0;
        }

        /* ── Shell ── */
        .login-shell {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 16px;
        }

        /* ── Login Card ── */
        .login-card {
            width: 100%;
            max-width: 420px;
            border: 1px solid var(--login-border);
            background: rgba(255,255,255,.04);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 12px 40px rgba(0,0,0,.20);
            border-radius: 18px;
            padding: 28px 24px;
            overflow: hidden;
        }

        .login-card__top {
            margin-bottom: 18px;
        }

        .login-card__eyebrow {
            display: inline-block;
            font-size: .68rem;
            font-weight: 600;
            letter-spacing: .10em;
            color: var(--accent);
            background: rgba(192,57,43,.10);
            border: 1px solid rgba(192,57,43,.18);
            padding: 4px 10px;
            border-radius: 999px;
            margin-bottom: 10px;
        }

        .login-card h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.6rem;
            line-height: 1;
            color: #fff;
            margin-bottom: 6px;
            letter-spacing: .02em;
        }

        .login-card__desc {
            color: var(--login-text-soft);
            font-size: .78rem;
            line-height: 1.6;
        }

        /* ── Form ── */
        .form-group {
            margin-bottom: 14px;
        }

        .form-label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            color: rgba(255,255,255,.80);
            margin-bottom: 5px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            font-size: .9rem;
            color: rgba(255,255,255,.40);
            pointer-events: none;
        }

        .form-input {
            display: block;
            width: 100%;
            height: 42px;
            border-radius: 10px;
            border: 1px solid var(--login-input-border);
            background: var(--login-input-bg);
            color: #fff;
            padding: 0 14px 0 38px;
            font-size: .85rem;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: .25s ease;
            box-sizing: border-box;
        }

        .form-input::placeholder {
            color: rgba(255,255,255,.32);
        }

        .form-input:focus {
            border-color: var(--login-input-focus);
            box-shadow: 0 0 0 3px rgba(192,57,43,.10);
            background: rgba(255,255,255,.07);
        }

        /* Captcha */
        .captcha-row {
            display: flex;
            align-items: stretch;
            gap: 8px;
        }

        .captcha-box {
            flex: 1;
            min-height: 42px;
            border-radius: 10px;
            border: 1px solid var(--login-input-border);
            background: rgba(255,255,255,.96);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 3px 8px;
        }

        .captcha-box img {
            display: block;
            max-width: 100%;
            height: 36px;
        }

        .captcha-refresh {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            border: 1px solid var(--login-input-border);
            background: rgba(255,255,255,.07);
            color: rgba(255,255,255,.65);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: .25s ease;
            flex-shrink: 0;
            cursor: pointer;
        }

        .captcha-refresh:hover {
            background: rgba(255,255,255,.12);
            color: #fff;
            transform: translateY(-1px);
        }

        /* Errors & Alerts */
        .form-error {
            margin-top: 4px;
            font-size: .74rem;
            color: #ffb4b4;
        }

        .alert {
            border-radius: 10px;
            padding: 10px 12px;
            font-size: .78rem;
            margin-bottom: 12px;
        }

        .alert-danger {
            background: rgba(239,68,68,.10);
            border: 1px solid rgba(239,68,68,.18);
            color: #fecaca;
        }

        .alert-success {
            background: rgba(34,197,94,.10);
            border: 1px solid rgba(34,197,94,.18);
            color: #bbf7d0;
        }

        /* Button */
        .btn-login {
            width: 100%;
            justify-content: center;
            height: 42px;
            border-radius: 10px;
            font-size: .85rem;
            margin-top: 4px;
        }

        /* Footer */
        .login-footer {
            margin-top: 16px;
            text-align: center;
            color: var(--login-text-soft);
            font-size: .72rem;
        }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            .login-shell {
                padding: 16px 10px;
            }

            .login-card {
                padding: 22px 18px;
                border-radius: 14px;
            }
        }
    </style>
</head>
<body class="login-page">

    <section class="login-shell">
            <div class="login-card">    
                <div class="login-card__top">
                    <span class="login-card__eyebrow">Admin Panel</span>
                    <h2>Ronas Website</h2>
                    <p class="login-card__desc">
                        Login dengan akun admin untuk melanjutkan ke dashboard.
                    </p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="padding-left:16px; margin:0;">
                            @foreach ($errors->all() as $error)
                                <li style="margin:2px 0;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('auth') }}">
                    @csrf

                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-wrap">
                            <i class="ti ti-user"></i>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                class="form-input"
                                placeholder="Masukkan username"
                                value="{{ old('username') }}"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrap">
                            <i class="ti ti-lock"></i>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-input"
                                placeholder="Masukkan password"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Captcha</label>
                        <div class="captcha-row">
                            <div class="captcha-box" id="captchaImage">
                                {!! captcha_img('math') !!}
                            </div>

                            <button
                                type="button"
                                id="refreshCaptchaBtn"
                                class="captcha-refresh"
                                title="Refresh captcha"
                                aria-label="Refresh captcha"
                            >
                                <i class="ti ti-refresh"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-wrap">
                            <i class="ti ti-calculator"></i>
                            <input
                                type="text"
                                id="captcha"
                                name="captcha"
                                class="form-input"
                                placeholder="Contoh: 12"
                                required
                            >
                        </div>
                        @error('captcha')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn--accent btn-login">
                        <i class="ti ti-login-2"></i>
                        Login
                    </button>
                </form>

                <div class="login-footer">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Company') }}. All rights reserved.
                </div>
            </div>
    </section>

    <script>
        document.getElementById('refreshCaptchaBtn').addEventListener('click', function () {
            fetch("{{ route('captcha') }}", {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('captchaImage').innerHTML = data.captcha;
            })
            .catch(error => {
                console.error('Captcha refresh error:', error);
            });
        });
    </script>
</body>
</html>