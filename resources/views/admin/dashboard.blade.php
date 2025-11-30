@extends('layouts.admin')

@section('title_page', 'Dashboard Administrador')

@section('content')
<div class="container-fluid py-3">

    {{-- 🔹 Título --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">
                <i class="fas fa-tachometer-alt me-2 text-primary"></i> Panel de Administración
            </h1>
            <small class="text-muted">Resumen general de la Biblioteca Híbrida</small>
        </div>
    </div>

    {{-- 🔹 Tarjetas de métricas (Usuarios, Libros, Reservas) --}}
    <div class="row g-3 mb-4">
        {{-- Total Usuarios --}}
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label mb-1">Usuarios registrados</p>
                        <h3 class="stat-value mb-0">{{ $totalUsuarios }}</h3>
                    </div>
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('admin.usuarios.index') }}" class="stat-link">
                        Gestionar usuarios <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Total Libros Físicos --}}
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label mb-1">Libros físicos</p>
                        <h3 class="stat-value mb-0">{{ $totalLibrosFisicos }}</h3>
                    </div>
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('admin.libros_fisicos.index') }}" class="stat-link">
                        Ver catálogo físico <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Total Libros Virtuales --}}
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label mb-1">Libros virtuales</p>
                        <h3 class="stat-value mb-0">{{ $totalLibrosVirtuales }}</h3>
                    </div>
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('admin.libros_virtuales.index') }}" class="stat-link">
                        Ver biblioteca digital <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Reservas Activas --}}
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="stat-label mb-1">Reservas activas</p>
                        <h3 class="stat-value mb-0">{{ $totalReservasActivas }}</h3>
                    </div>
                    <div class="stat-icon bg-danger-subtle text-danger">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('admin.reservas.index') }}" class="stat-link">
                        Ver reservas <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 Últimos préstamos físicos --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-semibold">
                    <i class="fas fa-book-reader text-primary me-2"></i>
                    Últimos préstamos físicos
                </h5>
                <small class="text-muted">Movimientos recientes del material físico</small>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive mt-3">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Alumno</th>
                            <th>Libro</th>
                            <th>Fecha salida</th>
                            <th>Fecha devolución</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimosPrestamos as $prestamo)
                            <tr>
                                <td>
                                    {{ $prestamo->usuario->nombres ?? '—' }}
                                    {{ $prestamo->usuario->apellidos ?? '' }}
                                </td>
                                <td>{{ $prestamo->libroFisico->titulo ?? '—' }}</td>
                                <td>
                                    {{ $prestamo->fecha_salida ? $prestamo->fecha_salida->format('d/m/Y') : '—' }}
                                </td>
                                <td>
                                    {{ $prestamo->fecha_devolucion_programada ? $prestamo->fecha_devolucion_programada->format('d/m/Y') : '—' }}
                                </td>
                                <td>
                                    @if($prestamo->estado == 'PENDIENTE')
                                        <span class="badge rounded-pill text-bg-warning">Pendiente</span>
                                    @elseif($prestamo->estado == 'DEVUELTO')
                                        <span class="badge rounded-pill text-bg-success">Devuelto</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-danger">Mora</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    No hay préstamos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
/* ========================================================
   🌈 TARJETAS DE RESUMEN CON COLORES (SIN CAMBIAR HTML)
======================================================== */

/* Contenedor principal de las tarjetas */
.row.g-3.mb-4 > div:nth-child(1) .stat-card {
    /* Usuarios registrados – CELESTE PASTEL */
    background: linear-gradient(135deg, #D7EEFF, #B6E4FF) !important;
    box-shadow: 0 12px 25px rgba(0, 140, 255, 0.22) !important;
}

.row.g-3.mb-4 > div:nth-child(2) .stat-card {
    /* Libros físicos – TURQUESA PASTEL */
    background: linear-gradient(135deg, #C8FFF4, #A0F0E2) !important;
    box-shadow: 0 12px 25px rgba(0, 200, 150, 0.22) !important;
}

.row.g-3.mb-4 > div:nth-child(3) .stat-card {
    /* Libros virtuales – AMARILLO SUAVE */
    background: linear-gradient(135deg, #FFF4CC, #FFE9A1) !important;
    box-shadow: 0 12px 25px rgba(255, 205, 75, 0.22) !important;
}

.row.g-3.mb-4 > div:nth-child(4) .stat-card {
    /* Reservas activas – ROSA PASTEL */
    background: linear-gradient(135deg, #FFE1EB, #FFCCDD) !important;
    box-shadow: 0 12px 25px rgba(255, 120, 150, 0.22) !important;
}

/* ========================================================
   🔮 EFECTO HOVER – SÚPER SUAVE Y BONITO
======================================================== */
.stat-card {
    transition: transform .25s ease, box-shadow .25s ease;
    border-radius: 1.8rem !important;
}

.stat-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 20px 35px rgba(0,0,0,0.15) !important;
}

/* ========================================================
   ✨ ICONOS BOYFRIEND PASTEL GLOW
======================================================== */
.stat-icon {
    background: rgba(255, 255, 255, 0.6) !important;
    backdrop-filter: blur(10px);
    border-radius: 1.2rem !important;
    box-shadow: 0 4px 15px rgba(255,255,255,0.6),
                inset 0 2px 4px rgba(255,255,255,0.8);
    transition: .3s ease;
}

.stat-card:hover .stat-icon {
    transform: scale(1.08);
}

/* ========================================================
   🎀 TEXTOS MÁS BONITOS
======================================================== */
.stat-label {
    color: #05445E !important;
    font-weight: 700 !important;
    letter-spacing: .05em;
    text-transform: uppercase;
}

.stat-value {
    color: #032F3E !important;
    font-weight: 900 !important;
    font-size: 2.3rem !important;
}

/* ===========================================
   TABLA TURQUESA PROFESIONAL
=========================================== */
.table thead {
    background: linear-gradient(135deg, var(--celeste), var(--turquesa)) !important;
    color: var(--azul-profundo) !important;
    font-weight: 700;
    font-size: 0.9rem;
}

.table tbody tr:hover {
    background: #e9fcff !important;
}

/* Badges pastel */
.badge.text-bg-warning {
    background: #ffefc2 !important;
    color: #8a6f00 !important;
}

.badge.text-bg-success {
    background: #c1ffe8 !important;
    color: #0a7d54 !important;
}

.badge.text-bg-danger {
    background: #ffd8d8 !important;
    color: #b83232 !important;
}

</style>
@endpush
