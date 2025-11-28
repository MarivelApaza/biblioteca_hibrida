<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Alumno - Biblioteca Híbrida')</title>

    {{-- Bootstrap 5.3 + Font Awesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- CSS personalizado --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <style>
        :root {
            --alumno-bg: #f3f4f6;
            --alumno-navbar-bg: #0f172a;
            --alumno-navbar-accent: #22c55e;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--alumno-bg);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .alumno-shell {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* NAVBAR */
        .alumno-navbar {
            background: radial-gradient(circle at top left, #1d4ed8, #0f172a 55%);
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.55);
        }

        .alumno-navbar .navbar-brand {
            display: flex;
            align-items: center;
            gap: .55rem;
            font-weight: 700;
            font-size: .95rem;
            letter-spacing: .02em;
            color: #e5e7eb;
        }

        .alumno-brand-icon {
            width: 34px;
            height: 34px;
            border-radius: .9rem;
            background: radial-gradient(circle at 30% 0, #22c55e, #0ea5e9 45%, #020617 95%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f9fafb;
            box-shadow: 0 10px 22px rgba(15, 23, 42, .65);
        }

        .alumno-navbar .nav-link {
            font-weight: 500;
            font-size: .88rem;
            color: #e5e7eb !important;
            opacity: .85;
            position: relative;
            transition: opacity .15s ease, color .15s ease;
        }

        .alumno-navbar .nav-link.active {
            opacity: 1;
            color: #fbbf24 !important;
        }

        .alumno-user-chip {
            display: inline-flex;
            align-items: center;
            padding: .28rem .75rem;
            border-radius: 999px;
            background: rgba(15, 23, 42, .6);
            border: 1px solid rgba(148, 163, 184, .5);
        }

        .alumno-user-name {
            color: #e5e7eb;
            font-size: .8rem;
            max-width: 140px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* contenido */
        .alumno-main {
            flex: 1;
            padding: 1.8rem;
        }

        .alumno-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* librito de apuntes */
        .librito {
            background: #fff;
            border-radius: .5rem;
            box-shadow: 0 8px 24px rgba(0,0,0,.15);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .librito h4 {
            border-bottom: 1px solid #ddd;
            padding-bottom: .5rem;
            margin-bottom: 1rem;
        }

        .librito p {
            white-space: pre-wrap;
        }

        /* FOOTER */
        .alumno-footer {
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
            font-size: .8rem;
            color: #6b7280;
        }
    </style>

    @stack('styles')
    @yield('scripts')
</head>
<body>
<div class="alumno-shell">

    {{-- NAVBAR SUPERIOR --}}
    <nav class="navbar navbar-expand-lg navbar-dark alumno-navbar">
        <div class="container-fluid px-3 px-lg-4">

            {{-- Marca --}}
            <a class="navbar-brand" href="{{ route('alumno.dashboard') }}">
                <div class="alumno-brand-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <span>Biblioteca Virtual</span>
                    <small class="d-block">Panel Alumno</small>
                </div>
            </a>

            {{-- Toggle móvil --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarAlumno">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Menú --}}
            <div class="collapse navbar-collapse" id="navbarAlumno">

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('alumno.dashboard') ? 'active' : '' }}"
                           href="{{ route('alumno.dashboard') }}">
                            <i class="fas fa-gauge"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('alumno.catalogo.*') ? 'active' : '' }}"
                           href="{{ route('alumno.catalogo.index') }}">
                            <i class="fas fa-book"></i> Catálogo
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('alumno.reservas.*') ? 'active' : '' }}"
                           href="{{ route('alumno.reservas.index') }}">
                            <i class="fas fa-calendar-alt"></i> Reservas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('alumno.accesos.*') ? 'active' : '' }}"
                           href="{{ route('alumno.accesos.index') }}">
                            <i class="fas fa-file-pdf"></i> Accesos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('alumno.favoritos.*') ? 'active' : '' }}"
                           href="{{ route('alumno.favoritos.index') }}">
                            <i class="fas fa-star"></i> Favoritos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('alumno.apuntes.*') ? 'active' : '' }}"
                           href="{{ route('alumno.apuntes.index') }}">
                            <i class="fas fa-sticky-note"></i> Apuntes
                        </a>
                    </li>

                    {{-- Usuario + Logout --}}
                    <li class="nav-item dropdown ms-lg-2">

                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                           href="#" data-bs-toggle="dropdown">

                            <div class="alumno-user-chip">
                                <i class="fas fa-user-graduate me-1"></i>
                                <span class="alumno-user-name d-none d-sm-inline">
                                    {{ auth()->user()->nombres ?? 'Alumno' }}
                                </span>
                            </div>

                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li>
                                <a class="dropdown-item text-danger d-flex align-items-center gap-2"
                                   href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form-alumno').submit();">
                                    <i class="fas fa-right-from-bracket"></i> Cerrar sesión
                                </a>

                                <form id="logout-form-alumno"
                                      action="{{ route('alumno.logout') }}"
                                      method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>

        </div>
    </nav>

    {{-- CONTENIDO --}}
    <main class="alumno-main">
        <div class="alumno-inner">
            @yield('content')
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="alumno-footer text-center py-3">
        <small>
            &copy; {{ date('Y') }} <strong>Biblioteca Virtual</strong> — Panel de alumno.
        </small>
    </footer>

</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>
