<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Biblioteca Virtual PPD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e40af, #fb923c);
            background-size: 300% 300%;
            animation: mover 10s ease infinite;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        @keyframes mover {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .register-card {
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            background: rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(16px);
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.26);
        }

        .register-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            color: white;
            margin-bottom: 1.3rem;
        }

        .glass-input {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: none;
            background: rgba(255,255,255,0.85);
            margin-top: 5px;
            font-size: 1rem;
        }

        .btn-register {
            margin-top: 1rem;
            width: 100%;
            background: #fb923c;
            padding: 14px;
            border: none;
            color: white;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-register:hover {
            background: #ff8a1f;
        }

        .link-login {
            text-align: center;
            display: block;
            color: #ffe4c8;
            margin-top: 12px;
            text-decoration: none;
        }

        .link-login:hover {
            color: white;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="register-card">
        <h2 class="register-title">Crear Cuenta</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nombre -->
            <label class="text-white">Nombre Completo</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="glass-input">

            <!-- Email -->
            <label class="text-white">Correo Electrónico</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="glass-input">

            <!-- Contraseña -->
            <label class="text-white">Contraseña</label>
            <input type="password" name="password" required class="glass-input">

            <!-- Confirmación -->
            <label class="text-white">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" required class="glass-input">

            <!-- Botón -->
            <button type="submit" class="btn-register">Crear Cuenta</button>
        </form>

        <a href="{{ route('login') }}" class="link-login">
            ¿Ya tienes cuenta? Inicia sesión
        </a>
    </div>

</body>
</html>
