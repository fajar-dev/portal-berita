<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Admin {{ \App\Models\Setting::get('site_name', 'NusaKini') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300..800&family=Plus+Jakarta+Sans:wght@300..800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            background: #f8f9fb; color: #1e2330;
            display: flex; align-items: center; justify-content: center;
            min-height: 100vh; padding: 20px;
        }
        .login-wrap { width: 100%; max-width: 380px; }
        .login-brand {
            text-align: center; margin-bottom: 32px;
        }
        .login-brand-logo {
            font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 800;
            color: hsl(354, 70%, 48%); letter-spacing: -.3px;
        }
        .login-brand-logo em { font-style: normal; color: #1e2330; }
        .login-brand p { font-size: .85rem; color: #6b7185; margin-top: 6px; }
        .login-card {
            background: #fff; border: 1px solid #e8eaef; border-radius: 16px;
            padding: 32px; box-shadow: 0 4px 16px rgba(0,0,0,.05);
        }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; margin-bottom: 6px; font-weight: 600; font-size: .85rem; }
        .form-control {
            width: 100%; padding: 11px 14px; border: 1px solid #e8eaef; border-radius: 10px;
            font-family: inherit; font-size: .9rem; transition: all .2s ease;
        }
        .form-control:focus { outline: none; border-color: hsl(354, 70%, 48%); box-shadow: 0 0 0 3px hsl(354, 80%, 96%); }
        .btn-login {
            width: 100%; padding: 12px; border: none; border-radius: 10px;
            background: hsl(354, 70%, 48%); color: #fff;
            font-family: inherit; font-size: .9rem; font-weight: 700;
            cursor: pointer; transition: all .2s ease; margin-top: 4px;
        }
        .btn-login:hover { background: hsl(354, 70%, 42%); }
        .remember-row { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
        .remember-row label { font-size: .82rem; color: #6b7185; cursor: pointer; }
        .remember-row input { accent-color: hsl(354, 70%, 48%); }
        .alert-error {
            background: #fef2f2; color: #dc2626; padding: 12px 14px; border-radius: 10px;
            margin-bottom: 18px; font-size: .85rem; border: 1px solid rgba(220,38,38,.12);
        }
    </style>
</head>
<body>
    <div class="login-wrap">
        <div class="login-brand">
            @php $siteLogo = \App\Models\Setting::get('site_logo'); @endphp
            @if($siteLogo)
                <img src="{{ asset($siteLogo) }}" alt="{{ \App\Models\Setting::get('site_name', 'NusaKini') }}" style="max-height: 40px; margin-bottom: 8px;">
            @else
                <div class="login-brand-logo">{{ \App\Models\Setting::get('site_name', 'NusaKini') }}</div>
            @endif
            <p>Masuk ke panel administrasi</p>
        </div>

        <div class="login-card">
            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="admin@nusakini.com">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••">
                </div>
                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat saya</label>
                </div>
                <button type="submit" class="btn-login">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>
