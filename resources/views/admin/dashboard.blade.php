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

    /* ============================
       🎨 TARJETA PRINCIPAL
    ============================ */
    .stat-card {
        background: linear-gradient(135deg, #d8f3ff, #ccf7ef) !important;
        border-radius: 1.3rem !important;
        border: 1px solid #b8e9ff !important;
        box-shadow: 0 8px 18px rgba(0,0,0,0.08) !important;
        transition: .3s ease !important;
    }

    .stat-card:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 14px 25px rgba(0,0,0,0.16) !important;
    }

    /* ============================
       🎨 ICONOS PASTELES
    ============================ */
    .stat-card .stat-icon {
        background: #ffffffaa !important;
        color: #067a8f !important;
        border-radius: 1rem !important;
        width: 55px !important;
        height: 55px !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ============================
       🎨 VALORES
    ============================ */
    .stat-card .stat-value {
        color: #034452 !important;
        font-size: 2.2rem !important;
        font-weight: 800 !important;
    }

    /* ============================
       🎨 ETIQUETAS
    ============================ */
    .stat-card .stat-label {
        color: #066c7e !important;
        text-transform: uppercase;
        letter-spacing: .06em;
        font-size: .78rem !important;
        font-weight: 700 !important;
    }

    /* ============================
       🎨 TABLA CELESTE–TURQUESA
    ============================ */
    table.table thead {
        background: #bcefff !important;
        color: #064663 !important;
        border-bottom: 2px solid #a6e3f0 !important;
    }

    table.table tbody tr:hover {
        background: #e8fcff !important;
    }

    /* BADGES PASTELES */
    .badge.text-bg-warning {
        background: #ffe8a8 !important;
        color: #8a6100 !important;
    }

    .badge.text-bg-success {
        background: #c7fce5 !important;
        color: #0f7d4a !important;
    }

    .badge.text-bg-danger {
        background: #ffd4d4 !important;
        color: #b83232 !important;
    }

    /* ============================
       🎨 TARJETA DE PRÉSTAMOS
    ============================ */
    .card {
        border-radius: 1.3rem !important;
        border: none !important;
        background: #ffffffee !important;
        box-shadow: 0 6px 15px rgba(0,0,0,0.08) !important;
        backdrop-filter: blur(6px) !important;
    }

    .card-header {
        background: linear-gradient(135deg, #d6f7ff, #d2fff2) !important;
        color: #04445c !important;
        border-radius: 1.3rem 1.3rem 0 0 !important;
    }

    .card-header h5 {
        font-weight: 700 !important;
        color: #033b47 !important;
    }

    /* ============================
       🎨 TÍTULOS PRINCIPALES
    ============================ */
    h1.h3 {
        color: #04445c !important;
        font-weight: 900 !important;
    }

    .text-muted {
        color: #066c7e !important;
        opacity: .7 !important;
    }

</style>
@endpush
