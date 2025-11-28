<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Administrador - Biblioteca Híbrida')</title>

    {{-- Bootstrap 5.3 + Font Awesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- CSS personalizado --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
     @stack('styles')

    <style>
        :root {
            --admin-bg: #f3f4f6;
            --admin-sidebar-bg: #0f172a;
            --admin-sidebar-accent: #1d4ed8;
            --admin-sidebar-text: #e5e7eb;
            --admin-navbar-bg: #ffffff;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--admin-bg);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .admin-shell {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* SIDEBAR */
        .admin-sidebar {
            width: 250px;
            background: radial-gradient(circle at top left, #1d4ed8, #0f172a 55%);
            color: var(--admin-sidebar-text);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            height: 100vh;
            padding: 1rem;
            box-shadow: 4px 0 18px rgba(15, 23, 42, 0.45);
            z-index: 1030;
            transition: transform .3s ease;
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: .6rem;
            margin-bottom: 1.5rem;
            padding-bottom: .9rem;
            border-bottom: 1px solid rgba(148, 163, 184, .35);
        }

        .admin-brand-icon {
            width: 38px;
            height: 38px;
            border-radius: .9rem;
            background: radial-gradient(circle at 30% 0, #eab308, #f97316 40%, #0f172a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f9fafb;
            box-shadow: 0 10px 20px rgba(15, 23, 42, .6);
        }

        .admin-menu {
            flex: 1;
            overflow-y: auto;
        }

        .admin-menu-section-title {
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .18em;
            color: #9ca3af;
            margin-bottom: .35rem;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: .55rem;
            padding: .45rem .7rem;
            border-radius: .65rem;
            color: #cbd5f5;
            font-size: .88rem;
            text-decoration: none;
            margin-bottom: .15rem;
            transition: 0.15s ease;
        }

        .admin-nav-link:hover {
            background: rgba(15, 23, 42, .55);
            color: #ffffff;
        }

        .admin-nav-link.active {
            background: linear-gradient(90deg, #1d4ed8, #22c55e);
            color: #ffffff;
            box-shadow: 0 10px 20px rgba(15, 23, 42, .6);
        }

        .admin-sidebar-footer {
            margin-top: 1rem;
            border-top: 1px solid rgba(148, 163, 184, .35);
            padding-top: .75rem;
            font-size: .8rem;
            color: #9ca3af;
        }

        /* MAIN */
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: 250px;
            padding: 1.5rem 2rem;
            transition: margin-left .3s ease;
        }

        .admin-navbar {
            background: var(--admin-navbar-bg);
            border-bottom: 1px solid #e5e7eb;
        }

        .admin-page-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
        }

        .admin-footer {
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
            font-size: .8rem;
            color: #6b7280;
            padding: 1rem;
            text-align: center;
        }
    </style>
</head>

<body>
<div class="admin-shell" id="adminShell">

    {{-- SIDEBAR --}}
    <aside class="admin-sidebar">
        <div class="admin-brand">
            <div class="admin-brand-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <div>
                <span class="fw-bold">Biblioteca virtual</span><br>
                <small>Administración</small>
            </div>
        </div>

        <div class="admin-menu">

            <div class="admin-menu-section-title">General</div>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-gauge"></i> Dashboard
            </a>

            <div class="admin-menu-section-title mt-3">Gestión</div>

            <a href="{{ route('admin.usuarios.index') }}" class="admin-nav-link {{ request()->is('admin/usuarios*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Usuarios
            </a>

            <a href="{{ route('admin.categorias.index') }}" class="admin-nav-link {{ request()->is('admin/categorias*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Categorías
            </a>

            <a href="{{ route('admin.libros_fisicos.index') }}" class="admin-nav-link {{ request()->is('admin/libros_fisicos*') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Libros Físicos
            </a>

            <a href="{{ route('admin.libros_virtuales.index') }}" class="admin-nav-link {{ request()->is('admin/libros_virtuales*') ? 'active' : '' }}">
                <i class="fas fa-book-open"></i> Libros Virtuales
            </a>

            <a href="{{ route('admin.reservas.index') }}" class="admin-nav-link {{ request()->is('admin/reservas*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Reservas
            </a>

            <a href="{{ route('admin.prestamos_fisicos.index') }}" class="admin-nav-link {{ request()->is('admin/prestamos_fisicos*') ? 'active' : '' }}">
                <i class="fas fa-hand-holding"></i> Préstamos
            </a>

            <div class="admin-menu-section-title mt-4">Reportes</div>
            <a href="{{ route('admin.reportes.index') }}" class="admin-nav-link {{ request()->is('admin/reportes*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Reportes
            </a>
        </div>

        <div class="admin-sidebar-footer">
            <span><i class="fas fa-circle text-success me-1" style="font-size:.5rem"></i> Conectado</span>
            <span>{{ auth()->user()->nombres ?? 'Admin' }}</span>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="admin-main">

        {{-- NAVBAR --}}
        <nav class="navbar navbar-expand-lg admin-navbar px-3">
            <button class="btn btn-outline-secondary d-lg-none me-2" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <span class="navbar-brand d-none d-lg-block">Panel de administración</span>

            <div class="ms-auto d-flex align-items-center">
                <span class="me-3 d-none d-md-inline">
                    {{ auth()->user()->nombres ?? 'Administrador' }}
                </span>

                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item">
                                    <i class="fas fa-right-from-bracket me-2"></i> Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        {{-- TITLE --}}
        <header class="admin-page-header">
            <h1>@yield('title_page', View::yieldContent('title', 'Panel de Administración'))</h1>
        </header>

        {{-- CONTENT --}}
        <main class="admin-content">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer class="admin-footer">
            &copy; {{ date('Y') }} <strong>Biblioteca Híbrida</strong>. Todos los derechos reservados.
        </footer>

    </div>
</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById('sidebarToggle')?.addEventListener('click', () => {
    document.getElementById('adminShell').classList.toggle('sidebar-open');
});
</script>

@stack('scripts')

{{-- ⭐ AQUÍ DEBEN IR LOS SCRIPTS DE GRÁFICOS --}}
@yield('charts')

</body>
</html>
