<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Biblioteca Virtual PPD</title>

    <!-- Bootstrap y Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        /* Paleta institucional */
        :root {
            --primary: #1e40af;
            --primary-light: #3b82f6;
            --accent: #fb923c;
            --bg: #f8fafc;
        }

        /* Fondo general */
        body {
            background: linear-gradient(to bottom right, #1e40af, #fb923c);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-size: 400% 400%;
            animation: moverFondo 10s ease infinite;
        }

        @keyframes moverFondo {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Tarjeta estilo glass */
        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 2.8rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 18px;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.2);
            color: #fff;
            animation: aparecer 0.7s ease-out;
        }

        @keyframes aparecer {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Título */
        .login-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 1.8rem;
        }

        /* Inputs */
        .form-control {
            height: 52px;
            border-radius: 12px;
            border: none;
            background: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 .25rem rgba(59, 130, 246, 0.5);
        }

        /* Labels */
        .form-label {
            font-weight: 600;
            color: #fff;
        }

        /* Botón */
        .btn-login {
            background: var(--accent);
            border: none;
            color: #fff;
            padding: 0.85rem;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            letter-spacing: 0.5px;
            transition: 0.3s ease;
        }

        .btn-login:hover {
            background: #ff8c1a;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        /* Link registro */
        .link-muted {
            color: #ffe7d1;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .link-muted:hover {
            text-decoration: underline;
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h2 class="login-title">Biblioteca Virtual PPD</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- DNI -->
            <div class="mb-4">
                <label class="form-label">DNI</label>
                <input id="dni" type="text" class="form-control" name="dni" value="{{ old('dni') }}" required>
                @error('dni')
                    <small class="text-warning">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="form-label">Contraseña</label>
                <input id="password" type="password" class="form-control" name="password" required>
                @error('password')
                    <small class="text-warning">{{ $message }}</small>
                @enderror
            </div>

            <!-- Remember me -->
            <div class="mb-3">
                <label class="text-white" style="font-size: 0.9rem;">
                    <input type="checkbox" name="remember"> Recordarme
                </label>
            </div>

            <!-- Botón ingresar -->
            <button type="submit" class="btn btn-login">Ingresar</button>

        </form>

        <div class="text-center mt-3">
            <a href="{{ route('register') }}" class="link-muted">¿No tienes cuenta? Regístrate</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
